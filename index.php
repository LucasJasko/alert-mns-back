<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/function.php";

$user1 = new User();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Le back du projet alert-mns</h1>
  <?= var_dump($user1) ?>
</body>

</html>