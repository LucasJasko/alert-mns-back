<?php

require_once "../class/Src/App.php";

use \Src\App;
use \core\controller\Auth;

App::init();
// Init le routeur aussi à terme

if (!isset($_GET["api"])) {

  $page = isset($_GET["page"]) ? $_GET["page"] : "login";

  switch ($page) {

    case "group":

      Auth::protect();
      $controller = new Src\Controller\Group();

      if ($_POST) {
        $controller->submitData($_POST);
      }

      if (isset($_GET["id"])) {

        if ($_GET["id"] != 0) {

          if (isset($_GET["process"]) && $_GET["process"] == "delete") {

            $controller->delete("group", "group_id", $_GET["id"]);
            App::redirect("group");
          } else {
            $controller->getModelForm("group", $_GET["id"], $controller->formInfos);
          }
        } else {
          $controller->getEmptyModelForm("group", $controller->formInfos);
        }
      } else {
        $controller->getGroupDashboard();
      }

      break;

    case "profile":

      Auth::protect();
      $controller = new Src\Controller\Profile();

      if ($_POST) {
        $controller->submitData($_POST);
      }

      if (isset($_GET["id"])) {

        if ($_GET["id"] != 0) {

          if (isset($_GET["process"]) && $_GET["process"] == "delete") {

            $controller->delete("profile", "profile_id", $_GET["id"]);
            App::redirect("profile");
          } else {
            $controller->getModelForm("profile", $_GET["id"], $controller->formInfos);
          }
        } else {
          $controller->getEmptyModelForm("profile", $controller->formInfos);
        }
      } else {
        $controller->getProfileDashboard();
      }

      break;

    case "params":

      Auth::protect();
      $controller = new Src\Controller\Params();

      if ($_POST) {
        $controller->submitData($_POST, $_POST["table_name"]);
      }

      if (isset($_GET["id"]) && isset($_GET["tab"])) {

        if ($_GET["id"] != 0) {

          if (isset($_GET["process"]) && $_GET["process"] == "delete") {

            $res = $controller->delete($_GET["tab"], $_GET["tab"] . "_id", $_GET["id"]);
            if ($res != null) {
              App::redirect("error");
            }
            App::redirect("params");
          } else {
            $controller->getModelForm($_GET["tab"], $_GET["id"], $controller->formsInfos[$_GET["tab"]], "params");
          }
        } else {
          $controller->getEmptyModelForm($_GET["tab"], $controller->formsInfos[$_GET["tab"]], "params");
        }
      } else {
        $controller->getParamsDashboard();
      }

      break;

    case "stats":

      Auth::protect();
      $controller = new Src\Controller\Stats();
      $controller->getView();

      break;

    case "login":

      $controller = new Src\Controller\Login();

      if (isset($_POST["email"]) && isset($_POST["password"])) {
        // TODO Gérer les cas d'utilisateur non admin, rediriger vers login
        $controller->checkAuth($_POST["email"], $_POST["password"]);
      } else {
        $controller->getLoginPage();
      }

      break;

    case "logout":

      Auth::protect();
      $controller = new Src\Controller\Logout();
      $controller->logout();

      break;

    case "error":

      require_once "../pages/error.php";

      break;

    default:

      http_response_code(404);
      App::redirect("page404");

      break;
  }
} else {

  if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {

    switch ($_GET["api"]) {

      case "login":

        $controller = new Src\Controller\Login();

        // ICI DATA EST UN OBJET DONC ON ACCEDE AUX DONNEES COMME UN OBJET
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email && !empty($data->password))) {
          $response = $controller->checkClientAuth($data->email, $data->password);
          echo json_encode($response);
        }

        break;
    }
  } else {
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autorisee"]);
  }
}
