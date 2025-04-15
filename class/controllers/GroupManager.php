<?php

namespace controllers;

use core\Database;
use core\Log;

class GroupManager
{

  private $db;
  private $data;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function createGroup(array $data)
  {
    $fields =  $this->db->getFieldsOfTable("_group");
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne("_group", $fields, $data);
    Log::writeLog("Un groupe a été ajouté à la base de donnée.");
  }

  public function getGroup(int $id)
  {
    $row = $this->db->getAllWhere("_group", "group_id", $id);
    return $row;
  }

  public function updateGroup(int $id, array $newData)
  {
    $param = "group_id";
    $this->data = $newData;
    $res = $this->db->updateOne("_group", $this->data, $param, $id);
  }

  public function deleteGroup(int $id)
  {
    $this->db->deleteOne("_group", "group_id", $id);
    Log::writeLog("Le groupe " . $id . " a été supprimé de la base de donnée.");
  }
}
