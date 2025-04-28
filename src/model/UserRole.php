<?php

namespace src\model;

class UserRole
{

  private $tableName;
  private $db;
  private $data;

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du rôle ",
      "fields_labels" => [
        "user_role_id" => "Identifiant du rôle",
        "user_role_name" => "Description du rôle"
      ]
    ],
    "dashboard_infos" => [
      "user_role_id" => "ID",
      "user_role_name" => "Nom",
    ]
  ];

  public function __construct()
  {
    $this->db = new \core\controller\Database();
    $this->tableName = "user_role";
  }
}
