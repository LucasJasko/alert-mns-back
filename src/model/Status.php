<?php

namespace src\model;

use core\model\ModelManager;

class Status extends ModelManager
{

  const MODEL_INFOS = [
    "form_infos" => [
      "form_title" => "Modification du statut ",
      "fields_labels" => [
        "status_id" => "Identifiant du statut",
        "status_name" => "Description du statut"
      ]
    ],
    "dashboard_infos" => [
      "status_id" => "ID",
      "status_name" => "Nom",
    ]
  ];

  public function __construct($id)
  {
    $this->id = $id;
    $this->tableName = "status";
    $this->searchField = "status_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("status_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function all()
  {
    return [
      "status_id" => $this->id(),
      "status_name" =>  $this->name(),
    ];
  }
}
