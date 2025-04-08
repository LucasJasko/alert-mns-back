<?php

namespace class\controllers;

use \class\core\Database;
use \PDO;

class DatabaseManager
{

  private static $db;
  private static PDO $pdo;

  private static function getDatabase()
  {
    if (self::$db === null) {
      self::$db = new Database();
    }
    return self::$db;
  }

  public static function selectUser($email)
  {
    self::$pdo = self::getDatabase()->getPDO();
    $stmt = self::$pdo->prepare("SELECT user_password FROM user WHERE user_mail = :user_mail");
    $stmt->bindValue(":user_mail", $email);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row;
  }

  public static function selectAll(string $table)
  {
    self::$pdo = self::getDatabase()->getPDO();
    $stmt = self::$pdo->prepare("SELECT * FROM :table");
    $stmt->bindValue(":table", $table);
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
  }
}
