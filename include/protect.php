<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/include/function.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/clientAccess.php";

session_start();

if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] != "oui") {
  echo json_encode(false);
} else {
  echo json_encode($_SESSION);
}
;

