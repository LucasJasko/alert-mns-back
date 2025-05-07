<?php

namespace Src\Entity;

class Access extends \Src\Model\Model
{

  protected static array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du département ",
      "fields_labels" => [
        "access_id" => "Identifiant du département",
        "access_name" => "Nom du département"
      ]
    ],
    "dashboard_infos" => [
      "access_id" => "ID",
      "access_name" => "Nom",
    ]
  ];

  function __construct($id)
  {
    $this->tableName = "access";
    $this->searchField = "access_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($id);

    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
    }
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
