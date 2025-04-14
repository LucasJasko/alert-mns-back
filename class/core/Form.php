<?php

namespace core;

use controllers\UserManager;
use core\Database;

class Form
{

  private array $stmt;
  private array $userFieldsLabel = [
    'user_id' => "Identifiant de l'utilisateur",
    'user_name' => "Nom de l'utilisateur",
    'user_surname' => "Prénom de l'utilisateur",
    'user_mail' => "email de l'utilisateur",
    'user_password' => "Mot de passe de l'utilisateur",
    'user_picture' => "Photo de l'utilisateur",
    'user_ip' => "Adresse IP de l'utilisateur",
    'user_device' => "Appareil de l'utilisateur",
    'user_browser' => "Navigateur de l'utilisateur",
    'langue_id' => "Langue de préférence de l'utilisateur",
    'theme_id' => "Thème de préférence de l'utilisateur",
    'statut_id' => "Statut de préférence de l'utilisateur",
    'situation_id' => "Situation de l'utilisateur",
    'role_id' => "Rôle de l'utilisateur"
  ];

  public function getUserForm(int $id)
  {
    $manager = new UserManager();
    $this->stmt = $manager->getUser($id);
    $html = '
      <form class="user-form" action="form.php" method="post">
      <a class="return-link" href="./user/index.php"><i class="fa-solid fa-arrow-left"></i></a>
      ';
    foreach ($this->stmt as $key => $value) {
      $html .= "<label for=" . $key . ">" . $this->userFieldsLabel[$key] . ":</label>
      <input type='text' placeholder='Un champ ici' name=" . $key . " id=" . $key . " value=" . $value . ">
      <br> ";
    }
    $html .= '<input class="valid-button" type="submit" value="Sauvegarder les modifications">
      </form>';
    return $html;
  }

  public function getEmptyUserForm(array $except = ["user_id", 'user_picture', 'user_ip', 'user_device', 'user_browser', 'langue_id', 'theme_id', 'statut_id'])
  {
    $db = new Database();
    $this->stmt = $db->getFieldsOfTable("user");
    $this->stmt = array_diff($this->stmt, $except);

    $html = '
        <form class="user-form" action="form.php" method="post">
        <a class="return-link" href="./user/index.php"><i class="fa-solid fa-arrow-left"></i></a>
        ';
    foreach ($this->stmt as $key) {
      $html .= "<label for=" . $key . ">" . $this->userFieldsLabel[$key] . ":</label>
      <input type='text' placeholder='Un champ ici' name=" . $key . " id=" . $key . ">
      <br> ";
    }
    $html .= '
        <input class="valid-button" type="submit" value="Sauvegarder les modifications">
        </form>
        ';
    return $html;
  }
}
