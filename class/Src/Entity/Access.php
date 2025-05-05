<?php

namespace Src\Entity;

use Src\Model\Model;

class Access extends Model
{

  const MODEL_INFOS =  [
    "form_infos" => [
      "form_title" => "Modification du département ",
      "fields_labels" => [
        "access_id" => "Identifiant du département",
        "access_name" => "Nom du département"
      ]
    ],
    "dashboard_infos" => [
      "access_id" => "ID",
      "access_name" => "Nom",
    ]
  ];

  function __construct($id)
  {
    $row = $this->getDBModel($id);
    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
    }
  }


  public function applyModelName()
  {
    self::MODEL_INFOS["form_infos"]["form_title"] .= $this->name();
  }
}
