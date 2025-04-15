<?php

namespace core;

use controllers\GroupManager;
use controllers\UserManager;
use core\Database;

class Form
{

  private array $stmt;
  private string $table;
  private $manager;
  private $pageTitle;
  private $db;
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
    'user_language_id' => "Langue de préférence de l'utilisateur",
    'user_theme_id' => "Thème de préférence de l'utilisateur",
    'user_status_id' => "Statut de préférence de l'utilisateur",
    'user_situation_id' => "Situation de l'utilisateur",
    'user_role_id' => "Rôle de l'utilisateur"
  ];

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getUserForm(int $id)
  {
    $manager = new UserManager();
    $this->stmt = $manager->getUser($id);
    $html = '
      <form class="form" action="form.php" method="post">
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

  public function getEmptyUserForm(array $except = [])
  {
    $this->stmt = $this->db->getFieldsOfTable("user");
    $this->stmt = array_diff($this->stmt, $except);

    $html = '
        <form class="form" action="form.php" method="post">
        <a class="return-link" href="./user/index.php"><i class="fa-solid fa-arrow-left"></i></a>
        ';
    foreach ($this->stmt as $key) {
      $html .= "<label for=" . $key . ">" . $this->userFieldsLabel[$key] . ":</label>
      <input type='text' placeholder='Un champ ici' name=" . $key . " id=" . $key . ">
      <br> ";
    }
    $html .= '
        <input class="valid-button" type="submit" value="Ajouter l\'utilisateur">
        </form>
        ';
    return $html;
  }

  public function getGroupForm() {}
}
