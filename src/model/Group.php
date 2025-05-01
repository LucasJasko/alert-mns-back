<?php

namespace src\model;

use core\model\ModelManager;

class Group extends ModelManager
{
  private $state;
  private $type;

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du groupe ",
      "fields_labels" => [
        "group_id" => "Identifiant du groupe",
        "group_name" => "Nom du groupe",
        "state_id" => "Etat du groupe",
        "type_id" => "Type de groupe"
      ]
    ],
    "dashboard_infos" => [
      "group_id" => "ID",
      "group_name" => "Nom",
      "state_id" => "Etat",
      "type_id" => "Type"
    ]
  ];

  public function __construct($id)
  {
    $row = $this->getDBModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
      $this->modelInfos["form_infos"]["form_title"] .= $this->name();
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("user_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function setState(State $state)
  {
    $this->state = $state;
  }
  public function setType(Type $type)
  {
    $this->type = $type;
  }

  public function state()
  {
    return $this->state;
  }
  public function type()
  {
    return $this->type;
  }
}
