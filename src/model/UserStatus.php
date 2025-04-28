<?php

namespace src\model;

class UserStatus
{
  private $tableName;
  private $db;
  private $data;

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du statut ",
      "fields_labels" => [
        "user_status_id" => "Identifiant du statut",
        "user_status_name" => "Description du statut"
      ]
    ],
    "dashboard_infos" => [
      "user_status_id" => "ID",
      "user_status_name" => "Nom",
    ]
  ];

  public function __construct()
  {
    $this->db = new \core\controller\Database();
    $this->tableName = "user_status";
  }
}
