<?php

namespace Src\Entity;

class Department extends \Src\Model\Model
{

  protected static array $modelInfos = [
    "form_infos" => [
      "form_title" => "Modification du département ",
      "fields_labels" => [
        "department_id" => "Identifiant du département",
        "department_name" => "Nom du département"
      ]
    ],
    "dashboard_infos" => [
      "department_id" => "ID",
      "department_name" => "Nom",
    ]
  ];

  public function __construct($id, $newData = [])
  {
    $this->tableName = "department";
    $this->searchField = "department_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($id);

    if ($row) {
      if (count($row) != 0) {
        $this->hydrate($row, $this->tableName);
      }
    } else {
      $this->hydrate($newData, $this->tableName);
    }
  }


  public function all()
  {
    return [
      "department_id" => $this->id(),
      "department_name" =>  $this->name(),
    ];
  }

  public function setFormTitle()
  {
    self::$modelInfos["form_infos"]["form_title"] .= $this->name();
  }
  public static function modelInfos()
  {
    return self::$modelInfos;
  }
}
