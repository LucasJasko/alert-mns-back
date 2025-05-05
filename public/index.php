<?php

require_once "../core/Autoloader.php";
Autoloader::autoload();

use \core\controller\Auth;

$page = isset($_GET["page"]) ? $_GET["page"] : "login";

switch ($page) {


  case "group":

    Auth::protect();
    $controller = new src\controller\GroupController();

    if ($_POST) {
      $controller->submitData($_POST);
    }

    if (isset($_GET["id"])) {
      if ($_GET["id"] != 0) {
        $controller->getForm($_GET["id"]);
      } else {
        $controller->getEmptyForm();
      }
    } else {
      $controller->getGroupDashboard();
    }

    break;


  case "profile":

    Auth::protect();
    $controller = new src\controller\ProfileController();

    if ($_POST) {
      $controller->submitData($_POST);
    }

    if (isset($_GET["id"])) {
      if ($_GET["id"] != 0) {
        $controller->getForm($_GET["id"]);
      } else {
        $controller->getEmptyForm();
      }
    } else {
      $controller->getProfileDashboard();
    }
    break;


  case "params":

    Auth::protect();
    $controller = new src\controller\ParamsController();

    if ($_POST) {
      $controller->submitData($_POST, $_POST["table_name"]);
    }

    if (isset($_GET["id"]) && isset($_GET["tab"])) {

      if ($_GET["id"] != 0) {
        $controller->getForm($_GET["tab"], $_GET["id"]);
      } else {
        $controller->getEmptyForm($_GET["tab"]);
      }
    } else {
      $controller->getParamsDashboard();
    }

    break;


  case "stats":

    Auth::protect();
    $controller = new src\controller\StatsController();
    $controller->getView();
    break;


  case "login":

    $controller = new src\controller\LoginController();

    if (isset($_POST["email"]) && isset($_POST["password"])) {
      $controller->checkAuth($_POST["email"], $_POST["password"]);
    } else {
      $controller->getLoginPage();
    }
    break;
}

if (isset($_GET["api"])) {
  switch ($_GET["api"]) {
  }
}
