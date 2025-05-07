<?php

namespace Src\Entity;

class Type extends \Src\Model\Model
{

  protected static array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du type ",
      "fields_labels" => [
        "type_id" => "ID",
        "type_name" => "Nom",
      ]
    ],
    "dashboard_infos" => [
      "type_id" => "Identifiant du type",
      "type_name" => "Nom du type"
    ]
  ];

  public function __construct(int $id)
  {
    $this->tableName = "type";
    $this->searchField = "type_id";

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
