<?php

namespace src\model;

use core\model\ModelManager;

class Status extends ModelManager
{

  public array $modelInfos =  [
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
    $row = $this->getModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
      $this->modelInfos["form_infos"]["form_title"] .= $this->name();
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("status", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }
}
