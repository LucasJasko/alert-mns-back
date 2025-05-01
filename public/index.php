<?php

require_once "../core/Autoloader.php";
Autoloader::autoload();

$page = isset($_GET["page"]) ? $_GET["page"] : "profile";


switch ($page) {


  case "group":

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
      $controller->getView();
    }

    break;


  case "profile":

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
      $controller->getView();
    }

    break;


  case "stats":

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
