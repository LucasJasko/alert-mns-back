<?php

namespace Src\Model;

abstract class Model
{
  protected $db;
  protected $tableName;
  protected $searchField;
  protected $data;

  protected int $id;
  protected string $name;

  public function initdb(string $tableName, string $searchField)
  {
    $this->db = \Src\App::db();

    $this->searchField = $searchField;
    $this->tableName = $tableName;
  }

  public function getFieldsOfModel($table)
  {
    return $this->db->getFieldsOfTable($table);
  }

  public function getDBModel(int $id)
  {
    return $this->db->getOneWhere($this->tableName, $this->searchField, $id);
  }

  public function createNewModel(string $table, array $data)
  {
    $fields = $this->getFieldsOfModel($table);
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]]))
        $data[$fields[$i]] = "";
    }
    $this->db->createOne($this->tableName, $data, $fields);
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


  protected function hydrate($row, $table)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace($table . "_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }
  public function setName(string $name)
  {
    $this->name = $name;
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
  public function name()
  {
    return htmlspecialchars($this->name);
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
