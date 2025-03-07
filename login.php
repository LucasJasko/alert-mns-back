<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once $_SERVER["DOCUMENT_ROOT"] . "/include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/function.php";

if (isset($_POST["user_mail"]) && isset($_POST["user_password"])) {
  $stmt = $db->prepare("SELECT user_password FROM _user WHERE user_mail = :user_mail");
  $stmt->bindValue(":user_mail", $_POST["user_mail"]);
  $stmt->execute();

  if ($row = $stmt->fetch()) {
    // password_verify($_POST["user_password"], $row["user_password"]) A UTILISER A TERME
// $_POST["user_password"] == $row["user_password"]
    if ($_POST["user_password"] == $row["user_password"]) {
      session_start();
      $_SESSION["is_logged"] = "Utilisateur connecté";
      $_SESSION["token"] = bin2hex(random_bytes(32));
      redirect("/index.php");
    } else {
      echo "login ou mot de passe incorrect";
    }
  } else {
    echo "login ou mot de passe incorrect";
  }
}
