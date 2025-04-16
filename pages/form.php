<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use controllers\GroupManager;
use controllers\UserManager;
use core\Form;

if (isset($_GET["form_type"])) {
  $form = new Form($_GET["form_type"]);
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
      if ($_GET["form_type"] == "user") {
        if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0) {
          $manager = new UserManager();
          $data = $manager->getUser($_GET["id"]);
      ?>

          <h1>Fiche d'information de <?= $data["user_name"] ?></h1>
          <?= $form->getForm($_GET["id"], ['user_picture', 'user_ip', 'user_device', 'user_browser', 'user_language_id', 'user_theme_id', 'user_status_id']); ?>

        <?php } else { ?>

          <h1>Création d'un nouvel utilisateur</h1>
          <?= $form->getForm(0, ['user_id', 'user_picture', 'user_ip', 'user_device', 'user_browser', 'user_language_id', 'user_theme_id', 'user_status_id']); ?>

        <?php
        }
      }
      if ($_GET["form_type"] == "group") {
        if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0) {
          $manager = new GroupManager();
          $data = $manager->getGroup($_GET["id"]);
        ?>

          <h1>Fiche d'information du groupe <?= $data["group_name"] ?></h1>
          <?= $form->getForm($_GET["id"]); ?>
        <?php
        } else { ?>

          <h1>Création d'un nouveau groupe</h1>
          <?= $form->getForm(0, ["group_id", "group_last_message"]); ?>

      <?php
        }
      }
      ?>
    </main>
  </body>

  </html>

<?php } else {
  Form::submitData($_POST);
} ?>