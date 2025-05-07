<?php

namespace Src\Entity;

class Situation extends \Src\Model\Model
{

  protected static array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification de la situation ",
      "fields_labels" => [
        "situation_id" => "Identifiant de la situation",
        "situation_name" => "Nom de la situation"
      ]
    ],
    "dashboard_infos" => [
      "situation_id" => "ID",
      "situation_name" => "Nom",
    ]
  ];

  public function __construct($id)
  {
    $this->tableName = "situation";
    $this->searchField = "situation_id";

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
