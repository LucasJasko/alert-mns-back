<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use controllers\UserManager;

if (isset($_GET["id"])) {
  $manager = new UserManager();
  $manager->deleteUser($_GET["id"]);
  header("Location:/pages/user/index.php");
}
