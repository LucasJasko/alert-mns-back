<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();

use core\Database;

$db = new Database();
$fields = $db->getFieldsOfTable("user");
$raw = $db->getAll("user");

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

  <div class="btn-container">
    <a class="valid-button add-button" href="../form.php">Ajouter un utilisateur</a>
  </div>

  <main class="main-container">

    <table class="dashboard">

      <thead>
        <?php for ($i = 0; $i < count($fields); $i++) { ?>
          <th>
            <?php
            $fields[$i] = str_replace("user_", "", $fields[$i]);
            echo str_replace("_id", "", $fields[$i]);
            ?>
          </th>
        <?php } ?>
      </thead>

      <tbody>
        <?php for ($i = 0; $i < count($raw); $i++) { ?>
          <tr>
            <?php foreach ($raw[$i] as $key => $value) {
              $userId = $raw[$i]["user_id"];
            ?>
              <td><?= $value ?> </td>
            <?php } ?>
            <td class="user-btn__container"> <a class="user-btn user-btn__update" href="../form.php?id=<?= $userId ?>"><i class="fa-solid fa-pen"></i></a> </td>
            <td class="user-btn__container"> <a class="user-btn user-btn__delete user-btn__delete__<?= $userId ?>"><i class="fa-solid fa-trash-can"></i></a> </td>
          </tr>
        <?php } ?>
      </tbody>

    </table>

    <div class="delete-container"></div>
  </main>

  <input type="text" class="target" value="Utilisateurs" hidden>
  <script src="../script.js"></script>

</body>

</html>