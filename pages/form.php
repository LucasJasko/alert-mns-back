<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use controllers\UserManager;
use core\Form;

$form = new Form();

if (count($_POST) != 0) {
  $manager = new UserManager();
  if (isset($_POST["user_id"])) {
    $manager->updateUser($_POST["user_id"], $_POST);
    header("Location:/pages/user/index.php");
  } else {
    $manager->createUser($_POST);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Modification d'un utilisateur</title>
</head>

<body>
  <main class="form__container">

    <?php
    if (isset($_GET["uid"]) && is_numeric($_GET["uid"]) && $_GET["uid"] != 0) {
      $manager = new UserManager();
      $data = $manager->getUser($_GET["uid"]);
    ?>

      <h1>Fiche d'information de <?= $data["user_name"] ?></h1>
      <?= $form->getUserForm($_GET["uid"]); ?>

    <?php  } else { ?>

      <h1>Création d'un nouvel utilisateur</h1>
      <?= $form->getEmptyUserForm(['user_id', 'user_picture', 'user_ip', 'user_device', 'user_browser', 'user_language_id', 'user_theme_id', 'user_status_id']); ?>

    <?php
    }
    ?>
  </main>
</body>

</html>