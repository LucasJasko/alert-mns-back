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
        return $this->pdo;
      }
    } catch (\PDOException $e) {
      return $e->getMessage();
    }
  }

  public function createOne(string $table, array $fields, array $data)
  {
    $sql = "INSERT INTO " . $table . " ( ";
    foreach ($fields as $key => $value) {
      $sql .= $value . ", ";
    }
    $sql .= ") VALUES ( ";
    foreach ($fields as $key => $value) {
      $sql .= ":" . $value . ", ";
    }
    $sql .= ")";
    $sql = str_replace(", ) VALUES", " ) VALUES", $sql);
    $sql = str_replace(", )", " )", $sql);

    $stmt = $this->pdo->prepare($sql);
    foreach ($data as $key => $value) {
      $stmt->bindValue(":" . $key, $value);
    }
    $stmt->execute();
  }

  public function updateOne(string $table, array $data, string $param, int $id)
  {
    $sql = "UPDATE " . $table . " SET ";
    foreach ($data as $key => $value) {
      $sql .= $key . " = :" . $key . ", ";
    }
    $sql .= "WHERE " . $param . " = :" . $param;
    $sql = str_replace(", WHERE", " WHERE", $sql);

    $stmt = $this->pdo->prepare($sql);
    foreach ($data as $key => $value) {
      $stmt->bindValue(":" . $key, $value);
    }
    $stmt->bindValue(":" . $param, $id);
    $stmt->execute();
  }

  public function getAll(string $table)
  {
    if ($table == "_group") {
      $fieldTable = str_replace("_group", "group", $table);
    } else if ($table == "_user") {
      $fieldTable = str_replace("_user", "user", $table);
    } else {
      $fieldTable = $table;
    }
    $id = $fieldTable . "_id";
    $stmt = $this->pdo->prepare("SELECT * FROM `" . $table . "` ORDER BY " . $id . " ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllWhere(string $table, string $field, int $id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM " . $table . " WHERE " . $field . " = :" . $field);
    $stmt->execute([":" . $field => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getWhere(string $table, string $target, string $field, $param)
  {
    $stmt = $this->pdo->prepare("SELECT " . $target . " FROM " . $table . " WHERE " . $field . " = :" . $field);
    $stmt->execute([":" . $field => $param]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getFieldsOfTable(string $table)
  {
    $stmt = $this->pdo->prepare('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "' . $table . '"');
    $stmt->execute();
    $raw = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $fields = [];
    for ($i = 0; $i < count($raw); $i++) {
      array_push($fields, $raw[$i]["COLUMN_NAME"]);
    }
    return $fields;
  }


  public function deleteOne(string $table, string $field, int $param)
  {
    $stmt = $this->pdo->prepare("DELETE FROM " . $table . " WHERE " . $field . " = :" . $field);
    $stmt->execute([":" . $field => $param]);
  }
}
