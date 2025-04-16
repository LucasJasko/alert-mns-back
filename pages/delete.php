<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();


if (isset($_GET["form_type"]) && isset($_GET["id"])) {
  $managerName = "controllers\\" . ucfirst($_GET["form_type"]) . "Manager";
  $manager = new $managerName();
  $method = "delete" . ucfirst($_GET["form_type"]);
  $manager->$method($_GET["id"]);
  header("Location:/pages/" . $_GET["form_type"] . "/index.php");
}
