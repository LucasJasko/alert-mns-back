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

      <?php foreach ($this->displayedData as $key => $value) { ?>

        <label for="<?= $key ?>"> <?= $this->formInfos["fields_labels"][$key] ?> :</label>

        <?php if (str_contains($key, $this->tableName)) { ?>

          <input type='text' placeholder='Un champ ici' name="<?= $key ?>" id="<?= $key ?>" value="<?= $this->displayedData[$key] ?>">

          <?php } else {

          if ($key == "situation_id") {

            $options = $this->getValuesOfField("post_id");
          ?>
            <div class="dbl-select__container">

              <select class="dbl-select" name="<?= $key ?>">

                <option value="">-- Poste --</option>
                <?php
                for ($i = 0; $i < count($options); $i++) { ?>
                  <option value="<?= $options[$i][$this->fieldName] ?>"><?= $options[$i][$this->fieldName] ?></option>
                <?php } ?>

              </select>

              <?php
              $options = $this->getValuesOfField("department_id"); ?>

              <select class="dbl-select" name="<?= $key ?>">

                <option value="">-- Département --</option>
                <?php
                for ($i = 0; $i < count($options); $i++) { ?>
                  <option value="<?= $options[$i][$this->fieldName] ?>"><?= $options[$i][$this->fieldName] ?></option>
                <?php } ?>

              </select>
              <div class="valid-button plus-btn">+</div>
            </div>

          <?php } else { ?>

            <select name="<?= $key ?>">

              <?php
              $options = $this->getValuesOfField($key);
              for ($i = 0; $i < count($options); $i++) { ?>
                <option value="<?= $options[$i][$this->fieldName] ?>"><?= $options[$i][$this->fieldName] ?></option>
              <?php } ?>

            </select>


          <?php } ?>


        <?php
        }
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