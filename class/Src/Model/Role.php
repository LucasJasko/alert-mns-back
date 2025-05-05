<?php

namespace Src\Model;

use Src\Model\Model;

class Role extends Model
{

  const MODEL_INFOS =  [
    "form_infos" => [
      "form_title" => "Modification du rôle ",
      "fields_labels" => [
        "role_id" => "Identifiant du rôle",
        "role_name" => "Description du rôle"
      ]
    ],
    "dashboard_infos" => [
      "role_id" => "ID",
      "role_name" => "Nom",
    ]
  ];

  public function __construct($id)
  {
    $this->id = $id;
    $this->tableName = "role";
    $this->searchField = "role_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
    }
  }

  public function all()
  {
    return [
      "role_id" => $this->id(),
      "role_name" =>  $this->name(),
    ];
  }
}
