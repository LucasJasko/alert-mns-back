<?php

namespace Src\Entity;

class State extends \Src\Model\Model
{

  protected static array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification de l'état ",
      "fields_labels" => [
        "state_id" => "ID",
        "state_name" => "Nom",
      ]
    ],
    "dashboard_infos" => [
      "state_id" => "Identifiant de l'état",
      "state_name" => "Nom de l'état"
    ]
  ];

  public function __construct(int $id)
  {
    $this->tableName = "state";
    $this->searchField = "state_id";
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
