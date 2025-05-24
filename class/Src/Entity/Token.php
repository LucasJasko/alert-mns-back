<?php

namespace Src\Entity;

class Token extends \Src\Model\Model
{

  private int $id;
  private string $value;
  private $expirationTime;
  private $creationTime;
  private $userAgent;
  private $profileId;

  public function __construct()
  {
    $this->tableName = "token";
    $this->searchField = "token_id";
    $this->initdb($this->tableName, $this->searchField);

  }

  public function token($id, $newData = [])
  {
    $row = $this->db->getOneWhere($this->tableName, $this->searchField, $id);

    if ($row) {
      if (count($row) != 0) {
        $this->hydrate($row, $this->tableName);
      }
    } else {
      $this->hydrate($newData, $this->tableName);
    }
  }

  public function deleteModel($id)
  {
    try {
      $this->db->deleteOne($this->tableName, $this->searchField, $id);
    } catch (\PDOException $e) {
      return $e;
    }
  }
}
