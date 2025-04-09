<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/include/clientAccess.php";

$rawData = file_get_contents("php://input");
$data    = json_decode($rawData, true);

$typeID = $data["typeID"];
$convID = $data["convID"];

$jsonPath = file_get_contents("./templates/" . $typeID . "/" . $convID . ".json");

if (json_encode($jsonPath)) {
    echo json_encode($jsonPath);
}
if (! json_encode($jsonPath)) {
    echo "La recherche n'a rien donné";
}
