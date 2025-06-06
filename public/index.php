<?php


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require_once "../class/Src/App.php";

use \Core\Router\Router;

\Src\App::init();

$router = new Router();

// =================== BACK-OFFICE ROUTES ============================== //

Router::add("/", function ($isApi = false) {
  $controller = new Src\Controller\Profile();
  $controller->dispatch();
});

Router::add("/login", function ($isApi = false) {
  $controller = new Src\Controller\Login();
  $controller->dispatch($isApi);
});

Router::add("/logout/{id}", function ($id, $isApi = false) {
  $controller = new Src\Controller\Logout();
  $controller->dispatch($id, $isApi);
});

Router::add("/group", function ($isApi = false) {
  $controller = new Src\Controller\Group();
  $controller->dispatch();
});

Router::add("/group/{id}", function ($id, $isApi = false) {
  $controller = new Src\Controller\Group();
  $controller->dispatch($id, $isApi);
});

Router::add("/room/{group_id}/{room_id}", function ($group_id, $room_id, $isApi = false) {
  $controller = new Src\Controller\Room();
  $controller->dispatch($group_id, $room_id, $isApi);
});

Router::add("/profile", function () {
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

Router::add("/params/{tab}/{id}", function ($tab, $id, $isApi = false) {
  $controller = new Src\Controller\Params();
  $controller->dispatch($tab, $id, $isApi);
});

Router::add("/stats", function ($isApi = false) {
  $controller = new Src\Controller\Stats();
  $controller->dispatch($isApi);
});

Router::add("/delete/{table_name}/{id}/{redirect_page}/{delete_key}", function ($tableName, $id, $redirectpage, $deleteKey, $isApi = false) {
  $controller = new Src\Model\Form($tableName, $redirectpage);
  $controller->delete($deleteKey, $id, $isApi);
});

Router::add("/error", function ($isApi = false) {
  \Src\Auth\Auth::protect();
  require_once "../pages/error.php";
});

Router::add("/page404", function () {
  require_once "../pages/page404.php";
});

// =================== API ROUTES ============================== //

Router::add("/auth", function ($isApi = true) {
  $apiAuth = new \Src\Api\Auth();
  $apiAuth->dispatch($isApi);
});

Router::add("/search/{subject}", function (string $subject, $isApi = true) {
  $apiAuth = new \Src\Api\Search();
  $apiAuth->dispatch($subject, $isApi);
});

Router::add("/profile-groups/{profile_id}", function ($id, $isApi = true) {
  $apiAuth = new \Src\Api\ProfileGroup();
  $apiAuth->dispatch($id, $isApi);
});

Router::add("/image/{table}/{folder_name}/{subfolder}/{file_name}", function ($table, $folderName, $subfolder, $fileName, $isApi = true) {
  $apiAuth = new \Src\Api\Image();
  $apiAuth->dispatch($table, $folderName, $subfolder, $fileName, $isApi);
});

Router::dispatch($path);

exit;