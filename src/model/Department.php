<?php

namespace src\model;

use core\model\ModelManager;

class Department extends ModelManager
{

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du département ",
      "fields_labels" => [
        "department_id" => "Identifiant du département",
        "department_name" => "Nom du département"
      ]
    ],
    "dashboard_infos" => [
      "department_id" => "ID",
      "department_name" => "Nom",
    ]
  ];

  public function __construct($id)
  {
    $row = $this->getDBModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("department", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function setFormName()
  {
    $this->modelInfos["form_infos"]["form_title"] .= $this->name();
  }
}
