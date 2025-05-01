<?php

namespace src\model;

use core\model\ModelManager;

class Role extends ModelManager
{
  private int $id;
  private string $name;

  public array $modelInfos =  [
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
    $row = $this->getModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
      $this->modelInfos["form_infos"]["form_title"] .= $this->name();
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("role", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }
  public function setName(string $name)
  {
    $this->name = $name;
  }
  public function id()
  {
    return $this->id;
  }
  public function name()
  {
    return $this->name;
  }
}
