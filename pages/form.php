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
      <?php var_dump($this->displayedData); ?>

      <?php foreach ($this->displayedData as $key => $value) {
        $dblSelect = $key == "situation_id" ? true : false;
      ?>

        <label for="<?= $key ?>"> <?= $this->formInfos["fields_labels"][$key] ?> :</label>

        <?php if (str_contains($key, $this->tableName)) { ?>
          <!-- Input texte -->

          <input type='text' placeholder='Un champ ici' name="<?= $key ?>" id="<?= $key ?>" value="<?= $this->displayedData[$key] ?>">

          <?php
        } else {

          // Input select
          if ($key == "situation_id") { ?>

            <div class="dbl-select__container">

              <select class="dbl-select" name="post_id">
                <option value="">-- Poste --</option>

                <?php
                $options = $this->getDataOfTable("post");
                for ($i = 0; $i < count($options); $i++) {
                ?>
                  <option value="<?= $options[$i]["post_id"] ?>"><?= $options[$i]["post_name"] ?></option>
                <?php } ?>

              </select>

              <select class="dbl-select" name="department_id">
                <option value="">-- Département --</option>

                <?php
                $options = $this->getDataOfTable("department");
                for ($i = 0; $i < count($options); $i++) { ?>
                  <option value="<?= $options[$i]["department_id"] ?>"><?= $options[$i]["department_name"] ?></option>
                <?php } ?>

              </select>

              <div class="valid-button plus-btn">+</div>

            </div>


          <?php } else {
          ?>
            <select name="<?= $key ?>">

              <?php
              $options = $this->getDataOfTable(str_replace("_id", "", $key));
              for ($i = 0; $i < count($options); $i++) {
              ?>
                <option value="<?= $options[$i][$key] ?>" <?= $options[$i][str_replace("_id", "_name", $key)] == $this->displayedData[$key] ? "selected" : "" ?>><?= $options[$i][str_replace("_id", "_name", $key)] ?></option>
              <?php } ?>

            </select>

        <?php
          }
        } ?>


      <?php
      }

      if ($this->redirectPage == "params") { ?>

        <input class=" table" type="text" name="table_name" value="<?= $this->tableName ?>" hidden>

      <?php } ?>

      <input class=" table" type="text" value="<?= $this->redirectPage ?> " hidden>
      <input class="valid-button" type="submit" value="Enregistrer">

    </form>

  </main>
</body>

</html>