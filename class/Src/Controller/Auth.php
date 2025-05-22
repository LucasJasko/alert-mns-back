<?php

namespace Src\Controller;

use \Core\Service\Log;

class Auth extends \Core\Controller\Auth
{

  public static function apiAuth($data)
  {
    if ($data) {
      $email = htmlspecialchars($data["email"]);
      $pwd = htmlspecialchars($data["password"]);

      $db = \Src\App::db();
      $res = $db->getFieldsWhereAnd("profile", ["role_id", "profile_password"], "profile_mail", $email, "profile_password", $pwd);
    }

    // TODO password_verify($res, $res["profile_password"]);
    if ($res && $pwd == $res["profile_password"]) {

      if (self::isSession()) {
        session_unset();
        session_destroy();
      }

      self::initSession();
      $_SESSION["logged"] = "OK";
      Log::writeLog("L'utilisateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");
      $res = [
        'success' => true,
        'message' => 'Utilisateur connecté'
      ];

    } else {
      $res = [
        'success' => false,
        'message' => 'Échec de la connexion : email ou mot de passe incorrect.'
      ];
    }

    echo json_encode($res);
  }

  public static function auth(string $email, string $pwd)
  {
    $db = \Src\App::db();
    $res = $db->getMultipleWhere("profile", ["profile_id", "profile_password", "profile_name", "profile_surname", "role_id"], "profile_mail", $email);

    if ($res && password_verify($pwd, $res["profile_password"])) {

      if ($res["role_id"] == 1) {

        self::initSession();
        self::setAccessToken($res);
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