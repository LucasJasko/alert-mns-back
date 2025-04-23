<?php

namespace models;


class Group
{

  private $db;
  private $data;
  private int $id;
  private string $name;
  private State $state;
  private Type $type;

  public function __construct(int $id, string $name, State $state, Type $type)
  {
    $this->db = new \core\Database();
    $this->$id = $this->setId($id);
    $this->$name = $this->setName($name);
    $this->$state = $this->setState($state);
    $this->$type = $this->setType($type);
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

  public function createGroup(array $data)
  {
    $fields =  $this->db->getFieldsOfTable("_group");
    for ($i = 0; $i < count($fields); $i++) {
      if (!isset($data[$fields[$i]])) $data[$fields[$i]] = "";
    }
    $this->db->createOne("_group", $fields, $data);
    \core\Log::writeLog("Un groupe a été ajouté à la base de donnée.");
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
    \core\Log::writeLog("Le groupe " . $id . " a été supprimé de la base de donnée.");
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }
  public function setName(string $name)
  {
    $this->name = $name;
  }
  public function setState(State $state)
  {
    $this->state = $state;
  }
  public function setType(Type $type)
  {
    $this->type = $type;
  }

  public function getId()
  {
    return $this->id;
  }
  public function getName()
  {
    return $this->name;
  }
  public function getState()
  {
    return $this->state;
  }
  public function getType()
  {
    return $this->type;
  }
}
