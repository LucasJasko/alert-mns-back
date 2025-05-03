<?php

namespace src\model;

use core\model\ModelManager;

class Language extends ModelManager
{

  public static array $modelInfos =  [
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

  public function __construct(int $id)
  {
    $this->id = $id;
    $this->tableName = "language";
    $this->searchField = "language_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("language_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function all()
  {
    return [
      "language_id" => $this->id(),
      "language_name" =>  $this->name(),
    ];
  }

  public function setFormName()
  {
    $this->modelInfos["form_infos"]["form_title"] .= $this->name();
  }
}
