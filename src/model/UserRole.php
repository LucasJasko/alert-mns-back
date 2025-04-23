<?php

namespace models;

class UserRole
{

  private $tableName;
  private $db;
  private $data;

  public function __construct()
  {
    $this->db = new \core\Database();
    $this->tableName = "user_role";
  }

  public function createUserRole(array $data)
  {
    $fields =  $this->db->getFieldsOfTable($this->tableName);
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne($this->tableName, $fields, $data);
    \core\Log::writeLog("Un rôle a été ajouté à la base de donnée.");
  }

  public function getUserRole(int $id)
  {
    $row = $this->db->getAllWhere($this->tableName, $this->tableName . "_id", $id);
    return $row;
  }

  public function updateUserRole(int $id, array $newData)
  {
    $param = $this->tableName . "_id";
    $this->data = $newData;
    $res = $this->db->updateOne($this->tableName, $this->data, $param, $id);
  }

  public function deleteUserRole(int $id)
  {
    $this->db->deleteOne($this->tableName, $this->tableName . "_id", $id);
    \core\Log::writeLog("Le rôle " . $id . " a été supprimé de la base de donnée.");
  }
}
