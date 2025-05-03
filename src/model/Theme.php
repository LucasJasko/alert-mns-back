<?php

namespace src\model;

use core\model\ModelManager;

class Theme extends ModelManager
{

  public static array $modelInfos =  [
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
    $this->id = $id;
    $this->tableName = "theme";
    $this->searchField = "theme_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("theme_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function all()
  {
    return [
      "theme_id" => $this->id(),
      "theme_name" =>  $this->name(),
    ];
  }

  public function setFormName()
  {
    $this->modelInfos["form_infos"]["form_title"] .= $this->name();
  }
}
