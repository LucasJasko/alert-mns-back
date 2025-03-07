<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/include/function.php";

session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] != "Utilisateur connecté") {
  redirect("/login.php");
  exit();
}
;
