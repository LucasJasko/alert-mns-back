<?php

namespace Src\Controller;

class Login extends \Src\Controller\Controller
{

  private $auth;

  public function __construct()
  {
    $this->auth = new \Src\Api\Auth();
  }

  public function dispatch(bool $isApi)
  {

    if ($isApi) {

      $data = \Src\App::clientData();
      http_response_code(200);

      if (!empty($data["email"] && !empty($data["password"]))) {
        $this->auth->clientAuth($data);
      }

    } else {

      // TODO problème de connexion au back office
      if (isset($_POST["email"]) && isset($_POST["password"])) {
        // TODO Gérer les cas d'utilisateur non admin, rediriger vers login
        $this->checkAuth($_POST["email"], $_POST["password"]);
      } else {
        require ROOT . "/pages/login.php";
      }

    }

  }

  public function checkAuth(string $email, string $pwd)
  {
    $res = $this->auth->tryLogin($email, $pwd);

    if ($res["success"]) {

      \Src\App::redirect("profile");

    } else {

      return $res;
    }
  }
}
