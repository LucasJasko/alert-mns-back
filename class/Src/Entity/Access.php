<?php

namespace Src\Entity;

class Access extends \Src\Model\Model
{
  protected static array $formInfos = [
    "form_title" => "Modification du groupe ",
    "form_fields" => [
      "access_id" => "Identifiant du département",
      "access_name" => "Nom du département"
    ]
  ];

  protected static array $dashboardInfos = [
    "access_id" => "ID",
    "access_name" => "Nom",
  ];

  function __construct($id)
  {
    $this->tableName = "access";
    $this->searchField = "access_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($id)[0];

    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
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
