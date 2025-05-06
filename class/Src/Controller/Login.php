<?php

namespace Src\Controller;

class Login
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

  public function redirect($page)
  {
    header("Location:/index.php?page=" . $page);
  }

  public function getLoginPage()
  {
    require ROOT . "/pages/login.php";
  }
}
