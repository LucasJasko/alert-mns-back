<?php

namespace models;


class User
{

  private $db;
  private $data;
  private static int $id = false;
  private string $name = "";
  private ?string $surname = "";
  private string $mail = "";
  private string $password = "";
  private ?string $picture = "";
  private string $ip = "";
  private string $device = "";
  private string $browser = "";

  public function __construct(array $row = false)
  {
    $this->db = new \core\Database();
    $row ? $this->hydrate($row) : null;
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("user_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function createUser(array $data)
  {
    $fields =  $this->db->getFieldsOfTable("_user");
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne("_user", $fields, $data);
    \core\Log::writeLog("Un utilisateur a été ajouté à la base de donnée.");
  }

  public function getUser(int $id)
  {
    $row = $this->db->getAllWhere("_user", "user_id", $id);
    return $row;
  }

  public function updateUser(int $id, array $newData)
  {
    $param = "user_id";
    $this->data = $newData;
    $res = $this->db->updateOne("_user", $this->data, $param, $id);
  }

  public function deleteUser(int $id)
  {
    $this->db->deleteOne("_user", "user_id", $id);
    \core\Log::writeLog("L'utilisateur " . $id . " a été supprimé de la base de donnée.");
  }

  public function getUserPassword($email)
  {
    $row = $this->db->getWhere("_user", "user_password", "user_mail", $email);
    return $row;
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }
  public function setName(string $name)
  {
    $this->name = $name;
  }
  public function setSurname(string $surname)
  {
    $this->surname = $surname;
  }
  public function setMail(string $mail)
  {
    $this->mail = $mail;
  }
  public function setPassword(string $password)
  {
    $this->password = $password;
  }
  public function setPicture(string $picture)
  {
    $this->picture = $picture;
  }
  public function setIpAddress(string $ipAddress)
  {
    $this->ip = $ipAddress;
  }
  public function setDevice(string $device)
  {
    $this->device = $device;
  }
  public function setBrowser(string $browser)
  {
    $this->browser = $browser;
  }

  public function getId()
  {
    return $this->id;
  }
  public function getName()
  {
    return $this->name;
  }
  public function getSurname()
  {
    return $this->surname;
  }
  public function getMail()
  {
    return $this->mail;
  }
  public function getPassword()
  {
    return $this->password;
  }
  public function getPicture()
  {
    return $this->picture;
  }
  public function getIpAddress()
  {
    return $this->ip;
  }
  public function getDevice()
  {
    return $this->device;
  }
  public function getBrowser()
  {
    return $this->browser;
  }
}
