<?php

namespace class;

use \class\core\Auth;

require_once $_SERVER["DOCUMENT_ROOT"] . "/include/clientAccess.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

// Réception des données client
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if ($data) {
  $res = Auth::login($data["user_mail"], $data["user_password"]);
  echo json_encode($res);
}
