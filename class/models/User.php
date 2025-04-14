<?php

namespace models;


class User
{
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
