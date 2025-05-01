<?php

namespace src\model;

use core\model\ModelManager;

class Theme extends ModelManager
{

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du thème ",
      "fields_labels" => [
        "theme_id" => "Identifiant du thème",
        "theme_name" => "Nom du thème",
      ]
    ],
    "dashboard_infos" => [
      "theme_id" => "ID",
      "theme_name" => "Nom",
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
      $method = "set" . ucfirst(str_replace("theme", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }
}
