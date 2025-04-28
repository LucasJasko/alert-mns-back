<?php

namespace src\model;

class ModelManager
{
  private $db;
  private $model;
  private $tableName;
  private $className;
  private $searchField;
  private $data;

  public function __construct(string $tableName, string $className, string $searchField)
  {
    $this->db = new \core\controller\Database();

    $this->searchField = $searchField;
    $this->tableName = $tableName;
    $this->className = $className;

    $pathName = "\src\model\\" . $className;
    $this->model = new $pathName();
  }

  public function getModelInfos()
  {
    return $this->model->modelInfos;
  }

  public function getModelInstance()
  {
    return $this->model;
  }

  public function getFieldsOfTable()
  {
    return $this->db->getFieldsOfTable($this->tableName);
  }

  public function createNewModel(array $data)
  {
    $fields =  $this->getFieldsOfTable();
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne($this->tableName, $fields, $data);
    // \core\Log::writeLog("Un groupe a été ajouté à la base de donnée.");
  }


  public function getModelData(int $id)
  {
    $row = $this->db->getAllWhere($this->tableName, $this->searchField, $id);
    $this->model->hydrate($row);
    return $row;
  }

  public function updateModel(int $id, array $newData)
  {
    $this->data = $newData;
    $res = $this->db->updateOne($this->tableName, $this->data, $this->searchField, $id);
  }

  public function deleteModel(int $id)
  {
    $this->db->deleteOne($this->tableName, $this->searchField, $id);
    // \core\Log::writeLog("Le groupe " . $id . " a été supprimé de la base de donnée.");
  }
}
