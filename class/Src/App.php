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
    $str = str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "\\" . $class . ".php";
    require_once $str;
  }

  private static function db()
  {
    if (self::$db === null) {
      // New PDO
    }
  }
}
