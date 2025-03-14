<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

require_once $_SERVER["DOCUMENT_ROOT"] . "/include/function.php";

session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] != "Utilisateur connecté") {
  echo false;
} else {
  echo json_encode($_SESSION);
}
;
