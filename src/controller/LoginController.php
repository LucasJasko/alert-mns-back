<?php

namespace src\controller;

class LoginController
{

  private $auth;

  public function __construct()
  {
    $this->auth = new \core\model\Auth();
  }

  public function checkAuth(string $email, string $pwd)
  {
    $res = $this->auth->login($email, $pwd);
    if ($res["success"]) {
      header("Location:/index.php?page=user");
    } else {
      $err = "Email ou mot de passe incorrect";
      return $err;
    }
  }

  public function getLoginPage()
  {
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/login.php";
  }
}
