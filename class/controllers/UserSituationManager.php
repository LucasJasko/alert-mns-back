<?php

namespace controllers;

use core\Database;
use core\Log;

class UserSituationManager
{

  private $db;
  private $data;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function createUserSituation(array $data)
  {
    $fields =  $this->db->getFieldsOfTable("user_situation");
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne("user_situation", $fields, $data);
    Log::writeLog("Une situation a été ajouté à la base de donnée.");
  }

  public function getUserSituation(int $id)
  {
    $row = $this->db->getAllWhere("user_situation", "user_id", $id);
    return $row;
  }

  public function updateUserSituation(int $id, array $newData)
  {
    $param = "user_id";
    $this->data = $newData;
    $res = $this->db->updateOne("user_situation", $this->data, $param, $id);
  }

  public function deleteUserSituation(int $id)
  {
    $this->db->deleteOne("user_situation", "user_id", $id);
    Log::writeLog("La situation " . $id . " a été supprimé de la base de donnée.");
  }
}
