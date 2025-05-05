<?php

class Autoloader
{

  public static function autoload()
  {
    spl_autoload_register([__CLASS__, "loadClass"]);
  }

  private static function loadClass($class)
  {
    $str = str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "\\" . $class . ".php";
    require_once $str;
  }
}
