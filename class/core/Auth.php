<?php

namespace core;

use controllers\UserManager;

class Auth
{
  private static array $response;


  public static function login(string $email, string $pwd)
  {
    $manager = new UserManager();
    $row = $manager->getUserPassword($email);

    if ($row && $pwd == $row["user_password"]) {
      self::$response = ['success' => true, 'message' => 'Utilisateur connecté'];
      Log::writeLog("Lucas s'est connecté.");
    } else {
      self::$response = ['success' => false, 'message' => 'Échec de la connexion : email ou mot de passe incorrect.'];
    }

    return self::$response;
  }
}
