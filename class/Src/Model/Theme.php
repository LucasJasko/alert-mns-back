<?php

namespace Src\Model;

use Src\Model\Model;

class Theme extends Model
{

  const MODEL_INFOS =  [
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
      $this->hydrate($row, $this->tableName);
    }
  }

  public function all()
  {
    return [
      "theme_id" => $this->id(),
      "theme_name" =>  $this->name(),
    ];
  }
}
