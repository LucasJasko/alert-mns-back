<?php

namespace src\model;

class UserSituation
{

  private $tableName;
  private $db;
  private $data;

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification de la situation ",
      "fields_labels" => [
        "user_situation_id" => "Identifiant de la situation",
        "user_situation_name" => "Nom de la situation",
        "situation_department_id" => "Nom du département"
      ]
    ],
    "dashboard_infos" => [
      "user_situation_id" => "ID",
      "user_situation_name" => "Nom",
      "situation_department_id" => "Département",
    ]
  ];

  public function __construct()
  {
    $this->db = new \core\controller\Database();
    $this->tableName = "user_situation";
  }
}
