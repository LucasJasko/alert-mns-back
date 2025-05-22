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

      // TODO problème de connexion au back office
      if (isset($_POST["email"]) && isset($_POST["password"])) {
        // TODO Gérer les cas d'utilisateur non admin, rediriger vers login

        $res = \Src\Controller\Auth::auth($_POST["email"], $_POST["password"]);

        if ($res["success"]) {

          \Src\App::redirect("profile");

        } else {

          return $res;
        }
      } else {
        require ROOT . "/pages/login.php";
      }

    }

  }
}
