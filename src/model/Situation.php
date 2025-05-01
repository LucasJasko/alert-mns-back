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
    $row = $this->getDBModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("situation_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function situationList()
  {
    $relation = $this->db->getRelationBetween("profile__situation", "situation_id", "profile_id", $this->id);
    return $relation;
  }

  public function setFormName()
  {
    $this->modelInfos["form_infos"]["form_title"] .= $this->name();
  }
}
