<?php

namespace core;

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

  public function __construct(string $table, string $field, int $id)
  {
    $db = new Database();
    $this->stmt = $db->selectAllWhere($table, $field, $id);
  }

  public function getUserData()
  {
    return $this->stmt;
  }

  public function getUserFormFields()
  {
    $html = "";
    foreach ($this->stmt as $key => $value) {
      $html .= "<label for=" . $key . ">" . $this->userFieldsLabel[$key] . ":</label>
      <input type='text' placeholder='Un champ ici' name=" . $key . " id=" . $key . " value=" . $value . ">
      <br> ";
    }
    return $html;
  }
}
