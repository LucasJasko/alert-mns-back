<?php

namespace Src\Api;

use \Core\Service\Log;

class Auth extends \Core\Controller\Auth
{
  private $accessKey;
  private $id;

  public function dispatch($isApi)
  {


    if ($isApi) {

      http_response_code(200);
      $this->apiProtect();

    } else {
      http_response_code(401);
    }

  }

  public function apiProtect()
  {
    $data = \Src\App::clientData();

    var_dump($data);

    $this->accessKey = $data["access_key"];
    $this->id = $data["id"];

    if (!isset($this->accessKey)) {
      echo json_encode("erreur, accessToken non défini.");
      exit();
    }

    $db = \Src\App::db();

    if ($res = $db->getFieldWhere("token", "token_value", "profile_id", $this->id)) {
      // $unhash = password_verify($res["token_value"]);

      // $decoded = \Firebase\JWT\JWT::decode($this->accessKey, new \Firebase\JWT\Key($unhash, "RS256"));
      // var_dump($decoded);
    }


  }

  public function decode()
  {
    ob_start();
    require ROOT . "/config/env/publickey.crt";
    $key = ob_get_contents();
    ob_end_clean();

    try {
      $decoded = \Firebase\JWT\JWT::decode($this->accessKey, new \Firebase\JWT\Key($key, "RS256"));
      var_dump($decoded);
    } catch (\Exception $e) {
    }
  }

  public function apiAuth($email, $pwd)
  {
    $db = \Src\App::db();
    $res = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_mail", $email);

    if ($res && password_verify($pwd, $res["profile_password"])) {

      $refreshToken = password_hash(self::newJWToken($res), PASSWORD_DEFAULT);
      $accessToken = self::newJWToken($res);

      $oldToken = $db->getAllWhereAnd("token", "token_user_agent", $_SERVER["HTTP_USER_AGENT"], "profile_id", $res["profile_id"]);

      if ($oldToken) {
        $db->deleteAllWhereAnd("token", "token_user_agent", $_SERVER["HTTP_USER_AGENT"], "profile_id", $res["profile_id"]);
      }

      $token = new \Src\Entity\Token();
      $token->createNewModel("token", [
        "token_value" => $refreshToken,
        "token_expiration_time" => time() + 2592000, // 30 jours
        "token_creation_time" => time(),
        "token_user_agent" => $_SERVER["HTTP_USER_AGENT"],
        "profile_id" => $res["profile_id"],
      ]);
      // TODO faire une fonction de comparaison du temps actuel avec les temps d'expiration des token de la table token, et supprimé ceux expirés

      Log::writeLog("L'utilisateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");

      $res = [
        'success' => true,
        'message' => 'Utilisateur connecté',
        "data" => [
          "accessToken" => $accessToken,
          "deleteToken" => self::generateDeleteToken(),
          "UID" => $res["profile_id"]
        ]
      ];
      //  TODO configurer le front et le back pour correspondre au même sous-domaine (par exemple alert-mns et api.alert-mns) et ainsi pouvoir utiliser sameSite en Stric
      $this->setClientCookie("access_key", $accessToken);
      $this->setHttpOnlyCookie("refresh_key", $refreshToken);

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