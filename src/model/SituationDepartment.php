<?php

namespace src\model;


use core\Database;
use core\Log;

class SituationDepartment
{
  private $tableName;
  private $db;
  private $data;

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du département ",
      "fields_labels" => [
        "situation_department_id" => "Identifiant du département",
        "situation_department_name" => "Nom du département"
      ]
    ],
    "dashboard_infos" => [
      "situation_department_id" => "ID",
      "situation_department_name" => "Nom",
    ]
  ];

  public function __construct()
  {
    $this->db = new \core\controller\Database();
    $this->tableName = "situation_department";
  }
}
