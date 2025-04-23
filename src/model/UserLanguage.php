<?php

namespace models;


use core\Database;
use core\Log;

class UserLanguage
{
  private $tableName;
  private $db;
  private $data;

  public function __construct()
  {
    $this->db = new Database();
    $this->tableName = "user_language";
  }

  public function createUserLanguage(array $data)
  {
    $fields =  $this->db->getFieldsOfTable($this->tableName);
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne($this->tableName, $fields, $data);
    Log::writeLog("Une langue a été ajouté à la base de donnée.");
  }

  public function getUserLanguage(int $id)
  {
    $row = $this->db->getAllWhere($this->tableName, $this->tableName . "_id", $id);
    return $row;
  }

  public function updateUserLanguage(int $id, array $newData)
  {
    $param = $this->tableName . "_id";
    $this->data = $newData;
    $res = $this->db->updateOne($this->tableName, $this->data, $param, $id);
  }

  public function deleteUserLanguage(int $id)
  {
    $this->db->deleteOne($this->tableName, $this->tableName . "_id", $id);
    Log::writeLog("La langue " . $id . " a été supprimée de la base de donnée.");
  }
}
