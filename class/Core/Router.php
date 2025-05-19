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

    if (str_starts_with($path, "/api")) {
      $isApi = true;
      $path = substr($path, 4);
    }

    foreach (self::$routes as $route => $handler) {

      $pattern = preg_replace("#\{\w+\}#", "([^\/]+)", $route);

      if (preg_match("#^$pattern$#", $path, $matches)) {

        array_shift($matches);

        if (isset($isApi) && $isApi) {

          $matches[] = $isApi;

        }

        call_user_func_array($handler, $matches);

        return;
      }
    }

    http_response_code(404);
    if ($isApi) {
      echo json_encode(["message" => "Service introuvable"]);
    } else {
      \Src\App::redirect("page404");
    }

  }
}