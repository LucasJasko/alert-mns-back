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

  protected static array $formInfos = [
    "form_title" => "Modification de l'utilisateur ",
    "form_fields" => [
      'profile_id' => [
        "label" => "Identifiant de l'utilisateur",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      'profile_name' => [
        "label" => "Nom de l'utilisateur",
        "placeholder" => "ex: Jean",
        "input_type" => "text",
        "attributes" => "required"
      ],
      'profile_surname' => [
        "label" => "Prénom de l'utilisateur",
        "placeholder" => "ex: Dupont",
        "input_type" => "text",
        "attributes" => "required"
      ],
      'profile_mail' => [
        "label" => "email de l'utilisateur",
        "placeholder" => "ex: jean.dupont@gmail.com",
        "input_type" => "email",
        "attributes" => "required"
      ],
      'profile_password' => [
        "label" => "Mot de passe de l'utilisateur",
        "placeholder" => "ex: M0nSup&rP@ass98",
        "input_type" => "text",
        "attributes" => "required"
      ],
      'profile_picture' => [
        "label" => "Photo de l'utilisateur",
        "placeholder" => "",
        "input_type" => "file",
        "attributes" => ""
      ],
      'language_id' => [
        "label" => "Langue de préférence de l'utilisateur",
        "placeholder" => "",
        "input_type" => "",
        "attributes" => "required"
      ],
      'theme_id' => [
        "label" => "Thème de préférence de l'utilisateur",
        "placeholder" => "",
        "input_type" => "",
        "attributes" => "required"
      ],
      'status_id' => [
        "label" => "Statut de préférence de l'utilisateur",
        "placeholder" => "",
        "input_type" => "",
        "attributes" => "required"
      ],
      'situation_id' => [
        "label" => "Situations de l'utilisateur",
        "placeholder" => "",
        "input_type" => "",
        "attributes" => "required"
      ],
      'role_id' => [
        "label" => "Rôle de l'utilisateur",
        "placeholder" => "",
        "input_type" => "",
        "attributes" => "required"
      ]
    ]
  ];

  protected static array $dashboardInfos = [
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
  ];


  public function __construct($id, $newData = [])
  {

    $this->tableName = "profile";
    $this->searchField = "profile_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($id);

    if ($row) {
      if (count($row) != 0) {
        $this->hydrate($row, $this->tableName);
      }
    } else {
      $this->hydrate($newData, $this->tableName);
    }
    $this->setFormTitle();
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
    $this->surname = htmlspecialchars($surname);
  }
  public function setMail(string $mail)
  {
    $this->mail = htmlspecialchars($mail);
  }
  public function setPassword(string $password)
  {
    $this->password = htmlspecialchars($password);
  }
  public function setPicture(string|null $picture)
  {
    if ($picture == null) {
      $this->picture = "'le chemin vers une image par défaut'";
    } else {
      $this->picture = htmlspecialchars($picture);
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

  public function all()
  {
    return [
      "profile_id" => $this->id(),
      "profile_name" => $this->name(),
      "profile_surname" => $this->surname(),
      "profile_mail" => $this->mail(),
      "profile_password" => $this->password(),
      "profile_picture" => $this->picture(),
      "language_id" => $this->language(),
      "theme_id" => $this->theme(),
      "status_id" => $this->status(),
      "situation_id" => $this->situation(),
      "role_id" => $this->role(),
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

  public static function formInfos()
  {
    return self::$formInfos;
  }
  public static function dashboardInfos()
  {
    return self::$dashboardInfos;
  }
  public function setFormTitle()
  {
    self::$formInfos["form_title"] .= $this->name();
  }
}
