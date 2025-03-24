<?php

require_once "./include/clientAccess.php";
require_once "./include/connect.php";

$data  = json_decode(file_get_contents("php://input"), true);
$query = $data['query'];

if ($query) {
    $stmt = $db->prepare("SELECT user_name FROM user WHERE user_name LIKE :search");
    $stmt->bindValue(":search", htmlspecialchars($query));
    $stmt->execute();
    if ($row = $stmt->fetchAll()) {
        echo json_encode($row);
    } else {
        echo "Aucun résultats trouvés";
    }
}
