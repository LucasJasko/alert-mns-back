<?php

namespace core;

use core\Database;

class Dashboard
{
  private $db;
  private $fields;
  private $data;
  private $tableOpen;
  private $tableClose;
  private $thead;
  private $tbody;
  private $displayNames;
  private $targetTable;
  private $targetTableClean;

  public function __construct($targetTable, array $exceptions = [])
  {
    $this->db = new Database();
    $this->targetTableClean = $targetTable;
    if ($targetTable == "group") {
      $this->targetTable = str_replace("group", "_group", $targetTable);
      $this->displayNames = [
        "group_id" => "ID",
        "group_name" => "Nom",
        "group_last_message" => "Dernier message",
        "group_state_id" => "Etat",
        "group_type_id" => "Type"
      ];
    } else if ($targetTable == "user") {
      $this->targetTable = str_replace("user", "_user", $targetTable);
      $this->displayNames = [
        "user_id" => "ID",
        "user_name" => "Prénom",
        "user_surname" => "Nom",
        "user_mail" => "Mail",
        "user_password" => "Mot de passe",
        "user_picture" => "Photo de profil",
        "user_ip" => "Adresse IP",
        "user_device" => "OS",
        "user_browser" => "Navigateur",
        "user_language_id" => "Langue",
        "user_theme_id" => "Thème",
        "user_status_id" => "Etat",
        "user_situation_id" => "Situation",
        "user_role_id" => "Rôle"
      ];
    } else {
      $this->targetTable = $targetTable;
    }
    $this->fields = $this->db->getFieldsOfTable($this->targetTable);
    $this->data = $this->db->getAll($this->targetTable);
    $this->tableOpen = '<table class="dashboard">';
    $this->tableClose = '</table>';

    if (count($exceptions) != 0) {
      $displayableFields = array_diff($this->fields, $exceptions);
      $this->fields = $displayableFields;
    }
  }

  public function openTable()
  {
    return $this->tableOpen;
  }
  public function closeTable()
  {
    return $this->tableClose;
  }

  public function getTHead()
  {
    $this->thead = "<thead>" . $this->displayFields($this->fields) . "</thead>";
    return $this->thead;
  }
  private function displayFields($fields)
  {
    $selectedFields = "";
    foreach ($fields as $field) {
      if (isset($field)) ($selectedFields .= "<th>" . $this->displayNames[$field] . "</th>");
    }
    return $selectedFields;
  }

  public function getTBody()
  {
    $this->tbody = "<tbody>";
    for ($i = 0; $i < count($this->data); $i++) {
      $this->tbody .= $this->getRow($this->data[$i]);
    }
    $this->tbody .= "</tbody>";
    return $this->tbody;
  }

  public function getRow($dataField)
  {
    $row = "<tr>";
    foreach ($dataField as $key => $value) {
      $id = $dataField[$this->targetTableClean . "_id"];
      if (in_array($key, $this->fields)) $row .= "<td class='" . $key . "'>" . $value . "</td>";
    }
    $row .= $this->getManageButtons($id);
    $row .= "</tr>";
    return $row;
  }


  private function getManageButtons($id)
  {
    $updateBtn = "<td class='btn__container'> <a class='btn btn__update' href='../form.php?form_type=" . $this->targetTableClean . "&id=" . $id . "'> <i class='fa-solid fa-pen'></i></a> </td>";
    $deleteBtn = "<td class='btn__container'> <a class='btn btn__delete btn__delete__" . $id . "'><i class='fa-solid fa-trash-can'></i></a> </td>";
    return $updateBtn . $deleteBtn;
  }
}
