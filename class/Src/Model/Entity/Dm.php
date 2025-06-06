<?php

namespace Src\Model\Entity;

class Dm extends \Src\Model\Model
{

  private int $id;
  private string $creationTime;
  private string $state;
  private string $profileA;
  private string $profileB;

  public function __construct($id, $newData = [])
  {
    $this->id = $id;
    $this->tableName = "dm";
    $this->searchField = "dm_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->db->getOneWhere($this->tableName, $this->searchField, $id);

    if ($row) {
      if (count($row) != 0) {
        $this->hydrate($row, $this->tableName);
      }
    } else {
      $this->hydrate($newData, $this->tableName);
    }
  }

  public function deleteModel()
  {
    try {
      $this->db->deleteOne($this->tableName, $this->searchField, $this->id);
    } catch (\PDOException $e) {
      return $e;
    }
  }

  public function submitModel(array $data)
  {
    if (empty($data["dm_id"])) {
      return $this->createNewModel("dm", $data);
    }
    $this->updateModel($data["dm_id"], $data);
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }
  public function setCreationTime(string $empty)
  {
    $this->creationTime = "";
  }
  public function setState(string $state)
  {
    $this->state = $state;
  }
  public function setProfileA(string $idProfileA)
  {
    $this->profileA = $idProfileA;
  }
  public function setProfileB(string $idProfileB)
  {
    $this->profileB = $idProfileB;
  }
}