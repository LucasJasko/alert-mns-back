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

            <?php var_dump($this->displayedData) ?>

            <?php foreach ($this->displayedData as $dataField => $dataValue) {

                $label = $this->formInfos["form_fields"][$dataField]["label"];
                $inputType = $this->formInfos["form_fields"][$dataField]["input_type"];
                $placeholder = $this->formInfos["form_fields"][$dataField]["placeholder"];
                $attributes = $this->formInfos["form_fields"][$dataField]["attributes"];
            ?>

                <label for="<?= $dataField ?>"> <?= $label ?> :</label>

                <?php if (str_contains($dataField, $this->tableName)) { ?>
                    <!-- Input texte -->

                    <input
                        type='<?= $inputType ?>'
                        placeholder='<?= $placeholder ?>'
                        name="<?= $dataField ?>"
                        id="<?= $dataField ?>"
                        <?= !empty($dataValue) ? "value='" . $dataValue . "'" : "" ?>
                        <?= $attributes ?>>

                    <?php
                } else {

                    // Input select
                    if (is_array($dataValue)) {

                        switch ($dataField) {
                            case "situation_id":
                                if (empty($dataValue)) $dataValue[] = [["" => ""]];

                                for ($index = 0; $index < count($dataValue); $index++) {

                                    foreach ($dataValue[$index] as $post => $department) { ?>

                                        <div class="dbl-select__container">

                                            <select class="dbl-select" name="<?= $dataField ?>[<?= $index ?>][post_id]">
                                                <option value="">-- Poste --</option>

                                                <?php
                                                $options = $this->getDataOfTable("post");
                                                for ($i = 0; $i < count($options); $i++) {
                                                ?>
                                                    <option value="<?= $options[$i]["post_id"] ?>" <?= $options[$i]["post_name"] == $post ? "selected" : "" ?>><?= $options[$i]["post_name"] ?></option>
                                                <?php } ?>

                                            </select>

                                            <select class="dbl-select" name="<?= $dataField ?>[<?= $index ?>][department_id]">
                                                <option value="">-- Département --</option>

                                                <?php
                                                $options = $this->getDataOfTable("department");
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
                        }
                    } else {
                        ?>
                        <select name="<?= $dataField ?>">

                            <?php
                            $options = $this->getDataOfTable(str_replace("_id", "", $dataField));
                            for ($i = 0; $i < count($options); $i++) {
                            ?>
                                <option value="<?= $options[$i][$dataField] ?>" <?= $options[$i][str_replace("_id", "_name", $dataField)] == $this->displayedData[$dataField] ? "selected" : "" ?>><?= $options[$i][str_replace("_id", "_name", $dataField)] ?></option>
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

<script src="js/form.js"></script>

</html>