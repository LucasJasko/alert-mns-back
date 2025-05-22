<?php

namespace Src\Controller;

class Login extends \Src\Controller\Controller
{

  private $auth;

  public function dispatch(bool $isApi)
  {

    if ($isApi) {

      $data = \Src\App::clientData();
      http_response_code(200);

      if (!empty($data["email"] && !empty($data["password"]))) {
        \Src\Controller\Auth::apiAuth($data);
      }

    } else {

      if (isset($_POST["email"]) && isset($_POST["password"])) {

        $res = \Src\Controller\Auth::auth($_POST["email"], $_POST["password"]);

        if ($res["success"]) {

          \Src\App::redirect("profile");

        } else {

          $err = $res["message"];
          require ROOT . "/pages/login.php";

        }
      } else {
        require ROOT . "/pages/login.php";
      }

    }

  }
}
