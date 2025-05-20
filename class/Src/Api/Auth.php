<?php

namespace Src\Api;

class Auth extends \Core\Controller\Auth
{

  public function clientAuth($data)
  {
    if ($data) {
      $email = htmlspecialchars($data["email"]);
      $pwd = htmlspecialchars($data["password"]);

      $res = $this->checkAuth($email, $pwd);
    }

    if ($res && $pwd == $res["profile_password"]) {

      if (self::isSession()) {
        session_unset();
        session_destroy();
      }

      self::initSession();
      $_SESSION["logged"] = "OK";
      \Core\Service\Log::writeLog("L'utilisateur [" . $res["profile_id"] . "] " . $res["profile_name"] . " " . $res["profile_surname"] . " s'est connecté.");
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
}