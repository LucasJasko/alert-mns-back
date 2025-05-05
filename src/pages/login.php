<?php

$err = null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portail d'accès admin</title>
</head>

<body>
  <h1>Back office du projet alert-mns</h1>

  <form action="index.php" method="post">
    <input type="text" name="email" placeholder="email">
    <input type="text" name="password" placeholder="password">
    <input type="submit" value="Envoyer"> <br>
    <?php if (!is_null($err)) echo $err; ?>
  </form>

</body>

</html>