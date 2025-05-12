<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Gestion des paramètres</title>
</head>

<body>

  <h1>Alert MNS - Tableau de bord: Gestion des paramètres de l'application</h1>

  <?php require_once ROOT . "/pages/template/navbar.php"  ?>

  <main class="main-container">

    <div class="params-container">

      <?php
      foreach ($this->ParamsConfig as $table) {
        $this->dashboard = new \core\model\Dashboard($table["field_name"], $table["recordset"], $table["dashboard_infos"]);
      ?>
        <div class="param-window param-window-small <?= $table["field_name"] ?>">
          <h2 class="param-title"><?= $table["field_desc"] ?></h2>
          <div class="btn-container">
            <a class="valid-button add-button" href="../index.php?page=params&tab=<?= $table["field_name"] ?>&id=0">Ajouter <?= $table["field_p"] ?></a>
          </div>
          <?= $this->dashboard->getCompleteDashboard() ?>
        </div>
      <?php } ?>

    </div>

    <div class="delete-container"></div>
  </main>

  <input type="text" class="target" value="Paramétrages" hidden>
  <script src="js/index.js"></script>
  <script src="js/params.js"></script>
</body>

</html>