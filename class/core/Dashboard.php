<?php

namespace core;

use core\Database;

class Dashboard
{

  private $TargetTable;
  private $db;
  private $fields;
  private $data;
  private $tableOpen;
  private $tableClose;
  private $thead;
  private $tbody;
  private $displayNames;

  public function __construct($TargetTable, array $exceptions = [])
  {
    $this->db = new Database();
    $this->TargetTable = $TargetTable;
    $this->fields = $this->db->getFieldsOfTable($TargetTable);
    $this->data = $this->db->getAll($TargetTable);
    $this->tableOpen = '<table class="dashboard">';
    $this->tableClose = '</table>';

    if (count($exceptions) != 0) {
      $displayableFields = array_diff($this->fields, $exceptions);
      $this->fields = $displayableFields;
    }

    if ($this->TargetTable == "user" && count($exceptions) != 0) {
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
        "langue_id" => "Langue",
        "theme_id" => "N° thème",
        "statut_id" => "Etat",
        "situation_id" => "Situation",
        "role_id" => "Rôle"
      ];
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
      if ($this->TargetTable == "user") $userId = $dataField["user_id"];
      if (in_array($key, $this->fields)) $row .= "<td class='" . $key . "'>" . $value . "</td>";
    }
    $row .= $this->getManageButtons($userId);
    $row .= "</tr>";
    return $row;
  }


  private function getManageButtons($userId)
  {
    $updateBtn = "<td class='btn__container'> <a class='btn btn__update' href='../form.php?id=" . $userId . "'> <i class='fa-solid fa-pen'></i></a> </td>";
    $deleteBtn = "<td class='btn__container'> <a class='btn btn__delete btn__delete__" . $userId . "'><i class='fa-solid fa-trash-can'></i></a> </td>";
    return $updateBtn . $deleteBtn;
  }
}
