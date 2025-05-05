<?php

namespace Src\Entity;

use Src\Model\Model;

class State extends Model
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
      $this->hydrate($row, $this->tableName);
    }
  }
}
