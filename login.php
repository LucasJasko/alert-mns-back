<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/clientAccess.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/function.php";


// Réception des données client
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Assignation des données
$mail = $data["user_mail"];
$pwd = $data["user_password"];



if (isset($mail) && isset($pwd)) {
  $stmt = $db->prepare("SELECT user_password FROM user WHERE user_mail = :user_mail");
  $stmt->bindValue(":user_mail", $mail);
  $stmt->execute();

  if ($row = $stmt->fetch()) {
    // password_verify($pwd, $row["user_password"]) A UTILISER A TERME
// $pwd == $row["user_password"]
    if ($pwd == $row["user_password"]) {
      session_start();
      $_SESSION["is_logged"] = "oui";

      $response = [
        'success' => true,
        'data' => $_SESSION,
      ];

    } else {
      $response = [
        'success' => false,
        'message' => 'Échec de la connexion : email ou mot de passe incorrect.'
      ];
    }
  } else {
    $response = [
      'success' => false,
      'message' => 'Échec de la connexion : email ou mot de passe incorrect.'
    ];
  }
} else {
  $response = [
    'success' => false,
    'message' => 'Veuillez remplir tous les champs.'
  ];
}

echo json_encode($response);
