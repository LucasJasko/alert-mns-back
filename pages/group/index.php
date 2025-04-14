<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use core\Database;


$db = new Database();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Gestion des groupes</title>
</head>

<body>
  <h1>Alert MNS - Tableau de bord: Gestion des groupes</h1>

  <nav class="navbar">
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
  </nav>

  <?php

  ?>

  <input type="text" class="target" value="Groupes" hidden>
  <script src="../script.js"></script>
</body>

</html>