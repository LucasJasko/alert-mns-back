<?php

class Autoloader
{

  public static function autoload()
  {
    spl_autoload_register([__CLASS__, "loadClass"]);
  }

  private static function loadClass($class)
  {
    $str = "../class/" . $class . ".php";
    var_dump($str);
    require_once $str;
  }
}

Autoloader::autoload();
