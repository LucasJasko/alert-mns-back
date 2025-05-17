<?php $err = null; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <title>Portail d'accès admin</title>
</head>

<body>
  <h1>Alert-MNS: Portail d'accès admin</h1>

  <div class="login-window">
    <form class="login-form form" action="login" method="post">
      <input type="text" name="email" placeholder="email">
      <input type="password" name="password" placeholder="password">
      <input class="valid-button" type="submit" value="Connexion"> <br>
      <?php if (!is_null($err))
        echo $err; ?>
    </form>
  </div>

</body>

</html>