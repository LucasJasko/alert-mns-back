<?php

namespace controllers;

use core\Database;
use core\Log;

class UserManager
{

  private $db;
  private $data;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function createUser(array $data)
  {
    $fields =  $this->db->getFieldsOfTable("user");
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne("user", $fields, $data);
    Log::writeLog("Un utilisateur a été ajouté à la base de donnée.");
  }

  public function getUser(int $id)
  {
    $row = $this->db->getAllWhere("user", "user_id", $id);
    return $row;
  }

  public function updateUser(int $id, array $newData)
  {
    $param = "user_id";
    $this->data = $newData;
    $res = $this->db->updateOne("user", $this->data, $param, $id);
  }

  public function deleteUser(int $id)
  {
    $this->db->deleteOne("user", "user_id", $id);
    Log::writeLog("L'utilisateur " . $id . " a été supprimé de la base de donnée.");
  }

  public function getUserPassword($email)
  {
    $row = $this->db->getWhere("user", "user_password", "user_mail", $email);
    return $row;
  }
}
