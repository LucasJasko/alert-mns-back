<?php

namespace src\model;


class User
{

  private $db;
  private static int $id = 0;
  private string $name = "";
  private ?string $surname = "";
  private string $mail = "";
  private string $password = "";
  private ?string $picture = "";
  private string $ip = "";
  private string $device = "";
  private string $browser = "";

  public array $modelInfos = [
    "form_infos" => [
      "form_title" => "Modification de l'utilisateur ",
      "fields_labels" => [
        'user_id' => "Identifiant de l'utilisateur",
        'user_name' => "Nom de l'utilisateur",
        'user_surname' => "Prénom de l'utilisateur",
        'user_mail' => "email de l'utilisateur",
        'user_password' => "Mot de passe de l'utilisateur",
        'user_picture' => "Photo de l'utilisateur",
        'user_ip' => "Adresse IP de l'utilisateur",
        'user_device' => "Appareil de l'utilisateur",
        'user_browser' => "Navigateur de l'utilisateur",
        'user_language_id' => "Langue de préférence de l'utilisateur",
        'user_theme_id' => "Thème de préférence de l'utilisateur",
        'user_status_id' => "Statut de préférence de l'utilisateur",
        'user_situation_id' => "Situation de l'utilisateur",
        'user_department_id' => "Département de l'utilisateur",
        'user_role_id' => "Rôle de l'utilisateur"
      ]
    ],
    "dashboard_infos" => [
      "user_id" => "ID",
      "user_name" => "Prénom",
      "user_surname" => "Nom",
      "user_mail" => "Mail",
      "user_password" => "Mot de passe",
      "user_picture" => "Photo de profil",
      "user_ip" => "Adresse IP",
      "user_device" => "OS",
      "user_browser" => "Navigateur",
      "user_language_id" => "Langue",
      "user_theme_id" => "Thème",
      "user_status_id" => "Etat",
      "user_situation_id" => "Situation",
      "user_department_id" => "Département",
      "user_role_id" => "Rôle"
    ]
  ];

  public function __construct(array $row = [])
  {
    if (count($row) != 0) {
      $this->hydrate($row);
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
