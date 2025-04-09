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
    if ($this->pdo === null) {
      $this->pdo = $this->getPDO();
    }
    return $this->pdo;
  }

  public function getPDO()
  {
    try {
      $stmt = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName . ';charset=utf8';
      $pdo = new PDO($stmt, $this->dbUsername, $this->dbPassword);
      return $pdo;
    } catch (\PDOException $e) {
      return $e->getMessage();
    }
  }
}
