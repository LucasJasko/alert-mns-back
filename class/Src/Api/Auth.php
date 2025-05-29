<?php

namespace Src\Api;

use \Core\Service\Log;

class Auth extends \Core\Auth\Auth
{

  public function dispatch($isApi)
  {

    if ($isApi) {

      $this->newAccessKey();

    } else {
      http_response_code(403);
    }

  }

  public static function protect()
  {
    if (isset($_COOKIE["refresh_key"])) {

      $refreshToken = hash("sha256", self::decodeJWT($_COOKIE["refresh_key"]));

      $db = \Src\App::db();
      if ($res = $db->getMultipleWhere("token", ["token_value", "token_user_agent", "token_remote_host"], "token_value", $refreshToken)) {

        if ($refreshToken === $res["token_value"]) {

          if (password_verify($_SERVER["HTTP_USER_AGENT"], $res["token_user_agent"])) {

            if (password_verify($_SERVER["REMOTE_HOST"], $res["token_remote_host"])) {

              http_response_code(200);
              return true;

            }
          }
        }
      }
    }

    http_response_code(403);
    return false;
  }

  public function newAccessKey()
  {
    if (self::protect()) {

      $refreshToken = hash("sha256", self::decodeJWT($_COOKIE["refresh_key"]));

      $db = \Src\App::db();
      $res = $db->getMultipleWhere("token", ["profile_id"], "token_value", $refreshToken);

      echo json_encode([
        "accessToken" => self::newJWToken($res),
        "UID" => $res["profile_id"],
        "deleteToken" => self::generateDeleteToken(),
      ]);

    } else {

      if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {

        http_response_code(204);

      } else {

        http_response_code(403);

      }
    }
  }

  public function apiAuth($email, $pwd)
  {
    $db = \Src\App::db();
    $res = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_mail", $email);

    if ($res && password_verify($pwd, $res["profile_password"])) {

      $refreshToken = self::newJWToken([base64_encode(random_bytes(64))]);

      // TODO ici la récuération des token existant se fait sur un recherche sans valeurs haché alors qu'elles le sont côté base
      if ($oldToken = $db->getAllWhereAnd("token", "token_user_agent", $_SERVER["HTTP_USER_AGENT"], "token_remote_host", $_SERVER["REMOTE_HOST"])) {
        $db->deleteAllWhereAnd("token", "token_user_agent", $_SERVER["HTTP_USER_AGENT"], "token_remote_host", $_SERVER["REMOTE_HOST"]);
      }

      $token = new \Src\Model\Entity\Token();
      // TODO ici il semblerait que sha256 ne génère pas les mêmes hachage pour une même valeur, à vérifier...
      $token->createNewToken(hash("sha256", $refreshToken), $res["profile_id"]);

      $this->setHttpOnlyCookie("refresh_key", $refreshToken);

      // TODO faire une fonction de comparaison du temps actuel avec les temps d'expiration des token de la table token, et supprimé ceux expirés

      Log::writeLog("L'utilisateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");


      $res = [
        'success' => true,
        'message' => 'Utilisateur connecté',
        "data" => [
          "accessToken" => self::newJWToken($res),
          "UID" => $res["profile_id"],
          "deleteToken" => self::generateDeleteToken(),
        ]
      ];

    } else {
      $res = [
        'success' => false,
        'message' => 'Échec de la connexion : email ou mot de passe incorrect.'
      ];
    }

    echo json_encode($res);
  }

  public function setHttpOnlyCookie($name, $value)
  {
    setcookie(
      $name,
      $value,
      [
        "expires" => time() + 2592000, // 30 jours
        "path" => "/",
        "domain" => "speak",
        "secure" => false,
        "httponly" => true,
        "samesite" => "Strict",
      ]
    );
  }

  public function setClientCookie($name, $value, $expirationTime)
  {
    setcookie(
      $name,
      $value,
      [
        "expires" => time() + $expirationTime,
        "path" => "/",
        "domain" => "speak",
        "secure" => false,
        "httponly" => false,
        "samesite" => "Strict",
      ]
    );
  }
}