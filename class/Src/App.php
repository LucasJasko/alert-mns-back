<?php

namespace Src;

use PDOException;
use Src\Database\Database;

class App
{

  private static $db;

  public static function init()
  {
    require "../config/config.php";
    self::autoload();
  }

  public static function autoload()
  {
    spl_autoload_register([__CLASS__, "loadClass"]);
  }

  private static function loadClass($class)
  {
    $str = ROOT . "\class\\" . $class . ".php";
    require_once $str;
  }

  public static function db()
  {
    if (self::$db === null) {
      try {
        self::$db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
      } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
      }
    }
    return self::$db;
  }

  public static function redirect($page)
  {
    header("Location:./index.php?page=" . $page);
    exit;
  }

  public static function getClientAccess()
  {
    // Plutôt que l'étoile il faudra donner l'adresse du client ici
    return [
      header("Access-Control-Allow-Origin: *"),
      header("Content-Type: application/json; charset=UTB-8"),
      header("Access-Control-Allow-Methods: GET, POST"),
      header("Access-Control-Max-Age: 3600"),
      header("Access-Control-Allow-Headers: *"),
    ];
  }
}
