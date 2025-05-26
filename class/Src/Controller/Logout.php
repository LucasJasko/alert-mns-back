<?php

namespace Src\Controller;

class Logout extends \Src\Controller\Controller
{

  public function dispatch(bool $isApi)
  {

    if ($isApi) {
      // Protect API
      return;
    }

    \Src\Auth\Auth::protect();
    $this->logout();
  }

  public function logout()
  {
    session_destroy();
    \Src\App::redirect("login");
  }

}
