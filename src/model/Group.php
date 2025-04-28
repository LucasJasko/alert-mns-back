<?php

namespace src\model;


class Group
{
  private int $id;
  private string $name;
  private State $state;
  private Type $type;
  private string $lastMessage;

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du groupe ",
      "fields_labels" => [
        "group_id" => "Identifiant du groupe",
        "group_name" => "Nom du groupe",
        "group_last_message" => "Dernier message",
        "group_state_id" => "Etat du groupe",
        "group_type_id" => "Type de groupe"
      ]
    ],
    "dashboard_infos" => [
      "group_id" => "ID",
      "group_name" => "Nom",
      "group_last_message" => "Dernier message",
      "group_state_id" => "Etat",
      "group_type_id" => "Type"

    ]
  ];

  public function __construct(array $row = [])
  {
    if (count($row) != 0) {
      $this->hydrate($row);
      $this->modelInfos["form_infos"]["form_title"] .= $this->getName();
    }
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

  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function setLastMessage(string $lastMessage)
  {
    $this->lastMessage = $lastMessage;
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
  public function getLastMessage()
  {
    return $this->lastMessage;
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
