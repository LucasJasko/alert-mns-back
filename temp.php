<?php $db = new Database();
$fields = $db->getFieldsOfTable("user");
$raw = $db->getAll("user");
?>


<thead>
  <?php for ($i = 0; $i < count($fields); $i++) {
    if ($fields[$i] != "user_picture" && $fields[$i] != "user_device") {
  ?>
      <th>
        <?php
        $fields[$i] = str_replace("user_", "", $fields[$i]);
        echo str_replace("_id", "", $fields[$i]);
        ?>
      </th>
  <?php }
  } ?>
</thead>

<tbody>
  <?php for ($i = 0; $i < count($raw); $i++) {
  ?>
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