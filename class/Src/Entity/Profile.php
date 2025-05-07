<?php

namespace Src\Entity;

use Src\Relation\ProfileSituation;

class Profile extends \Src\Model\Model
{

  private string $surname;
  private string $mail;
  private string $password;
  private string $picture;
  private string $language;
  private string $theme;
  private string $status;
  private string $role;
  private array $situation = [];

  protected static array $modelInfos = [
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
        'situation_id' => "Situations de l'utilisateur",
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
      "role_id" => "Rôle"
    ]
  ];

  public function __construct($id)
  {

    $this->id = $id;
    $this->tableName = "profile";
    $this->searchField = "profile_id";

    $this->initdb($this->tableName, $this->searchField);

    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
    }
  }

  public function hydrate($row, $table)
  {
    foreach ($row as $key => $value) {
      if (str_contains($key, "profile_")) {
        $key = str_replace("profile_", "", $key);
      }
      if (!str_contains($key, "profile_")) {
        $key = str_replace("_id", "", $key);
      }
      $method = "set" . $key;
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
    $this->setSituation($this->id);
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
  public function setPicture(string | null $picture)
  {
    if ($picture == null) {
      $this->picture = "le chemin vers une image par défaut";
    } else {
      $this->picture = $picture;
    }
  }
  public function setLanguage(int $languageID)
  {
    $instance = new Language($languageID);
    $this->language = $instance->name();
  }
  public function setTheme(int $themeID)
  {
    $instance = new Theme($themeID);
    $this->theme = $instance->name();
  }
  public function setStatus(int $statusID)
  {
    $instance = new Status($statusID);
    $this->status = $instance->name();
  }
  public function setRole(int $roleID)
  {
    $instance = new Role($roleID);
    $this->role = $instance->name();
  }
  public function setSituation(int $profileId)
  {
    $instance = new ProfileSituation($profileId);
    $this->situation = $instance->setSituations();
  }

  // public function setFormTitle()
  // {
  //   self::$modelInfos["form_infos"]["form_title"] .= $this->name();
  // }

  public function all()
  {
    return [
      "profile_id" => $this->id(),
      "profile_name" =>  $this->name(),
      "profile_surname" => $this->surname(),
      "profile_mail" => $this->mail(),
      "profile_password" => $this->password(),
      "profile_picture" =>  $this->picture(),
      "language_id" => $this->language(),
      "theme_id" => $this->theme(),
      "status_id" => $this->status(),
      "situation_id" => $this->situation(),
      "role_id" =>  $this->role(),
    ];
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
  public function language()
  {
    return $this->language;
  }
  public function picture()
  {
    return $this->picture;
  }
  public function theme()
  {
    return $this->theme;
  }
  public function status()
  {
    return $this->status;
  }
  public function role()
  {
    return $this->role;
  }
  public function situation()
  {
    return $this->situation;
  }
  public static function modelInfos()
  {
    return self::$modelInfos;
  }
}
