<?php

namespace models;


use core\Database;
use core\Log;

class UserDepartment
{
  private $tableName;
  private $db;
  private $data;

  public function __construct()
  {
    $this->db = new Database();
    $this->tableName = "user_department";
  }

  public function createUserDepartment(array $data)
  {
    $fields =  $this->db->getFieldsOfTable($this->tableName);
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne($this->tableName, $fields, $data);
    Log::writeLog("Un département a été ajouté à la base de donnée.");
  }

  public function getUserDepartment(int $id)
  {
    $row = $this->db->getAllWhere($this->tableName, $this->tableName . "_id", $id);
    return $row;
  }

  public function updateUserDepartment(int $id, array $newData)
  {
    $param = $this->tableName . "_id";
    $this->data = $newData;
    $res = $this->db->updateOne($this->tableName, $this->data, $param, $id);
  }

  public function deleteUserDepartment(int $id)
  {
    $this->db->deleteOne($this->tableName, $this->tableName . "_id", $id);
    Log::writeLog("Le département " . $id . " a été supprimé de la base de donnée.");
  }
}
