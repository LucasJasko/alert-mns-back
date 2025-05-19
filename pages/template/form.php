<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Tableau de bord - Formulaire de modification</title>
</head>

<body>

  <main class="form__container">

    <h1><?= $formInfos["form_title"] ?></h1>

    <form class="form" action="/<?= $redirectPage ?>" method="post">


      <a class="return-link" href="/<?= $redirectPage ?>"><i class="fa-solid fa-arrow-left"></i></a>

      <?php foreach ($displayedData as $dataField => $dataValue) {

        $label = $formInfos["form_fields"][$dataField]["label"];
        $inputType = $formInfos["form_fields"][$dataField]["input_type"];
        $placeholder = $formInfos["form_fields"][$dataField]["placeholder"];
        $attributes = $formInfos["form_fields"][$dataField]["attributes"];
        ?>

        <label for="<?= $dataField ?>"> <?= $label ?> :</label>

        <?php
        if (str_contains($dataField, $tableName)) {
          ?>
          <input type='<?= $inputType ?>' placeholder='<?= $placeholder ?>' name="<?= $dataField ?>" id="<?= $dataField ?>"
            <?= !empty($dataValue) ? "value='" . $dataValue . "'" : "" ?>     <?= $attributes ?>>

          <?php
        } else {

          if (is_array($dataValue)) {

            empty($dataValue) ? $dataValue[] = [["" => ""]] : "";

            switch ($dataField) {

              case "situation_id":

                for ($index = 0; $index < count($dataValue); $index++) {

                  foreach ($dataValue[$index] as $post => $department) { ?>

                    <div class="dbl-select__container">

                      <select class="dbl-select" name="situation_id[<?= $index ?>][post_id]">
                        <option value="">-- Poste --</option>

                        <?php
                        $options = \Src\Model\Form::getDataOfTable("post");
                        for ($i = 0; $i < count($options); $i++) {
                          ?>

                          <option value="<?= $options[$i]["post_id"] ?>" <?= $options[$i]["post_name"] == $post ? "selected" : "" ?>>
                            <?= $options[$i]["post_name"] ?>
                          </option>

                        <?php } ?>

                      </select>

                      <select class="dbl-select" name="situation_id[<?= $index ?>][department_id]">

                        <option value="">-- Département --</option>

                        <?php
                        $options = \Src\Model\Form::getDataOfTable("department");

                        for ($i = 0; $i < count($options); $i++) { ?>

                          <option value="<?= $options[$i]["department_id"] ?>" <?= $options[$i]["department_name"] == $department ? "selected" : "" ?>><?= $options[$i]["department_name"] ?></option>

                        <?php } ?>

                      </select>

                    </div>

                    <?php
                  }
                } ?>

                <button class="valid-button plus-btn ">Ajouter une situation</button>

                <?php break;

              case "room_id": ?>

                <div class="edit-select__container">

                  <select class="edit-select">

                    <option value="">-- Sélectionnez un salon à éditer --</option>

                    <?php for ($i = 0; $i < count($dataValue); $i++) { ?>
                      <option value="<?= $dataValue[$i]["room_id"] ?>"><?= $dataValue[$i]["room_name"] ?></option>
                    <?php } ?>

                  </select>

                  <a class="valid-button edit-button" href=""> <i class='fa-solid fa-pen'></i></a>
                </div>

                <button class="valid-button plus-btn">Créer un nouveau salon</button>

                <?php break;
            }
          } else {
            ?>
            <select name="<?= $dataField ?>">

              <?php
              $options = \Src\Model\Form::getDataOfTable(str_replace("_id", "", $dataField));

              for ($i = 0; $i < count($options); $i++) {

                $fieldName = str_replace("_id", "_name", $dataField);
                ?>

                <option value="<?= $options[$i][$dataField] ?>" <?= $options[$i][$fieldName] == $displayedData[$dataField] ? "selected" : "" ?>>
                  <?= $options[$i][$fieldName] ?>
                </option>

              <?php } ?>

            </select>

            <?php
          }
        }
      }

      if ($redirectPage == "params") { ?>

        <input class=" table" type="text" name="table_name" value="<?= $tableName ?>" hidden>

      <?php } ?>

      <input class=" table" type="text" value="<?= $redirectPage ?>" hidden>
      <input class="valid-button" type="submit" value="Enregistrer">

    </form>

  </main>
</body>

<script src="/js/form.js"></script>

</html>