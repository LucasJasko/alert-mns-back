<?php

namespace Src\Api;

use \Core\Service\Log;

class Auth extends \Core\Controller\Auth
{

  public function dispatch($isApi)
  {

    if ($isApi) {

      $this->newAccessKey();

    } else {
      http_response_code(403);
    }

  }

  public function newAccessKey()
  {
    if (isset($_COOKIE["refresh_key"])) {

      http_response_code(200);
      $refreshKey = self::decodeJWT($_COOKIE["refresh_key"]);

      $id = $refreshKey->data->profile_id;

      $db = \Src\App::db();

      if ($res = $db->getMultipleWhere("token", ["token_value", "profile_id"], "profile_id", $id)) {

        if (password_verify($_COOKIE["refresh_key"], $res["token_value"])) {

          $response = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_id", $res["profile_id"]);

          echo json_encode([
            "accessToken" => self::newJWToken($response),
            "UID" => $res["profile_id"],
            "deleteToken" => self::generateDeleteToken(),
          ]);
        }
      }

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

      $refreshToken = self::newJWToken($res);

      $oldToken = $db->getAllWhereAnd("token", "token_user_agent", $_SERVER["HTTP_USER_AGENT"], "profile_id", $res["profile_id"]);
      if ($oldToken) {
        $db->deleteAllWhereAnd("token", "token_user_agent", $_SERVER["HTTP_USER_AGENT"], "profile_id", $res["profile_id"]);
      }

      $token = new \Src\Entity\Token();
      $token->createNewToken(password_hash($refreshToken, PASSWORD_DEFAULT), $_SERVER["HTTP_USER_AGENT"], $res["profile_id"]);

      // TODO faire une fonction de comparaison du temps actuel avec les temps d'expiration des token de la table token, et supprimé ceux expirés

      Log::writeLog("L'utilisateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");

      $this->setHttpOnlyCookie("refresh_key", $refreshToken);

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
        "expires" => time() + 2592000,
        "path" => "/",
        "domain" => "alert-mns-back",
        "secure" => false,
        "httponly" => true,
        "samesite" => "Strict",
      ]
    );
  }

  public function setClientCookie($name, $value)
  {
    setcookie(
      $name,
      $value,
      [
        "expires" => time() + 2592000,
        "path" => "/",
        "domain" => "alert-mns-back",
        "secure" => false,
        "httponly" => false,
        "samesite" => "Strict",
      ]
    );
  }


}