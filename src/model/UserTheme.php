<?php

namespace src\model;

class UserTheme
{
  private $tableName;
  private $db;
  private $data;

  public array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du thème ",
      "fields_labels" => [
        "user_theme_id" => "Identifiant du thème",
        "user_theme_name" => "Nom du thème",
      ]
    ],
    "dashboard_infos" => [
      "user_theme_id" => "ID",
      "user_theme_name" => "Nom",
    ]
  ];

  public function __construct()
  {
    $this->db = new \core\controller\Database();
    $this->tableName = "user_theme";
  }
}
