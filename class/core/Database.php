<?php

namespace class\core;


class Database
{
  private string $dbHost;
  private string $dbName;
  private string $dbUsername;
  private string $dbPassword;
  private $pdo;

  public function __construct($dbName, $dbUsername = "root", $dbPassword = "", $dbHost = "localhost")
  {
    $this->dbHost = $dbHost;
    $this->dbName = $dbName;
    $this->dbUsername = $dbUsername;
    $this->dbPassword = $dbPassword;
  }

  private function getPDO()
  {
    try {
      if ($this->pdo === null) {
        $pdo = new \PDO("mysql:host=localhost;dbname=alertmns;charset=utf8", "root", "");
        $this->pdo = $pdo;
      }
      return $pdo;
    } catch (\PDOException $e) {
      return $e->getMessage();
    }
  }

  public function fetchUser($email)
  {
    $this->getPDO();
    $stmt = $this->pdo->prepare("SELECT user_password FROM user WHERE user_mail = :user_mail");
    $stmt->bindValue(":user_mail", $email);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row;
  }
}
