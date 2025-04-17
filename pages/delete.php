<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();


if (isset($_GET["form_type"]) && isset($_GET["id"]) && isset($_GET["class_name"])) {
  $managerName = "controllers\\" . $_GET["class_name"] . "Manager";
  $manager = new $managerName();
  $method = "delete" . $_GET["class_name"];
  $manager->$method($_GET["id"]);
  header("Location:/pages/" . $_GET["form_type"] . "/index.php");
}
