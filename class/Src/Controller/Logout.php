<?php

namespace Src\Controller;

class Logout
{

  public function logout()
  {
    session_destroy();
    $this->redirect("login");
  }

  public function redirect($page)
  {
    header("Location:/index.php?page=" . $page);
  }
}
