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
    $str = ROOT . "\class\\" . $class . ".php";
    require_once $str;
  }

  public static function db()
  {
    if (self::$db === null) {
      self::$db = new \Src\Database\Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }
    return self::$db;
  }

  public static function redirect($page)
  {
    header("Location:/" . $page);
    exit;
  }
}
