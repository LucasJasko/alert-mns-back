<?php

namespace Src\Controller;

class Login extends \Src\Controller\Controller
{

  public function dispatch(bool $isApi)
  {

    if ($isApi) {

      // TODO voir pourquoi php génère un phpsessid dans les cookies
      // TODO trouver un moyen d'effectuer une suppression côté client car actuellement, seulemenet possible côté back
      // TODO voir ce que sont les private state token dans DevTool

      $data = \Src\App::clientData();

      if (!empty($data["email"] && !empty($data["password"]))) {
        $apiAuth = new \Src\Api\Auth();
        $apiAuth->apiAuth($data["email"], $data["password"]);
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
