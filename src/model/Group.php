<?php

namespace src\model;

use core\model\ModelManager;

class Group extends ModelManager
{
  private $state;
  private $type;

  const MODEL_INFOS = [
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
    $this->id = $id;
    $this->tableName = "group";
    $this->searchField = "group_id";

    $this->initdb($this->tableName, $this->searchField);

    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      if (str_contains($key, "group_")) {
        $key = str_replace("group_", "", $key);
      }
      if (!str_contains($key, "group_")) {
        $key = str_replace("_id", "", $key);
      }
      $method = "set" . $key;
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function all()
  {
    return [
      "group_id" => $this->id(),
      "group_name" =>  $this->name(),
      "state_id" => $this->state(),
      "type_id" =>  $this->type(),
    ];
  }

  public function setState(int $stateID)
  {
    $instance = new State($stateID);
    $this->state = $instance->name();
  }
  public function setType(int $typeID)
  {
    $instance = new Type($typeID);
    $this->type = $instance->name();
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
