<?php

require_once "../core/Autoloader.php";
Autoloader::autoload();

$page = isset($_GET["page"]) ? $_GET["page"] : "user";



switch ($page) {


  case "group":

    $groupController = new src\controller\GroupController();

    if ($_POST) {
      $groupController->submitData($_POST);
    }

    if (isset($_GET["id"])) {
      if ($_GET["id"] != 0) {
        $groupController->getForm($_GET["id"]);
      } else {
        $groupController->getEmptyForm();
      }
    } else {
      $groupController->getView();
    }

    break;


  case "user":

    $userController = new src\controller\UserController();

    if ($_POST) {
      $userController->submitData($_POST);
    }

    if (isset($_GET["id"])) {
      if ($_GET["id"] != 0) {
        $userController->getForm($_GET["id"]);
      } else {
        $userController->getEmptyForm();
      }
    } else {
      $userController->getView();
    }
    break;


  case "params":

    $paramsController = new src\controller\ParamsController();
    $paramsController->getView();
    break;


  case "stats":

    $statsController = new src\controller\StatsController();
    $statsController->getView();
    break;


  case "login":

    $loginController = new src\controller\LoginController();

    if (isset($_POST["email"]) && isset($_POST["password"])) {
      $loginController->checkAuth($_POST["email"], $_POST["password"]);
    } else {
      $loginController->getLoginPage();
    }
    break;
}
