<?php

namespace core;

use core\Database;

class Form
{

  private string $targetTable;
  private string $className;
  private string $targetReturnPage;
  private array $stmt;
  private array $fieldsLabel;
  private $manager;
  private $db;

  private static $staticManager;
  private static string $staticTargetTable;
  private static string $staticClassName;
  private static string $staticFieldName;
  private static string $staticRedirectPage;

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
    'user_department_id' => "Département de l'utilisateur",
    'user_role_id' => "Rôle de l'utilisateur"
  ];
  private array $groupFieldsLabel =  [
    "group_id" => "Identifiant du groupe",
    "group_name" => "Nom du groupe",
    "group_last_message" => "Dernier message",
    "group_state_id" => "Etat du groupe",
    "group_type_id" => "Type de groupe"
  ];
  private array $userSituationFieldsLabel =  [
    "user_situation_id" => "Identifiant de la situation",
    "user_situation_name" => "Nom de la situation"
  ];
  private array $userDepartmentFieldsLabel =  [
    "user_department_id" => "Identifiant du département",
    "user_department_name" => "Nom du département"
  ];
  private array $userStatusFieldsLabel =  [
    "user_status_id" => "Identifiant du statut",
    "user_status_name" => "Description du statut"
  ];
  private array $userRoleFieldsLabel =  [
    "user_role_id" => "Identifiant du rôle",
    "user_role_name" => "Description du rôle"
  ];
  private array $userLanguageFieldsLabel =  [
    "user_language_id" => "Identifiant de la langue",
    "user_language_name" => "Nom de la langue"
  ];
  private array $userThemeFieldsLabel =  [
    "user_theme_id" => "Identifiant du thème",
    "user_theme_name" => "Nom du thème",
    "user_theme_color_1" => "Couleur 1 (format hexadécimal, ex: #AAABB111)",
    "user_theme_color_2" => "Couleur 2 (format hexadécimal, ex: #AAABB111)",
    "user_theme_color_3" => "Couleur 3 (format hexadécimal, ex: #AAABB111)",
    "user_theme_color_4" => "Couleur 4 (format hexadécimal, ex: #AAABB111)"
  ];

  public function __construct(string $targetTable, string $className = "")
  {
    $this->db = new Database();
    $this->targetTable = $targetTable;
    $this->className = $className;
    if ($targetTable == "group") {
      $this->targetReturnPage = $targetTable;
      $this->targetTable = str_replace("group", "_group", $targetTable);
    } else if ($targetTable == "user") {
      $this->targetReturnPage = $targetTable;
      $this->targetTable = str_replace("user", "_user", $targetTable);
    } else {
      $this->targetReturnPage = "params";
    }
    $managerName = "controllers\\" . $this->className . "Manager";
    $this->manager = new $managerName();
    $labels = lcfirst($this->className) . "FieldsLabel";
    $this->fieldsLabel = $this->$labels;
  }

  public function getForm(int $id = 0, array $except = [])
  {
    if ($id != 0) {

      $getTable = "get" . $this->className;
      $this->stmt = $this->manager->$getTable($id);

      $exceptFilled = [];
      for ($i = 0; $i < count($except); $i++) {
        $exceptFilled += [$except[$i] => ""];
      }

      $newStmt = [];
      foreach ($this->stmt as $key => $value) {
        if (!array_key_exists($key, $exceptFilled)) $newStmt[$key] = $value;
      }

      $this->stmt = $newStmt;
    }
    if ($id == 0) {
      $this->stmt = $this->db->getFieldsOfTable($this->targetTable);
      $this->stmt = array_values(array_diff($this->stmt, $except));
    }

    $html = '
      <form class="form" action="form.php" method="post">
      <a class="return-link" href="./' . $this->targetReturnPage . '/index.php"><i class="fa-solid fa-arrow-left"></i></a>
      ';
    foreach ($this->stmt as $key => $value) {
      if ($id == 0) $key = $value;
      $html .= "<label for=" . $key . ">" . ($id != 0 ? $this->fieldsLabel[$key] : $this->fieldsLabel[$value]) . ":</label>
      <input type='text' placeholder='Un champ ici' name=" . $key . " id=" . $key . ($id != 0 ? " value=" . $value : "") . ">
      <br> ";
    }
    $html .= '<input class="table" type="text" name="target_table" value="' . $this->targetTable . '" hidden>';
    $html .= '<input class="table" type="text" name="class_name" value="' . $this->className . '" hidden>';
    $html .= '<input class="valid-button" type="submit" value="' . ($id != 0 ? "Sauvegarder les modifications" : "Enregistrer") . '">
      </form>';
    return $html;
  }

  public static function submitData(array $data)
  {
    self::$staticTargetTable = $data["target_table"];
    self::$staticClassName = $data["class_name"];
    self::$staticRedirectPage = lcfirst(self::$staticClassName);
    array_pop($data);
    array_pop($data);
    if (self::$staticTargetTable == "_user") {
      self::$staticFieldName = str_replace("_user", "user", self::$staticTargetTable);
    } else if (self::$staticTargetTable == "_group") {
      self::$staticFieldName = str_replace("_group", "group", self::$staticTargetTable);
    } else {
      self::$staticFieldName = self::$staticTargetTable;
      self::$staticRedirectPage = "params";
    }

    $manager = "controllers\\" . self::$staticClassName . "Manager";
    self::$staticManager = new $manager();

    if (isset($data[self::$staticFieldName . "_id"])) {
      $method = "update" . self::$staticClassName;
      self::$staticManager->$method($data[self::$staticFieldName . "_id"], $data);
    } else {
      $method = "create" . self::$staticClassName;
      self::$staticManager->$method($data);
    }
    header("Location:/pages/" . self::$staticRedirectPage . "/index.php");
  }
}
