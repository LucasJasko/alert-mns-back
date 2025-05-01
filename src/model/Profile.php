<?php

namespace src\model;

use core\model\ModelManager;

class Profile extends ModelManager
{
  private ?string $surname = "";
  private string $mail = "";
  private string $password = "";
  private ?string $picture = "";
  private string $language;
  private string $theme;
  private string $status;
  private string $role;

  public static array $modelInfos = [
    "form_infos" => [
      "form_title" => "Modification de l'utilisateur ",
      "fields_labels" => [
        'profile_id' => "Identifiant de l'utilisateur",
        'profile_name' => "Nom de l'utilisateur",
        'profile_surname' => "Prénom de l'utilisateur",
        'profile_mail' => "email de l'utilisateur",
        'profile_password' => "Mot de passe de l'utilisateur",
        'profile_picture' => "Photo de l'utilisateur",
        'language_id' => "Langue de préférence de l'utilisateur",
        'theme_id' => "Thème de préférence de l'utilisateur",
        'status_id' => "Statut de préférence de l'utilisateur",
        'situation_id' => "Situation de l'utilisateur",
        'department_id' => "Département de l'utilisateur",
        'role_id' => "Rôle de l'utilisateur"
      ]
    ],
    "dashboard_infos" => [
      "profile_id" => "ID",
      "profile_name" => "Prénom",
      "profile_surname" => "Nom",
      "profile_mail" => "Mail",
      "profile_password" => "Mot de passe",
      "profile_picture" => "Photo de profil",
      "language_id" => "Langue",
      "theme_id" => "Thème",
      "status_id" => "Etat",
      "situation_id" => "Situation",
      "department_id" => "Département",
      "role_id" => "Rôle"
    ]
  ];

  public function __construct()
  {
    $this->tableName = "profile";
    $this->searchField = "profile_id";
    $this->initdb($this->tableName, $this->searchField);

    if ($this->id != 0) {
      $row = $this->getModel($this->id);
      if (count($row) != 0) {
        $this->hydrate($row);
      }
    }
  }

  public function hydrate($row)
  {
    var_dump($row);
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst($key);
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function setSurname(string $surname)
  {
    $this->surname = $surname;
  }
  public function setMail(string $mail)
  {
    $this->mail = $mail;
  }
  public function setPassword(string $password)
  {
    $this->password = $password;
  }
  public function setPicture(string $picture)
  {
    $this->picture = $picture;
  }
  public function setLanguage(string $languageID)
  {
    $instance = new Language($languageID);
    $this->language = $instance->name();
  }
  public function setTheme(string $themeID)
  {
    $instance = new Theme($themeID);
    $this->theme = $instance->name();
  }
  public function setStatus(string $statusID)
  {
    $instance = new Status($statusID);
    $this->theme = $instance->name();
  }
  public function setRole(string $roleID)
  {
    $instance = new Role($roleID);
    $this->theme = $instance->name();
  }

  public function surname()
  {
    return $this->surname;
  }
  public function mail()
  {
    return $this->mail;
  }
  public function password()
  {
    return $this->password;
  }
  public function picture()
  {
    return $this->picture;
  }
}
