<?php

namespace Src\Api;

use \Core\Service\Log;

class Auth extends \Core\Controller\Auth
{
  private $accessKey;

  public function dispatch($isApi, $apiKey)
  {

    $this->setAccessKey($apiKey);

    if ($isApi) {

      $this->apiProtect();

    } else {
      echo "Chemin inconnu";
    }

  }

  public function apiProtect()
  {

    if (!isset($this->accessKey)) {
      echo json_encode("erreur, accessToken non défini coté serveur");
      exit();
    }

    ob_start();
    require ROOT . "/config/env/publickey.crt";
    $key = ob_get_contents();
    ob_end_clean();

    try {
      $decoded = \Firebase\JWT\JWT::decode($this->accessKey, new \Firebase\JWT\Key($key, "RS256"));
    } catch (\Exception $e) {
      echo json_encode("erreur: " . $e);
      exit();
    }
  }

  public function apiAuth($data)
  {

    if ($data) {
      $email = htmlspecialchars($data["email"]);
      $pwd = htmlspecialchars($data["password"]);

      $db = \Src\App::db();
      $res = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_mail", $email);
    }

    if ($res && password_verify($pwd, $res["profile_password"])) {

      Log::writeLog("L'utilisateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");
      $res = [
        'success' => true,
        'message' => 'Utilisateur connecté',
        "data" => [
          "accessToken" => self::setAccessToken($res),
          "deleteToken" => self::setDeleteToken(),
          "UID" => $res["profile_id"]
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

  public function setAccessKey($accessKey)
  {
    $this->accessKey = $accessKey;
  }

  public function setHttpCookie($apiKey)
  {
    setcookie(
      "auth_key",
      $apiKey,
      [
        "expires" => time() + 3600,
        "path" => "/",                     // Chemin
        "domain" => "tondomaine.com",     // (laisser vide en local)
        "secure" => false,                 // true pour HTTPS
        "httponly" => true,               // Inaccessible depuis JS
        "samesite" => "Strict"            // Pour éviter CSRF
      ]
    );
  }
}