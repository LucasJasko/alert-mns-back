<?php

namespace core;

use \PDO;

class Database
{
  private string $dbHost = "localhost";
  private string $dbName = "alertmns";
  private string $dbUsername = "root";
  private string $dbPassword = "";
  private $pdo;

  public function __construct(string $dbName = "alertmns", string $dbUsername = "root", string $dbPassword = "", string $dbHost = "localhost")
  {
    $this->dbHost = $dbHost;
    $this->dbName = $dbName;
    $this->dbUsername = $dbUsername;
    $this->dbPassword = $dbPassword;

    try {
      if ($this->pdo === null) {
        $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName . ';charset=utf8';
        $this->pdo = new PDO($dsn, $this->dbUsername, $this->dbPassword);
      }
    } catch (\PDOException $e) {
      return $e->getMessage();
    }
  }

  public function selectUser($email)
  {
    $stmt = $this->pdo->prepare("SELECT user_password FROM user WHERE user_mail = :user_mail");
    $stmt->bindValue(":user_mail", $email);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row;
  }

  public function selectAll(string $table)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM " . $table);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectAllWhere(string $table, string $field, int $id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM " . $table . " WHERE " . $field . " = :" . $field);
    $stmt->execute([":" . $field => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getFields(string $table)
  {
    $stmt = $this->pdo->prepare("DESCRIBE " . $table);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
