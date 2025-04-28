<?php

namespace core\model;

class Dashboard
{
  private $db;
  private $dashboard;
  private $fields;
  private $data;
  private $tableName;
  private $clearedTableName;
  private $page;
  private $model;
  private array $dashboardInfos;

  public function __construct(string $tableName, string $modelName, array $dashboardInfos, array $exceptions = [])
  {
    $this->db = new \core\controller\Database();

    $this->tableName = $tableName;

    switch ($tableName) {
      case "_group":
        $this->clearedTableName = "group";
        $this->page = "group";
        break;
      case "_user":
        $this->clearedTableName = "user";
        $this->page = "user";
        break;
      default:
        $this->clearedTableName = $tableName;
        $this->page = "params";
        break;
    }

    $this->dashboardInfos = $dashboardInfos;


    $this->fields = $this->db->getFieldsOfTable($this->tableName);
    $this->data = $this->db->getAll($this->tableName);


    if (count($exceptions) != 0) {
      $displayableFields = array_diff($this->fields, $exceptions);
      $this->fields = $displayableFields;
    }
  }

  public function getCompleteDashboard()
  {
    $this->dashboard = '<table class="dashboard">';
    $this->dashboard .= $this->getTHead();
    $this->dashboard .= $this->getTBody();
    $this->dashboard .= '</table>';

    return $this->dashboard;
  }

  public function getTHead()
  {
    $thead = "<thead>" . $this->displayFields($this->fields) . "</thead>";
    return $thead;
  }

  public function getTBody()
  {
    $tbody = "<tbody>";
    for ($i = 0; $i < count($this->data); $i++) {
      $tbody .= $this->getRow($this->data[$i]);
    }
    $tbody .= "</tbody>";
    return $tbody;
  }

  private function displayFields($fields)
  {
    $selectedFields = "";
    foreach ($fields as $i => $fieldName) {
      $selectedFields .= "<th>" . $this->dashboardInfos["dashboard_infos"][$fieldName] . "</th>";
    }
    return $selectedFields;
  }


  public function getRow($dataField)
  {
    $row = "<tr class=\"" . $this->tableName . " " . $this->model . "\">";
    foreach ($dataField as $key => $value) {
      $id = $dataField[$this->clearedTableName . "_id"];
      if (in_array($key, $this->fields)) $row .= "<td class='" . $key . "'>" . $value . "</td>";
    }
    $row .= $this->getManageButtons($id);
    $row .= "</tr>";
    return $row;
  }


  private function getManageButtons($id)
  {
    $updateBtn = "<td class='btn__container'> <a class='btn btn__update' href='../index.php?page=" . $this->page . "&id=" . $id . "'> <i class='fa-solid fa-pen'></i></a> </td>";
    $deleteBtn = "<td class='btn__container'> <a class='btn btn__delete btn__delete__" . $id . "'><i class='fa-solid fa-trash-can'></i></a> </td>";
    return $updateBtn . $deleteBtn;
  }
}
