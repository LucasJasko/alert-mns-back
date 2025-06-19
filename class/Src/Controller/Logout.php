<?php

namespace Src\Controller;

class Logout extends \Src\Controller\Controller
{

  public function dispatch($id, bool $isApi = false)
  {

    if ($isApi) {
      if (!\Src\Api\Auth::protect()) {
        http_response_code(403);
        exit();
      }

      \Src\Api\Auth::clearCookie("refresh_key");
      $this->deleteToken($id);

      return \Src\App::sendApiData("ok");
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
