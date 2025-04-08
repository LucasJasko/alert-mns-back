<?php

namespace class;

use \class\core\Auth;

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();


if (isset($_POST["email"])) {
  $auth = new Auth();
  $email = $_POST["email"];
  $pwd = $_POST["password"];
  $res = $auth->login($email, $pwd);
  var_dump($res);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Le back du projet alert-mns</h1>

  <form action="/index.php" method="post">
    <input type="text" name="email">
    <input type="text" name="password">
    <input type="submit" value="Envoyer">
  </form>

</body>

</html>