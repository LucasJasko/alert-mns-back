<?php

namespace Src\Entity;

class Type extends \Src\Model\Model
{

  protected static array $formInfos = [
    "form_title" => "Modification du type",
    "form_fields" => [
      "type_id" => [
        "label" => "Identifiant du type",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "type_name" => [
        "label" => "Nom du type",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "type_id" => "ID",
    "type_name" => "Nom",
  ];

  public function __construct(int $id, $newData = [])
  {
    $this->tableName = "type";
    $this->searchField = "type_id";

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
