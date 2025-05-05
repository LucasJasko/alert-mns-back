<?php

namespace core\model;

abstract class ModelManager
{
  protected $db;
  protected $tableName;
  protected $searchField;
  protected $data;

  protected int $id;
  protected string $name;

  public function initdb(string $tableName, string $searchField)
  {
    $this->db = new Database();

    $this->searchField = $searchField;
    $this->tableName = $tableName;
  }

  public function getFieldsOfModel($table)
  {
    return $this->db->getFieldsOfTable($table);
  }

  public function getDBModel(int $id)
  {
    $row = $this->db->getAllWhere($this->tableName, $this->searchField, $id);
    return $row;
  }
  public function createNewModel(string $table, array $data)
  {
    $fields =  $this->getFieldsOfModel($table);
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne($this->tableName, $fields, $data);
    // \core\Log::writeLog("Un groupe a été ajouté à la base de donnée.");
  }

  public function updateModel(int $id, array $newData)
  {
    $this->data = $newData;
    $this->db->updateOne($this->tableName, $this->data, $this->searchField, $id);
  }

  public function deleteModel(int $id)
  {
    $this->db->deleteOne($this->tableName, $this->searchField, $id);
    // \core\Log::writeLog("Le groupe " . $id . " a été supprimé de la base de donnée.");
  }

  public function setTableName($tableName)
  {
    $this->tableName = $tableName;
  }
  public function setSearchField($searchField)
  {
    $this->searchField = $searchField;
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

  public function tableName()
  {
    return $this->tableName;
  }
  public function searchField()
  {
    return $this->searchField;
  }
}
