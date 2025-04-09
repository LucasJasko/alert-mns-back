<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use core\Form;

if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0) {
  $form = new Form("user", "user_id", $_GET["id"]);
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <title>Tableau de bord - Modification d'un utilisateur</title>
  </head>

  <body>
    <main class="user-form__container">

      <h1>Fiche d'information de <?= $form->getUserData()["user_name"] ?></h1>

      <a href="./user/index.php"><i class="fa-solid fa-arrow-left"></i></a>

      <form class="user-form" action="">
        <?= $form->getUserFormFields(); ?>
        <input type="submit" value="Enregistrer">
      </form>
    </main>
  </body>

  </html>

<?php  } else {
  header("Location:/pages/user/index.php");
} ?>