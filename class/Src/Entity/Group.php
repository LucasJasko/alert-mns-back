<?php

namespace Src\Entity;

class Group extends \Src\Model\Model
{
  private $state;
  private $type;

  protected static array $formInfos = [
    "form_title" => "Modification du groupe ",
    "form_fields" => [
      "group_id" => [
        "label" => "Identifiant du groupe",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "group_name" => [
        "label" => "Nom du groupe",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
      "state_id" => [
        "label" => "Etat du groupe",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
      "type_id" => [
        "label" => "Type de groupe",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ]
    ]
  ];

  protected static array $dashboardInfos = [
    "group_id" => "ID",
    "group_name" => "Nom",
    "state_id" => "Etat",
    "type_id" => "Type"
  ];



  public function __construct($id, $newData = [])
  {
    $this->tableName = "group";
    $this->searchField = "group_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($id);

    if ($row) {
      if (count($row) != 0) {
        $this->hydrate($row, $this->tableName);
      }
    } else {
      $this->hydrate($newData, $this->tableName);
    }
  }

  protected function hydrate($row, $table)
  {
    foreach ($row as $key => $value) {
      if (str_contains($key, "group_")) {
        $key = str_replace("group_", "", $key);
      } else {
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

  public static function formInfos()
  {
    return self::$formInfos;
  }
  public static function dashboardInfos()
  {
    return self::$dashboardInfos;
  }
  public function setFormTitle()
  {
    self::$formInfos["form_title"] .= $this->name();
  }
}
