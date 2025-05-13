<?php

namespace Src\Controller;

class Login extends \Src\Controller\Controller
{

  private $auth;

  public function __construct()
  {
    $this->auth = new \Core\Controller\Auth();
  }

  public function checkAuth(string $email, string $pwd)
  {
    $res = $this->auth->tryLogin($email, $pwd);
    if ($res["success"]) {
      $this->redirect("profile");
    } else {
      $err = "Email ou mot de passe incorrect";
      return $err;
    }
  }

  public function checkClientAuth(string $email, string $pwd)
  {
    http_response_code(200);
    return $this->auth->tryClientLogin($email, $pwd);
  }



  public function getLoginPage()
  {
    require ROOT . "/pages/login.php";
  }
}
