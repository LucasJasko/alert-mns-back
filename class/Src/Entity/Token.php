<?php

namespace Src\Entity;

class Token extends \Src\Model\Model
{

  private int $id;
  private string $value;

  public function deleteModel()
  {
    try {
      $this->db->deleteOne($this->tableName, $this->searchField, $this->id);
    } catch (\PDOException $e) {
      return $e;
    }
  }
}
