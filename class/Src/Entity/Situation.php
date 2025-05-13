<?php

namespace Src\Entity;

class Situation extends \Src\Model\Model
{

  protected static array $formInfos = [
    "form_title" => "Modification de la situation",
    "form_fields" => [
      "situation_id" => [
        "label" => "Identifiant de la situation",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "situation_name" => [
        "label" => "Nom de la situation",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "situation_id" => "ID",
    "situation_name" => "Nom",
  ];

  public function __construct($id, $newData = [])
  {
    $this->tableName = "situation";
    $this->searchField = "situation_id";

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
