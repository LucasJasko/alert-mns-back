<?php

namespace src\model;

use core\model\ModelManager;

class Role extends ModelManager
{

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du rôle ",
      "fields_labels" => [
        "role_id" => "Identifiant du rôle",
        "role_name" => "Description du rôle"
      ]
    ],
    "dashboard_infos" => [
      "role_id" => "ID",
      "role_name" => "Nom",
    ]
  ];

  public function __construct($id)
  {
    $this->id = $id;
    $this->tableName = "role";
    $this->searchField = "role_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("role_", "", $key));
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
