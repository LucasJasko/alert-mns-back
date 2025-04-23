<?php

require_once "../core/Autoloader.php";
Autoloader::autoload();

$page = isset($_GET["page"]) ? $_GET["page"] : "user";

switch ($page) {
  case "group":
    require "../src/controller/Group.php";
    break;
  case "user":
    require "../src/controller/User.php";
    break;
  case "stats":
    require "../src/controllerStats.php";
    break;
  case "params":
    require "../src/controller/Params.php";
    break;
}
