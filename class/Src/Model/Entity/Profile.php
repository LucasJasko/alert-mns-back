<?php

namespace Src\Model\Entity;

use Src\Model\Relation\ProfileSituation;

class Profile extends \Src\Model\Model
{
  private int $id;
  private string $name;
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
    $this->id = $id;
    $this->tableName = "profile";
    $this->searchField = "profile_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->db->getOneWhere($this->tableName, $this->searchField, $id);

    if ($row) {
      if (count($row) != 0) {
        $this->hydrate($row, $this->tableName);
      }
    } else {
      $this->hydrate($newData, $this->tableName);
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
    if ($this->id != 0) {
      $this->setSituation($this->id);
    }
  }

  public function deleteModel()
  {
    try {
      $this->db->deleteOne($this->tableName, $this->searchField, $this->id);
      \core\Service\Log::writeLog("Le profile " . $this->id() . " : " . $this->name() . " " . $this->surname() . " a été supprimé de la base de donnée.");
    } catch (\PDOException $e) {
      return $e;
    }
  }

  public function submitModel(array $data)
  {
    $data["profile_password"] = password_hash($data["profile_password"], PASSWORD_DEFAULT);

    if (empty($data["profile_id"])) {

      $profileSituation = $this->isolateSituations($data);
      unset($data["situation_id"]);

      $imageManager = new \Src\Service\Image("profile_picture");
      $imageManager->createProfilePicture();

      $lastInsertId = $this->createNewModel("profile", $data);

      $profileSituationInstance = new ProfileSituation($lastInsertId);
      $profileSituationInstance->updateSituations($profileSituation);
    } else {

      $profileSituation = $this->isolateSituations($data);
      unset($data["situation_id"]);

      $imageManager = new \Src\Service\Image("profile_picture");
      $imageManager->createProfilePicture();

      $this->updateModel($data["profile_id"], $data);

      $profileSituationInstance = new ProfileSituation($data["profile_id"]);
      $profileSituationInstance->updateSituations($profileSituation);

    }
  }

  private function isolateSituations($data)
  {
    $profileSituation = $data["situation_id"];
    for ($i = 0; $i <= count($profileSituation); $i++) {
      if (empty($profileSituation[$i]["post_id"]) || empty($profileSituation[$i]["department_id"])) {
        unset($profileSituation[$i]);
      }
    }

    return array_unique($profileSituation, SORT_REGULAR);
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }
  public function setName(string $name)
  {
    $this->name = $name;
  }
  public function setTableName($tableName)
  {
    $this->tableName = $tableName;
  }
  public function setSearchField($searchField)
  {
    $this->searchField = $searchField;
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
  public function id()
  {
    return htmlspecialchars($this->id);
  }
  public function name()
  {
    return htmlspecialchars($this->name);
  }
  public function surname()
  {
    return htmlspecialchars($this->surname);
  }
  public function mail()
  {
    return htmlspecialchars($this->mail);
  }
  public function password()
  {
    return htmlspecialchars($this->password);
  }
  public function language()
  {
    return htmlspecialchars($this->language);
  }
  public function picture()
  {
    return htmlspecialchars($this->picture);
  }
  public function theme()
  {
    return htmlspecialchars($this->theme);
  }
  public function status()
  {
    return htmlspecialchars($this->status);
  }
  public function role()
  {
    return htmlspecialchars($this->role);
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
  public function tableName()
  {
    return htmlspecialchars($this->tableName);
  }
  public function searchField()
  {
    return htmlspecialchars($this->searchField);
  }
}
