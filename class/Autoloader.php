<?php

namespace class;

class Autoloader
{

  public static function autoload()
  {
    spl_autoload_register([__CLASS__, "loadClass"]);
  }

  private static function loadClass($class)
  {
    $folders = ["controllers", "core", "models"];
    foreach ($folders as $path) {
      $path = $class . ".php";
      if (file_exists($path)) require_once $path;
    }
  }
}
