<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Gestion des groupes</title>
</head>

<body>

  <h1>Alert MNS - Tableau de bord: Gestion des groupes</h1>

  <?php require_once ROOT . "/pages/template/navbar.php" ?>


  <main class="main-container">
    <div class="param-window">
      <div class="btn-container">
        <a class="valid-button add-button" href="group/0">Ajouter un groupe</a>
      </div>

      <?= $dashboard->getCompleteDashboard() ?>
    </div>

    <div class="delete-container"></div>
  </main>

  <input type="text" class="target" value="Groupes" hidden>

  <script src="js/index.js"></script>
  <script src="js/group.js"></script>
</body>

</html>