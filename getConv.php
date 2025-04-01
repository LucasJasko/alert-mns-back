<?php

require_once "./include/clientAccess.php";

$rawData = file_get_contents("php://input");
$data    = json_decode($rawData, true);

$typeID = $data["typeID"];
$convID = $data["convID"];

$jsonPath = file_get_contents("./templates/" . $typeID . "/" . $convID . ".json");

echo json_encode($jsonPath);
