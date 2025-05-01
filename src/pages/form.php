<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Formulaire de modification</title>
</head>

<body>
  <main class="form__container">

    <h1><?= $this->formInfos["form_title"] ?></h1>

    <form class="form" action="index.php?page=<?= $this->redirectPage ?>" method="post">
      <a class="return-link" href="./index.php?page=<?= $this->redirectPage ?>"><i class="fa-solid fa-arrow-left"></i></a>
      <?php


      foreach ($this->displayedData as $key => $value) { ?>

        <label for="<?= $key ?>"> <?= $this->formInfos["fields_labels"][$key] ?> :</label>
        <input type='text' placeholder='Un champ ici' name="<?= $key ?>" id="<?= $key ?>" value="<?= $this->displayedData[$key] ?>">
        <br>

      <?php  } ?>

      <?php
      if ($this->redirectPage == "params") {
      ?>
        <input class=" table" type="text" name="table_name" value="<?= $this->tableName ?>" hidden>
      <?php } ?>

      <input class=" table" type="text" value="<?= $this->redirectPage ?> " hidden>
      <input class="valid-button" type="submit" value="Enregistrer">
    </form>

  </main>
</body>

</html>