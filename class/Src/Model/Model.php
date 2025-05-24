<?php

namespace Src\Model;

abstract class Model
{
  protected $db;
  protected $tableName;
  protected $searchField;
  protected $data;

  public function initdb(string $tableName, string $searchField)
  {
    $this->db = \Src\App::db();

    $this->searchField = $searchField;
    $this->tableName = $tableName;
  }

  public function createNewModel(string $table, array $data)
  {
    $fields = $this->db->getFieldsOfTable($table);

    foreach ($fields as $key => $value) {
      if (!isset($data[$value]))
        $data[$value] = "";
    }

    if (isset($data["profile_password"])) {
      $data["profile_password"] = password_hash($data["profile_password"], PASSWORD_DEFAULT);
    }

    $this->db->createOne($this->tableName, $data, $fields);
    \Core\Service\Log::writeLog($this->tableName . " a été ajouté à la base de donnée.");
  }

  public function updateModel(int $id, array $newData)
  {
    if (isset($newData["profile_password"])) {
      $newData["profile_password"] = password_hash($newData["profile_password"], PASSWORD_DEFAULT);
    }
    $this->db->updateOne($this->tableName, $newData, $this->searchField, $id);
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
}
