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
      $pattern = preg_replace("#\{\w+\}#", "([^\/]+)", $route);

      if (preg_match("#^$pattern$#", $path, $matches)) {

        array_shift($matches);

        call_user_func_array($handler, $matches);

        return;
      }
    }

    http_response_code(404);
    \Src\App::redirect("page404");

  }
}

// V1 dispatch qui ne gère pas les routes dynamiques
// if (array_key_exists($path, self::$routes)) {

//   $handler = self::$routes[$path];

//   call_user_func($handler);

// } else {

//   echo "404 not found";

// }