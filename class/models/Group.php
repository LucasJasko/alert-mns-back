<?php

namespace models;


class Group
{

  private int $id;
  private string $name;
  private State $state;
  private Type $type;

  public function __construct(int $id, string $name, State $state, Type $type)
  {
    $this->$id = $this->setId($id);
    $this->$name = $this->setName($name);
    $this->$state = $this->setState($state);
    $this->$type = $this->setType($type);
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
