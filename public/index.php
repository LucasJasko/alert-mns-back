<?php


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require_once "../class/Src/App.php";

use \Core\Router;

\Src\App::init();

$router = new Router();

Router::add("/", function () {
  $controller = new Src\Controller\Profile();
  $controller->dispatch();
});

Router::add("/login", function ($isApi = false) {
  $controller = new Src\Controller\Login();
  $controller->dispatch($isApi);
});

Router::add("/logout", function ($isApi = false) {
  $controller = new Src\Controller\Logout();
  $controller->dispatch();
});

Router::add("/group", function ($isApi = false) {
  $controller = new Src\Controller\Group();
  $controller->dispatch();
});

Router::add("/group/{id}", function ($id, $isApi = false, $isDelete = false) {
  $controller = new Src\Controller\Group();
  $controller->dispatch($id, $isApi, $isDelete);
});

Router::add("/profile", function ($isApi = false) {
  $controller = new Src\Controller\Profile();
  $controller->dispatch();
});

Router::add("/profile/{id}", function ($id, $isApi = false) {
  $controller = new Src\Controller\Profile();
  $controller->dispatch($id, $isApi);
});

Router::add("/params", function ($isApi = false) {
  $controller = new Src\Controller\Params();
  $controller->dispatch();
});

// ATENTION: les routes sont bindé dans l'ordre de leur apparition dans l'URL
Router::add("/params/{tab}/{id}", function ($tab, $id, $isApi = false) {
  $controller = new Src\Controller\Params();
  $controller->dispatch($id, $tab, $isApi);
});

Router::add("/stats", function ($isApi = false) {
  $controller = new Src\Controller\Stats();
  $controller->dispatch();
});

Router::add("/error", function ($isApi = false) {
  require_once "../pages/error.php";
});

Router::add("/page404", function () {
  require_once "../pages/page404.php";
});

Router::dispatch($path);

exit;