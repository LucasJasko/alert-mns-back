<table class="dashboard">

  <thead>
    <?php
    foreach ($fields as $fieldName => $label):
      ?>
      <th><?= $label ?></th>
    <?php endforeach ?>

  </thead>

  <tbody>

    <?php for ($i = 0; $i < count($data); $i++): ?>

      <tr class="<?= $tab ?>">

        <?php foreach ($fields as $key => $value): ?>

          <td class="<?= $key ?>">

            <?php if (isset($data[$i][$key])) {

              if (is_array($data[$i][$key])) {

                for ($y = 0; $y < count($data[$y][$key]); $y++) {

                  foreach ($data[$i][$key][$y] as $post => $department) {
                    echo $post . " de " . $department;
                  }

                }

              } else {

                echo $data[$i][$key];

              } ?>

            </td>

          <?php }

        endforeach ?>

        <td class="btn__container">

          <a class="btn btn__update"
            href="<?= $page . ($page == "params" ? "/" . $tab : "") . "/" . $data[$i][$tab . "_id"] ?>">
            <i class='fa-solid fa-pen'></i>
          </a>

        </td>

        <td class='btn__container'>

          <a class='btn btn__delete' href="<?= $page . "/" . $data[$i][$tab . "_id"] ?>&process=delete" id="<?= $page ?>">
            <i class='fa-solid fa-trash-can'></i>
          </a>

        </td>

      </tr>

    <?php endfor ?>

  </tbody>

</table>