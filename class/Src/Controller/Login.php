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

    if (isset($_POST["email"]) && isset($_POST["password"])) {

      // TODO Gérer les cas d'utilisateur non admin, rediriger vers login
      if ($isApi) {

        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email && !empty($data->password))) {
          $response = $this->checkClientAuth($data->email, $data->password);
          echo json_encode($response);
        }

      } else {

        $this->checkAuth($_POST["email"], $_POST["password"]);

      }

    } else {

      if ($isApi) {

        $obj = [
          "test" => "test",
          "test2" => "testaussi"
        ];
        echo json_encode($obj);

      } else {

        require ROOT . "/pages/login.php";

      }
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
