<?php

namespace core\model;

class Dashboard
{
  private $dashboard;
  private $data;
  private $tableName;
  private $page;
  private $tab;
  private $modelName;
  private array $dashboardInfos;

  public function __construct(string $tableName, array $data, array $dashboardInfos, array $exceptions = [])
  {
    $this->tableName = $tableName;
    $this->modelName = ucfirst($this->tableName);

    $this->page = $_GET["page"];
    $this->tab = $tableName;
    $this->data = $data;

    $this->dashboardInfos = $dashboardInfos;

    if (count($exceptions) != 0) {
      foreach ($exceptions as $index => $field) {
        if ($this->dashboardInfos[$field]) {
          unset($this->dashboardInfos[$field]);
        }
      }
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
    $thead = "<thead>" . $this->displayFields($this->dashboardInfos) . "</thead>";
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
    foreach ($fields as $fieldName => $label) {
      $selectedFields .= "<th>" . $label . "</th>";
    }
    return $selectedFields;
  }


  public function getRow($dataArray)
  {
    $row = "<tr class=\"" . $this->tableName . "\">";
    $id = $dataArray[$this->tableName . "_id"];
    foreach ($this->dashboardInfos as $key => $value) {
      $row .= "<td class='" . $key . "'>";
      if (isset($dataArray[$key])) {
        if (is_array($dataArray[$key])) {
          foreach ($dataArray[$key] as $key => $value) {
            $row .=  $key . " de " . $value;
            $row .= "</br>";
          }
        } else {
          $row .= $dataArray[$key];
        }
      }
      $row .= "</td>";
    }
    $row .= $this->getManageButtons($id) . "</tr>";
    return $row;
  }


  private function getManageButtons($id)
  {
    $updateBtn = "<td class='btn__container'> <a class='btn btn__update' href='../index.php?page=" . $this->page . ($this->page == "params" ? "&tab=" . $this->tab : "") . "&id=" . $id . "'> <i class='fa-solid fa-pen'></i></a> </td>";
    $deleteBtn = "<td class='btn__container'> <a class='btn btn__delete btn__delete__" . $id . "'><i class='fa-solid fa-trash-can'></i></a> </td>";
    return $updateBtn . $deleteBtn;
  }
}
