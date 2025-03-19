<?php

class Auth
{

  private $pdo;

  private function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }


  private function login($email, $pwd)
  {
    $stmt = $this->pdo->prepare("SELECT user_password FROM user WHERE user_mail = :user_mail");
    $stmt->bindValue(":user_mail", $email);
    $stmt->execute();
    $row = $stmt->fetch();
    ($row && password_verify($pwd, $row["user_password"])) ?
      ['success' => true, 'message' => 'Utilisateur connecté'] :
      ['success' => false, 'message' => 'Échec de la connexion : email ou mot de passe incorrect.'];
  }
}