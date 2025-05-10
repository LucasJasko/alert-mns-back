<?php

require_once "../class/Src/App.php";

use \Src\App;
use \core\controller\Auth;

App::init();

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
          $controller->getForm($_GET["id"]);
        }
      } else {
        $controller->getEmptyForm();
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
          $controller->getForm($_GET["id"]);
        }
      } else {
        $controller->getEmptyForm();
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

          $controller->delete($_GET["tab"], $_GET["tab"] . "_id", $_GET["id"]);
          App::redirect("params");
        } else {
          $controller->getForm($_GET["tab"], $_GET["id"]);
        }
      } else {
        $controller->getEmptyForm($_GET["tab"]);
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

  case "page404":
    require ROOT . "/pages/page404.php";
    break;

  default:
    http_response_code(404);
    App::redirect("page404");
    break;
}

if (isset($_GET["api"])) {
  switch ($_GET["api"]) {
  }
}
