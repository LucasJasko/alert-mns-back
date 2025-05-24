<?php

namespace Src;

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
    $local = ROOT . "\class\\" . $class . ".php";

    if (file_exists($local)) {
      require_once $local;
    } else {
      foreach (VENDORS as $packageName => $path) {
        if ($class == $packageName) {
          require_once $path;
        }
      }
    }
  }

  public static function db()
  {
    if (self::$db === null) {
      self::$db = new \Src\Database\Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }
    return self::$db;
  }

  public static function clientData()
  {
    return json_decode(file_get_contents("php://input"), true);
  }

  public static function redirect($page)
  {
    header("Location:/" . $page);
    exit;
  }
}
