<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use core\Database;
use core\Dashboard;
use core\NavBar;

$db = new Database();

$displayedTables = [
  "user_situation" => ["user_situation", "Situations des utilisateurs", "une situation", "UserSituation"],
  "user_department" => ["user_department", "Départements de l'entreprise", "un département", "UserDepartment"],
  "user_theme" => ["user_theme", "Thèmes de l'application", "un thème", "UserTheme"],
  "user_status" => ["user_status", "Statuts d'activité des utilisateurs", "un statut", "UserStatus"],
  "user_role" => ["user_role", "Rôles de l'application", "un role", "UserRole"],
  "user_language" => ["user_language", "Langues de l'application", "une langue", "UserLanguage"],
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

  <nav class="navbar">
    <div class="navbar__container">
      <div class="navbar__container__left">
        <ul>
          <li>
            <a href="../group/">Groupes</a>
          </li>
          <li>
            <a href="../user/">Utilisateurs</a>
          </li>
          <li>
            <a href="../params/">Paramétrages</a>
          </li>
          <li>
            <a href="../stats/">Statistiques</a>
          </li>
        </ul>
      </div>
      <div class="navbar__container__right">
        <div class="log-out__btn">
          <i class="fa-solid fa-power-off"></i>
        </div>
      </div>
    </div>
  </nav>

  <main class="main-container">

    <div class="params-container">

      <?php
      foreach ($displayedTables as $table) {
      ?>
        <div class="param-window <?= $table[0] ?>">
          <h2 class="param-title"><?= $table[1] ?></h2>
          <div class="btn-container">
            <a class="valid-button add-button" href="../form.php?form_type=<?= $table[0] ?>&class_name=<?= $table[3] ?>">Ajouter <?= $table[2] ?></a>
          </div>
          <?php $dashboard = new Dashboard($table[0], $table[3]) ?>
          <?= $dashboard->openTable() ?>
          <?= $dashboard->getTHead() ?>
          <?= $dashboard->getTBody() ?>
          <?= $dashboard->closeTable() ?>
        </div>
      <?php } ?>

    </div>

    <div class="delete-container"></div>
  </main>

  <input type="text" class="target" value="Paramétrages" hidden>
  <script src="../script.js"></script>
  <script src="./script.js"></script>
</body>

</html>