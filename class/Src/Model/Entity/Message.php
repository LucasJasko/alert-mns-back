<?php

namespace Src\Model\Entity;

class Message extends \Src\Model\Model
{

  private int $id;
  private int $exp;
  private int $dest;
  private string $content;
  private string $date;
  private string|array $file;

  public function __construct($id)
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

  public function setId(int $id)
  {
    $this->id = $id;
  }
  public function setTableName($tableName)
  {
    $this->tableName = $tableName;
  }
  public function setSearchField($searchField)
  {
    $this->searchField = $searchField;
  }

  public function id()
  {
    return htmlspecialchars($this->id);
  }
  public function tableName()
  {
    return htmlspecialchars($this->tableName);
  }
  public function searchField()
  {
    return htmlspecialchars($this->searchField);
  }
}
