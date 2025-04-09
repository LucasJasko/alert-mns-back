<?php

use core\Database;

require_once $_SERVER["DOCUMENT_ROOT"] . "/class/Autoloader.php";
Autoloader::autoload();


$db = new Database();
$raw = $db->selectAll("user");
$fields = $db->getFields("user");

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Gestion des utilisateurs</title>
</head>

<body>

  <h1>Tableau de bord - Gestion des utilisateurs</h1>

  <main class="main-container">

    <table class="dashboard">

      <thead>
        <?php for ($i = 0; $i < count($fields); $i++) { ?>
          <th>
            <?php
            $fields[$i]["Field"] = str_replace("user_", "", $fields[$i]["Field"]);
            echo str_replace("_id", "", $fields[$i]["Field"]);
            ?>
          </th>
        <?php } ?>
      </thead>

      <tbody>
        <?php for ($i = 0; $i < count($raw); $i++) { ?>
          <tr>
            <?php foreach ($raw[$i] as $key => $value) { ?>
              <td><?= $value ?> </td>
            <?php } ?>
            <td class="user-btn__container"> <a class="user-btn user-btn__update" href=""><i class="fa-solid fa-pen"></i></a> </td>
            <td class="user-btn__container"> <a class="user-btn user-btn__delete" href=""><i class="fa-solid fa-trash-can"></i></a> </td>
          </tr>
        <?php } ?>
      </tbody>

    </table>

    <aside class="stats">
      <h2>Statistiques</h2>
    </aside>

  </main>

</body>

</html>