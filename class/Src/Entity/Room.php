<?php

namespace Src\Entity;

class Room extends \Src\Model\Model
{

  private $state;
  private $type;
  private $group;

  protected static array $formInfos = [
    "form_title" => "Modification du salon ",
    "form_fields" => [
      "room_id" => [
        "label" => "Identifiant du salon",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "group_id" => [
        "label" => "Groupe du salon",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "room_name" => [
        "label" => "Nom du salon",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
      "state_id" => [
        "label" => "Etat du salon",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
      "type_id" => [
        "label" => "Type du salon",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],

    ]
  ];

  public function __construct($id, $newData = [])
  {
    $this->tableName = "room";
    $this->searchField = "room_id";

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
      if (str_contains($key, "room_")) {
        $key = str_replace("room_", "", $key);
      }
      if (!str_contains($key, "room_")) {
        $key = str_replace("_id", "", $key);
      }
      $method = "set" . $key;
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
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
  public function setGroup(int $groupID)
  {
    $instance = new Group($groupID);
    $this->group = $instance->name();
  }

  public function all()
  {
    return [
      "room_id" => $this->id(),
      "room_name" => $this->name(),
      "state_id" => $this->state(),
      "type_id" => $this->type(),
      "group_id" => $this->group()
    ];
  }
  public function state()
  {
    return $this->state;
  }
  public function type()
  {
    return $this->type;
  }
  public function group()
  {
    return $this->group;
  }
  public static function formInfos()
  {
    return self::$formInfos;
  }
}
