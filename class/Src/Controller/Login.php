<?php

namespace Src\Controller;

class Login extends \Src\Controller\Controller
{

  private $auth;

  public function __construct()
  {
    $this->auth = new \Core\Controller\Auth();
  }

  public function dispatch(bool $isApi)
  {

    if ($isApi) {

      $data = \Src\App::clientData();

      if (!empty($data->email && !empty($data->password))) {
        $response = $this->checkClientAuth($data->email, $data->password);
        echo json_encode($response);
      }

    } else if (isset($_POST["email"]) && isset($_POST["password"])) {

      // TODO Gérer les cas d'utilisateur non admin, rediriger vers login

      $this->checkAuth($_POST["email"], $_POST["password"]);

    } else {

      require ROOT . "/pages/login.php";

    }

  }

  public function checkAuth(string $email, string $pwd)
  {
    $res = $this->auth->tryLogin($email, $pwd);

    if ($res["success"]) {

      \Src\App::redirect("profile");

    } else {

      return $res;
    }
  }

  public function checkClientAuth(string $email, string $pwd)
  {
    http_response_code(200);
    return $this->auth->tryClientLogin($email, $pwd);
  }
}
