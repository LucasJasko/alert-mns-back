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

Router::add("/login", function () {
  $controller = new Src\Controller\Login();
  $controller->dispatch();
});

Router::add("/logout", function () {
  $controller = new Src\Controller\Logout();
  $controller->dispatch();
});

Router::add("/group", function () {
  $controller = new Src\Controller\Group();
  $controller->dispatch();
});

Router::add("/profile", function () {
  $controller = new Src\Controller\Profile();
  $controller->dispatch();
});

Router::add("/params", function () {
  $controller = new Src\Controller\Params();
  $controller->dispatch();
});

Router::add("/stats", function () {
  $controller = new Src\Controller\Stats();
  $controller->dispatch();
});

Router::add("/error", function () {
  require_once "../pages/error.php";
});

Router::add("/page404", function () {
  require_once "../pages/page404.php";
});


// exemples de route dynamiques fonctionnelles à utiliser pour le projet
Router::add("/products/{id}", function ($id) {
  echo "Voici la page du produit numéro: $id";
});

Router::add("/products/{product_id}/order/{order_id}", function ($product_id, $order_id) {
  echo "Voici la page du produit numéro: $product_id commande numéro: $order_id";
});
// /////////////////////////////////////////////////////////

Router::dispatch($path);

exit;











switch ($path) {

  case "api/login":

    $controller = new Src\Controller\Login();

    // ICI DATA EST UN OBJET DONC ON ACCEDE AUX DONNEES COMME UN OBJET
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->email && !empty($data->password))) {
      $response = $controller->checkClientAuth($data->email, $data->password);
      echo json_encode($response);
    }

    break;
}
// http_response_code(405);
// echo json_encode(["message" => "La methode n'est pas autorisee"]);

