<?php

namespace Src\Api;

use \Core\Service\Log;
use \Src\App;

class Auth extends \Core\Auth\Auth
{

  public function dispatch($isApi)
  {

    if ($isApi) {

      if (!self::protect()) {
        self::newAccessKey();
      }

    } else {
      http_response_code(403);
    }

  }

  public static function protect()
  {

    if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
      http_response_code(200);
      exit();
    }

    $req = getallheaders();

    if (!isset($req["Authorization"])) {
      http_response_code(403);
      return false;
    }

    $token = \Core\Auth\Auth::decodeJWT(str_replace("Bearer ", "", $req["Authorization"]));


    if (!$token->iss === "http://speak/" || !$token->aud === "http://speak:3216/auth/") {
      http_response_code(403);
      return false;
    }

    return true;
  }

  public static function validateRefreshToken()
  {
    if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
      exit();
    }

    if (isset($_COOKIE["refresh_key"])) {

      $refreshToken = hash("sha256", $_COOKIE["refresh_key"]);

      $db = App::db();
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
    if (self::validateRefreshToken()) {

      $db = App::db();
      $refreshToken = hash("sha256", $_COOKIE["refresh_key"]);

      $res = $db->getMultipleWhere("token", ["profile_id"], "token_value", $refreshToken);

      $profileData = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_id", $res["profile_id"]);

      App::sendApiData([
        "accessToken" => self::newJWToken($profileData),
        "UID" => $res["profile_id"],
        "deleteToken" => self::generateDeleteToken(),
      ]);

    }
  }

  public function apiAuth($email, $pwd)
  {
    $db = App::db();
    $res = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_mail", $email);

    if ($res && password_verify($pwd, $res["profile_password"])) {

      $refreshToken = self::newJWToken([base64_encode(random_bytes(64))]);

      $this->setHttpOnlyCookie("refresh_key", $refreshToken);

      if ($oldToken = $db->getAllWhere("token", "profile_id", $res["profile_id"])) {
        $db->deleteAllWhere("token", "profile_id", $res["profile_id"]);
      }

      $token = new \Src\Model\Entity\Token();
      $token->insertTokenToBase(hash("sha256", $refreshToken), $res["profile_id"]);


      // TODO faire une fonction de comparaison du temps actuel avec les temps d'expiration des token de la table token, et supprimé ceux expirés

      Log::writeLog("L'utilisateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");


      $res = [
        'message' => 'Utilisateur connecté',
        "accessToken" => self::newJWToken($res),
        "UID" => $res["profile_id"],
        "deleteToken" => self::generateDeleteToken(),
      ];

      http_response_code(200);

    } else {
      $res = [
        'message' => 'Échec de la connexion : email ou mot de passe incorrect.'
      ];

      http_response_code(401);
    }

    App::sendApiData($res);
  }

  public static function clearCookie($name)
  {
    setcookie($name, "", [
      "expires" => time(),
      "path" => "/",
      "domain" => "speak",
      "secure" => false,
      "httponly" => true,
      "samesite" => "Strict",
    ]);
  }
}