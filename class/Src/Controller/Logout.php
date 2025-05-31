<?php

namespace Src\Controller;

class Logout extends \Src\Controller\Controller
{

  public function dispatch($id, bool $isApi = false)
  {

    if ($isApi) {
      \Src\Api\Auth::protect();
      \Src\Api\Auth::clearCookie("refresh_key");
      return $this->deleteToken($id);
    }

    \Src\Auth\Auth::protect();
    $this->logout();
  }

  public function logout()
  {
    session_destroy();
    \Src\App::redirect("login");
  }


  public function deleteToken($id)
  {
    $this->db->deleteAllWhere("token", "profile_id", $id);
  }

}
