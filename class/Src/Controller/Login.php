<?php

namespace Src\Controller;

class Login
{

  private $auth;

  public function __construct()
  {
    $this->auth = new \core\controller\Auth();
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
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/login.php";
  }
}
