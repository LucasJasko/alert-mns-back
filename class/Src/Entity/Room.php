<?php

namespace Src\Entity;

class Room extends \Src\Model\Model
{

  private $state = "1";
  private $type = "1";
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
      "room_name" => [
        "label" => "Nom du salon",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
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
      "group_id" => [
        "label" => "Group du salon",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
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
    $this->groupe = $instance->name();
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
