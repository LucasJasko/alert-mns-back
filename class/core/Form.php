<?php

namespace core;

use core\Database;

class Form
{

  private string $targetTable;
  private string $targetTableClean;
  private array $stmt;
  private array $fieldsLabel;
  private $manager;
  private $db;

  private static string $staticTargetTableClean;
  private static $staticManager;

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

  public function __construct(string $targetTable)
  {
    $this->db = new Database();
    $this->targetTableClean = $targetTable;
    if ($targetTable == "group") {
      $this->targetTable = str_replace("group", "_group", $targetTable);
    } else if ($targetTable == "user") {
      $this->targetTable = str_replace("user", "_user", $targetTable);
    } else {
      $this->targetTable = $targetTable;
    }
    $managerName = "controllers\\" . ucfirst($this->targetTableClean) . "Manager";
    $this->manager = new $managerName();
    $labels = $this->targetTableClean . "FieldsLabel";
    $this->fieldsLabel = $this->$labels;
  }

  public function getForm(int $id = 0, array $except = [])
  {
    if ($id != 0) {

      $getTable = "get" . ucfirst($this->targetTableClean);
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
      <a class="return-link" href="./' . $this->targetTableClean . '/index.php"><i class="fa-solid fa-arrow-left"></i></a>
      ';
    foreach ($this->stmt as $key => $value) {
      if ($id == 0) $key = $value;
      $html .= "<label for=" . $key . ">" . ($id != 0 ? $this->fieldsLabel[$key] : $this->fieldsLabel[$value]) . ":</label>
      <input type='text' placeholder='Un champ ici' name=" . $key . " id=" . $key . ($id != 0 ? " value=" . $value : "") . ">
      <br> ";
    }
    $html .= '<input class="table" type="text" name="target_table" value="' . $this->targetTableClean . '" hidden>';
    $html .= '<input class="valid-button" type="submit" value="Sauvegarder les modifications">
      </form>';
    return $html;
  }

  public static function submitData(array $data)
  {
    self::$staticTargetTableClean = $data["target_table"];
    array_pop($data);
    $manager = "controllers\\" . ucfirst(self::$staticTargetTableClean) . "Manager";
    self::$staticManager = new $manager();

    if (isset($_POST[self::$staticTargetTableClean . "_id"])) {
      $method = "update" . ucfirst(self::$staticTargetTableClean);
      self::$staticManager->$method($_POST[self::$staticTargetTableClean . "_id"], $data);
    } else {
      $method = "create" . ucfirst(self::$staticTargetTableClean);
      self::$staticManager->$method($data);
    }
    header("Location:/pages/" . self::$staticTargetTableClean . "/index.php");
  }
}
