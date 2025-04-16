<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use core\Database;
use core\Dashboard;
use core\NavBar;

$db = new Database();

$displayedTables = [
  "user_situation" => ["user_situation", "Situations des utilisateurs", "une situation", "situation"],
  "user_department" => ["user_department", "Départements de l'entreprise", "un département", "language"],
  "user_theme" => ["user_theme", "Thèmes de l'application", "un thème", "theme"],
  "user_status" => ["user_status", "Statuts d'activité", "un statut", "status"],
  "user_role" => ["user_role", "Rôles d'utilisateurs", "un role", "role"],
  "user_language" => ["user_language", "Langues de l'application", "une langue", "language"],
]
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Gestion des paramètres</title>
</head>

<body>

  <h1>Alert MNS - Tableau de bord: Gestion des paramètres de l'application</h1>

  <?= NavBar::getNavBar() ?>

  <main class="main-container">

    <div class="params-container">

      <?php
      foreach ($displayedTables as $table) {
      ?>
        <div class="param-window param-window_<?= $table[0] ?>">
          <h2 class="param-title"><?= $table[1] ?></h2>
          <div class="btn-container">
            <a class="valid-button add-button" href="../form.php?form_type=<?= $table[3] ?>">Ajouter <?= $table[2] ?></a>
          </div>
          <?php $dashboard = new Dashboard($table[0]) ?>
          <?= $dashboard->openTable() ?>
          <?= $dashboard->getTHead() ?>
          <?= $dashboard->getTBody() ?>
          <?= $dashboard->closeTable() ?>
        </div>
      <?php } ?>

    </div>

  </main>

  <input type="text" class="target" value="Paramétrages" hidden>
  <script src="../script.js"></script>
</body>

</html>