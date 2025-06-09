<?php

namespace Core\Router;

// TODO gérer les pages exclusivement api accédés sans le tag api/

class Router
{
  private static array $routes = [];

  public static function add(string $path, \Closure $handler): void
  {
    self::$routes[$path] = $handler;
  }

  public static function dispatch(string $path)
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

      return http_response_code(404);

    }

    return \Src\App::redirect("page404");
  }
}