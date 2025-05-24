<?php

namespace Src\Controller;

use \Core\Service\Log;

class Auth extends \Core\Controller\Auth
{

  public static function protect()
  {

    // ICI AUSSI LE BUT EST DE SAVOIR SI UN REFRESH TOKEN EXISTE EN BASE
    self::initSession();

    if (!isset($_SESSION["access_key"])) {
      \Src\App::redirect("login");
      exit();
    }

    ob_start();
    require ROOT . "/config/env/publickey.crt";
    $key = ob_get_contents();
    ob_end_clean();

    try {
      $decoded = \Firebase\JWT\JWT::decode($_SESSION["access_key"], new \Firebase\JWT\Key($key, "RS256"));
    } catch (\Exception $e) {
      \Src\App::redirect("login");
      exit();
    }
  }

  public static function auth(string $email, string $pwd)
  {
    $db = \Src\App::db();
    $res = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_mail", $email);

    if ($res && password_verify($pwd, $res["profile_password"])) {

      if ($res["role_id"] == 1) {

        self::initSession();

        if (!isset($_SESSION["access_key"])) {
          $_SESSION["access_key"] = self::newJWToken($res);
        }

        if (!isset($_SESSION["delete_key"])) {
          $_SESSION["delete_key"] = self::generateDeleteToken();
        }

        $response = [
          'success' => true,
          'message' => 'Utilisateur connecté'
        ];

        Log::writeLog("L'administrateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");

      } else {
        $response = [
          'success' => false,
          'message' => "Échec de la connexion : Vous n'etes pas autorisé à vous connecter."
        ];
      }

    } else {
      $response = [
        'success' => false,
        'message' => 'Échec de la connexion : email ou mot de passe incorrect.'
      ];
    }

    return $response;
  }
}