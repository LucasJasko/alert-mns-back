<?php

namespace Src\Entity;

class NotifType extends \Src\Model\Model
{

  private int $id;
  private string $name;

  function __construct($id)
  {
    $row = $this->db->getOneWhere($this->tableName, $this->searchField, $id);
  }

  public function deleteModel()
  {
    try {
      $this->db->deleteOne($this->tableName, $this->searchField, $this->id);
    } catch (\PDOException $e) {
      return $e;
    }
  }
}
