<?php

namespace Src\Controller;

use \Core\Service\Log;

class Auth extends \Core\Controller\Auth
{

  public static function auth(string $email, string $pwd)
  {
    $db = \Src\App::db();
    $res = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_mail", $email);

    if ($res && password_verify($pwd, $res["profile_password"])) {

      if ($res["role_id"] == 1) {

        self::initSession();

        if (!isset($_SESSION["access_key"])) {
          $_SESSION["access_key"] = self::setAccessToken($res);
        }

        self::setDeleteToken();

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