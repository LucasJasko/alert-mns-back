<?php

namespace Src\Model;

use Src\Model\Model;


class Type extends Model
{

  const MODEL_INFOS =  [
    "form_infos" => [
      "form_title" => "Modification du type ",
      "fields_labels" => [
        "type_id" => "ID",
        "type_name" => "Nom",
      ]
    ],
    "dashboard_infos" => [
      "type_id" => "Identifiant du type",
      "type_name" => "Nom du type"
    ]
  ];

  public function __construct(int $id)
  {
    $this->id = $id;
    $this->tableName = "type";
    $this->searchField = "type_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
    }
  }
}
