<?php

namespace src\model;

use core\model\ModelManager;

class State extends ModelManager
{

  const MODEL_INFOS =  [
    "form_infos" => [
      "form_title" => "Modification de l'état ",
      "fields_labels" => [
        "state_id" => "ID",
        "state_name" => "Nom",
      ]
    ],
    "dashboard_infos" => [
      "state_id" => "Identifiant de l'état",
      "state_name" => "Nom de l'état"
    ]
  ];

  public function __construct(int $id)
  {
    $this->id = $id;
    $this->tableName = "state";
    $this->searchField = "state_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("state_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }
}
