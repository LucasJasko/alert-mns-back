<?php

namespace Core;

class Router
{
  private static array $routes = [];

  public static function add(string $path, \Closure $handler): void
  {
    self::$routes[$path] = $handler;
  }

  public static function dispatch(string $path): void
  {
    foreach (self::$routes as $route => $handler) {
      $pattern = preg_replace("#\{\W+\}#", "([^\/]+)", $route);

      if (preg_match("#^$pattern$#", $path, $matches)) {
        print_r($matches);
        return;
      }
    }





    // V1 qui ne gère pas les routes dynamiques
    // if (array_key_exists($path, self::$routes)) {

    //   $handler = self::$routes[$path];

    //   call_user_func($handler);

    // } else {

    //   echo "404 not found";

    // }
  }
}