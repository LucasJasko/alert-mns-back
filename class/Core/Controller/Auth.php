<?php

namespace core\controller;

use \Core\Service\Log;
use \Firebase\JWT\JWT;

class Auth
{
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

        self::isSession() ? "" : session_start();
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
          'message' => "Vous n'etes pas autorisé à vous connecter."
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

  protected function checkAuth(string $email, string $pwd)
  {
    return $this->db->getFieldsWhereAnd("profile", ["profile_id", "profile_password", "role_id", "profile_name", "profile_surname"], "profile_mail", $email, "profile_password", $pwd);
  }

  public static function protect()
  {
    self::isSession() ? "" : session_start();
    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] != "OK") {
      \Src\App::redirect("login");
      exit();
    }
  }

  public static function initSession()
  {
    session_start();
  }

  public static function isSession()
  {
    return session_status() == 2 ? true : false;
  }

  public static function setAccessToken(array $data)
  {
    if ($_SESSION && !$_SESSION["access_key"]) {
      $_SESSION["access_key"] = JWT::encode($data, JWT_SECRET_KEY, "RS256");
    }
  }

  public static function sessionToken()
  {
    return $_SESSION["access_key"];
  }

  public static function setDeleteToken()
  {
    if ($_SESSION && !$_SESSION["delete_key"]) {
      $_SESSION["delete_key"] = bin2hex(random_bytes(32));
    }
  }
  public static function deleteToken()
  {
    return isset($_SESSION["delete_key"]) ? $_SESSION["delete_key"] : "";
  }
}
