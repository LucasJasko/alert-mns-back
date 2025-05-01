<?php

namespace core\controller;

use src\model\Profile;

class Auth
{
  private static array $response;


  public static function login(string $email, string $pwd)
  {
    $manager = new Profile(1);
    $model = $manager->getDBModel(1);
    $row = $model->getUserPassword($email);

    if ($row && $pwd == $row["user_password"]) {
      self::$response = ['success' => true, 'message' => 'Utilisateur connecté'];
      \core\model\Log::writeLog("Lucas s'est connecté.");
    } else {
      self::$response = ['success' => false, 'message' => 'Échec de la connexion : email ou mot de passe incorrect.'];
    }

    return self::$response;
  }

  public static function clientLogin()
  {
    // Réception des données client
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if ($data) {
      $res = Auth::login($data["user_mail"], $data["user_password"]);
      echo json_encode($res);
    }
  }

  public static function getClientAccess()
  {
    // Plutôt que l'étoile il faudra donner l'adresse du client ici
    return [
      header("Access-Control-Allow-Origin: *"),
      header("Access-Control-Allow-Headers: *"),
      header("Content-Type: application/json"),
    ];
  }

  public static function protect()
  {
    self::getClientAccess();
    session_start();

    if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] != "oui") {
      echo json_encode(false);
    } else {
      echo json_encode($_SESSION);
    };
  }
}
