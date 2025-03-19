<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/include/function.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/clientAccess.php";

// Pour que les cookies contenant les informations de la session en cours soient correctement envoyé au client, il faut spécifier dans le fichier de configuration php.ini du serveur "SameSite = None"

session_start();

session_regenerate_id();

if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] != "oui") {
  echo json_encode(false);
} else {
  echo json_encode($_SESSION);
}
;

