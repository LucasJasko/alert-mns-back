<?php

namespace src\model;

use core\model\ModelManager;

class Language extends ModelManager
{

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du langage ",
      "fields_labels" => [
        "language_id" => "ID",
        "language_name" => "Nom",
      ]
    ],
    "dashboard_infos" => [
      "language_id" => "Identifiant de la langue",
      "language_name" => "Nom de la langue"
    ]
  ];

  public function __construct()
  {
    $this->tableName = "language";
    $this->searchField = "language_id";
    $this->initdb($this->tableName, $this->searchField);

    if ($this->id != 0) {
      $row = $this->getModel($this->id);
      if (count($row) != 0) {
        $this->hydrate($row);
        $this->modelInfos["form_infos"]["form_title"] .= $this->name();
      }
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("language", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }
}
