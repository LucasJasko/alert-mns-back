<?php

namespace Core\Router;

class Router
{
  private static array $routes = [];

  public static function add(string $path, \Closure $handler): void
  {
    self::$routes[$path] = $handler;
  }

  public static function dispatch(string $path): void
  {

    $isApi = false;

    if (str_starts_with($path, "/api")) {
      $isApi = true;
      $path = substr($path, 4);
    }

    foreach (self::$routes as $route => $handler) {

      $pattern = preg_replace("#\{\w+\}#", "([^\/]+)", $route);

      if (preg_match("#^$pattern$#", $path, $matches)) {

        array_shift($matches);

        if ($isApi) {
          $matches["isApi"] = $isApi;
        }

        call_user_func_array($handler, $matches);

        return;
      }
    }

    if (isset($isApi) && $isApi) {

      http_response_code(404);

    } else {
      \Src\App::redirect("page404");
    }

  }
}