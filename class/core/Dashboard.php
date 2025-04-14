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
  private $table;
  private $thead;
  private $tbody;

  public function __construct($TargetTable)
  {
    $this->db = new Database();
    $this->TargetTable = $TargetTable;
    $this->fields = $this->db->getFieldsOfTable($TargetTable);
    $this->data = $this->db->getAll($TargetTable);
    $this->tableOpen = '<table class="dashboard">';
    $this->tableClose = '</table>';
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
    for ($i = 0; $i < count($fields); $i++) {
      if ($fields[$i] != "user_picture" && $fields[$i] != "user_device") {
        $selectedFields .= "<th>" . str_replace("user_", "", str_replace("_id", "", $fields[$i])) . "</th>";
      }
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

  public function getRow($index)
  {
    $row = "<tr>";
    foreach ($index as $key => $value) {
      $userId = $index["user_id"];
      $row .= "<td>" . $value . "</td>";
    }
    $row .= $this->getManageButtons($userId);
    $row .= "</tr>";
    return $row;
  }


  private function getManageButtons($userId)
  {
    $updateBtn = "<td class='user-btn__container'> <a class='user-btn user-btn__update' href='../form.php?id=" . $userId . "'> <i class='fa-solid fa-pen'></i></a> </td>";
    $deleteBtn = "<td class='user-btn__container'> <a class='user-btn user-btn__delete user-btn__delete__" . $userId . "'><i class='fa-solid fa-trash-can'></i></a> </td>";
    return $updateBtn . $deleteBtn;
  }
}
