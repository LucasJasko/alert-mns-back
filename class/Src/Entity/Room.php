<?php

namespace Src\Entity;

class Room extends \Src\Model\Model
{

  private $state;
  private $type;

  public function __construct($id, $newData = [])
  {
    $this->tableName = "room";
    $this->searchField = "room_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($id)[0];

    if ($row) {
      if (count($row) != 0) {
        $this->hydrate($row, $this->tableName);
      }
    } else {
      $this->hydrate($newData, $this->tableName);
    }
  }
}
