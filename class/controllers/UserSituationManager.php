<?php

namespace controllers;

use core\Database;
use core\Log;

class UserSituationManager
{

  private $tableName;
  private $db;
  private $data;

  public function __construct()
  {
    $this->db = new Database();
    $this->tableName = "user_situation";
  }

  public function createUserSituation(array $data)
  {
    $fields =  $this->db->getFieldsOfTable($this->tableName);
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne($this->tableName, $fields, $data);
    Log::writeLog("Une situation a été ajouté à la base de donnée.");
  }

  public function getUserSituation(int $id)
  {
    $row = $this->db->getAllWhere($this->tableName, $this->tableName . "_id", $id);
    return $row;
  }

  public function updateUserSituation(int $id, array $newData)
  {
    $param = $this->tableName . "_id";
    $this->data = $newData;
    $res = $this->db->updateOne($this->tableName, $this->data, $param, $id);
  }

  public function deleteUserSituation(int $id)
  {
    $this->db->deleteOne($this->tableName, $this->tableName . "_id", $id);
    Log::writeLog("La situation " . $id . " a été supprimé de la base de donnée.");
  }
}
