<?php

namespace class\core;

class Auth
{

  private $db;
  private array $response;

  public function __construct()
  {
    $this->db = new Database("alertmns");
  }

  public function login($email, $pwd)
  {
    $row = $this->db->fetchUser($email);

    if ($row && $pwd == $row["user_password"]) {
      $this->response = ['success' => true, 'message' => 'Utilisateur connecté'];
      Log::writeLog("Lucas s'est connecté.");
    } else {
      $this->response = ['success' => false, 'message' => 'Échec de la connexion : email ou mot de passe incorrect.'];
    }

    return $this->response;
  }
}
