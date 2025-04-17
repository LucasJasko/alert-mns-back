<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();


if (isset($_GET["form_type"]) && isset($_GET["id"]) && isset($_GET["class_name"])) {
  $redirectPage = "params";
  if ($_GET["form_type"] == "user") {
    $redirectPage = "user";
  }
  if ($_GET["form_type"] == "group") {
    $redirectPage = "group";
  }
  $managerName = "controllers\\" . $_GET["class_name"] . "Manager";
  $manager = new $managerName();
  $method = "delete" . $_GET["class_name"];
  $manager->$method($_GET["id"]);
  header("Location:/pages/" . $redirectPage . "/index.php");
}
