<table class="dashboard">

  <thead>
    <?php
    foreach ($fields as $fieldName => $label):
      ?>
      <th><?= $label ?></th>
    <?php endforeach ?>

  </thead>

  <tbody>


    <?php for ($dataIndex = 0; $dataIndex < count($data); $dataIndex++): ?>

      <tr class="<?= $tab ?>">

        <?php foreach ($fields as $fieldName => $label): ?>

          <td class="<?= $fieldName ?>">

            <?php if (isset($data[$dataIndex][$fieldName])) {

              if (is_array($data[$dataIndex][$fieldName])) {

                for ($fieldValueIndex = 0; $fieldValueIndex < count($data[$dataIndex][$fieldName]); $fieldValueIndex++) {

                  foreach ($data[$dataIndex][$fieldName][$fieldValueIndex] as $post => $department) { ?>
                    <?= $post . " de " . $department; ?>
                    </br>
                  <?php }

                }

              } else { ?>

                <?= $data[$dataIndex][$fieldName] ?>

              <?php } ?>

            </td>

          <?php }

        endforeach ?>

        <td class="btn__container">

          <a class="btn btn__update"
            href="<?= $page . ($page == "params" ? "/" . $tab : "") . "/" . $data[$dataIndex][$tab . "_id"] ?>">
            <i class='fa-solid fa-pen'></i>
          </a>

        </td>

        <td class='btn__container'>

          <a class='btn btn__delete' href="<?= $page . "/" . $data[$dataIndex][$tab . "_id"] ?>&process=delete"
            id="<?= $page ?>">
            <i class='fa-solid fa-trash-can'></i>
          </a>

        </td>

      </tr>

    <?php endfor ?>

  </tbody>

</table>