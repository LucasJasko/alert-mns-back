<?php

namespace core\controller;

use \Core\Service\Log;

class Auth
{
  private array $response;
  private $db;


  public function __construct()
  {
    $this->db = \Src\App::db();
  }

  public function tryLogin(string $email, string $pwd)
  {
    $res = $this->checkAuth($email, $pwd);

    if ($res && $pwd == $res["profile_password"]) {

      if ($res["role_id"] == 1) {

        session_start();
        $_SESSION["logged"] = "OK";
        $this->response = [
          'success' => true,
          'message' => 'Utilisateur connecté'
        ];
        Log::writeLog("L'administrateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");
      } else {
        $this->response = [
          'success' => false,
          'message' => "Vous n'etes pas autorisé à vous connecter."
        ];
      }
    } else {
      $this->response = [
        'success' => false,
        'message' => 'Échec de la connexion : email ou mot de passe incorrect.'
      ];
    }

    return $this->response;
  }

  private function checkAuth(string $email, string $pwd)
  {
    return $this->db->getFieldsWhereAnd("profile", ["profile_id", "profile_password", "role_id", "profile_name", "profile_surname"], "profile_mail", $email, "profile_password", $pwd);
  }

  public function clientLogin()
  {
    // Réception des données client
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if ($data) {
      // TODO manque vérification du contenu de data
      $res = $this->tryLogin(htmlspecialchars($data["profile_mail"]), htmlspecialchars($data["profile_password"]));
      echo json_encode($res);
    }
  }

  public function tryClientLogin(string $email, string $pwd)
  {
    $res = $this->checkAuth($email, $pwd);

    if ($res && $pwd == $res["profile_password"]) {

      session_start();
      $_SESSION["logged"] = "OK";
      Log::writeLog("L'utilisateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");
      return [
        'success' => true,
        'message' => 'Utilisateur connecté'
      ];
    } else {
      return [
        'success' => false,
        'message' => 'Échec de la connexion : email ou mot de passe incorrect.'
      ];
    }
  }

  public static function protect()
  {
    session_start();
    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] != "OK") {
      header("Location:/index.php?page=login");
      exit();
    }
  }
}
