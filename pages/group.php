<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="shortcut icon" href="../assets/img/Speak_32x32.png" type="image/x-icon">
  <title>SPEAK ADMIN - Gestion des groupes</title>
</head>

<body>

  <div class="header">
    <div class="logo-container">
      <img class="speak-logo" src="../assets/img/Speak_64x64.png" alt="logo de l'application Speak">
      <span class="logo-span">SPEAK</span>
    </div>
    <div class="title-container">
      <h1>Tableau de bord - Gestion des groupes</h1>
    </div>
  </div>

  <?php require_once ROOT . "/pages/template/navbar.php" ?>

  <main class="main-container">
    <div class="param-window">
      <div class="btn-container">
        <a class="valid-button add-button" href="group/0">Ajouter un groupe</a>
      </div>
      <?php require_once ROOT . "/pages/template/dashboard.php" ?>
    </div>

    <div class="delete-container"></div>
  </main>

  <input type="text" class="target" value="Groupes" hidden>

  <script src="js/index.js"></script>
  <script src="js/group.js"></script>
</body>

</html>