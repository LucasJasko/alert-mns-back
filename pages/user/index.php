<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use core\Dashboard;
use core\NavBar;

$dashboard = new Dashboard("user", "User", ["user_password", "user_ip", "user_device", "user_browser"]);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Gestion des utilisateurs</title>
</head>

<body>

  <h1>Alert MNS - Tableau de bord: Gestion des utilisateurs</h1>

  <?= NavBar::getNavBar() ?>


  <main class="main-container">
    <div class="param-window">
      <div class="btn-container">
        <a class="valid-button add-button" href="../form.php?form_type=user&class_name=User">Ajouter un utilisateur</a>
      </div>
      <?= $dashboard->openTable() ?>
      <?= $dashboard->getTHead() ?>
      <?= $dashboard->getTBody() ?>
      <?= $dashboard->closeTable() ?>
    </div>

    <div class="delete-container"></div>
  </main>

  <input type="text" class="target" value="Utilisateurs" hidden>
  <script src="../script.js"></script>
  <script src="./script.js"></script>

</body>

</html>