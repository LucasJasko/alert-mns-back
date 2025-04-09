<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use core\Auth;

$err = null;

if (isset($_POST["email"])) {
  $auth = new Auth();
  $res = $auth->login($_POST["email"], $_POST["password"]);
  $res["success"] ? header("Location:/pages/user/index.php") : $err = "Email ou mot de passe incorrect";
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
  <h1>Back office du projet alert-mns</h1>

  <form action="index.php" method="post">
    <input type="text" name="email" placeholder="email">
    <input type="text" name="password" placeholder="password">
    <input type="submit" value="Envoyer"> <br>
    <?php if (!is_null($err)) echo $err; ?>
  </form>

</body>

</html>