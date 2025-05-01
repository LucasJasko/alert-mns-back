<?php

namespace src\model;

use core\model\ModelManager;

class Situation extends ModelManager
{

  public array $modelInfos =  [
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
    $row = $this->getModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
      $this->modelInfos["form_infos"]["form_title"] .= $this->name();
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("situation", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }
}
