<?php

namespace src\model;

use core\model\ModelManager;

class Type extends ModelManager
{

  public static array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du type ",
      "fields_labels" => [
        "type_id" => "ID",
        "type_name" => "Nom",
      ]
    ],
    "dashboard_infos" => [
      "type_id" => "Identifiant du type",
      "type_name" => "Nom du type"
    ]
  ];

  public function __construct(int $id)
  {
    $this->id = $id;
    $this->tableName = "type";
    $this->searchField = "type_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("type_", "", $key));
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
