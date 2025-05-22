<?php

namespace Core;

use \Core\Controller\Auth;

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
    $isDelete = false;

    if (str_starts_with($path, "/api")) {
      $isApi = true;
      $path = substr($path, 4);
    }

    Auth::initSession();
    Auth::setDeleteToken();
    $sessionDeleteToken = Auth::deleteToken();

    if (str_ends_with($path, "/" . $sessionDeleteToken)) {
      $isDelete = true;
      $path = str_replace("/" . $sessionDeleteToken, "", $path);
    }

    foreach (self::$routes as $route => $handler) {

      $pattern = preg_replace("#\{\w+\}#", "([^\/]+)", $route);

      if (preg_match("#^$pattern$#", $path, $matches)) {

        array_shift($matches);

        if (isset($isApi) && $isApi) {
          $matches["isApi"] = $isApi;
        }

        if (isset($isDelete) && $isDelete) {
          $matches["isDelete"] = $isDelete;
        }
        call_user_func_array($handler, $matches);

        return;
      }
    }

    if (isset($isApi) && $isApi) {
      http_response_code(404);
      echo json_encode(["message" => "Service introuvable"]);
    } else {
      \Src\App::redirect("page404");
    }

  }
}