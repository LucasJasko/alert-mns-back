<?php

namespace Src\Controller;

class Logout extends \Src\Controller\Controller
{

  public function logout()
  {
    session_destroy();
    \Src\App::redirect("login");
  }

  public function dispatch()
  {
    \Core\Controller\Auth::protect();
    $this->logout();
  }
}
