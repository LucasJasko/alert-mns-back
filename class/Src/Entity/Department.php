<?php

namespace Src\Entity;

class Department extends \Src\Model\Model
{
  protected static array $formInfos = [

    "form_title" => "Modification du département ",
    "form_fields" => [
      "department_id" => [
        "label" => "Identifiant du département",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "department_name" => [
        "label" => "Nom du département",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "department_id" => "ID",
    "department_name" => "Nom",
  ];

  public function __construct($id, $newData = [])
  {
    $this->tableName = "department";
    $this->searchField = "department_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($id)[0];

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

  public static function formInfos()
  {
    return self::$formInfos;
  }
  public static function dashboardInfos()
  {
    return self::$dashboardInfos;
  }
  public function setFormTitle()
  {
    self::$formInfos["form_title"] .= $this->name();
  }
}
