<?php

namespace src\model;

use core\model\ModelManager;

class Situation extends ModelManager
{

  const MODEL_INFOS =  [
    "form_infos" => [
      "form_title" => "Modification de la situation ",
      "fields_labels" => [
        "situation_id" => "Identifiant de la situation",
        "situation_name" => "Nom de la situation"
      ]
    ],
    "dashboard_infos" => [
      "situation_id" => "ID",
      "situation_name" => "Nom",
    ]
  ];

  public function __construct($id)
  {

    $this->id = $id;
    $this->tableName = "situation";
    $this->searchField = "situation_id";

    $this->initdb($this->tableName, $this->searchField);

    $row = $this->getDBModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("situation_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }
}
