<?php

namespace Src\Entity;

use Src\Model\Model;

class Status extends Model
{

  protected static array $modelInfos = [
    "form_infos" => [
      "form_title" => "Modification du statut ",
      "fields_labels" => [
        "status_id" => "Identifiant du statut",
        "status_name" => "Description du statut"
      ]
    ],
    "dashboard_infos" => [
      "status_id" => "ID",
      "status_name" => "Nom",
    ]
  ];

  public function __construct($id)
  {
    $this->id = $id;
    $this->tableName = "status";
    $this->searchField = "status_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
    }
  }

  public function all()
  {
    return [
      "status_id" => $this->id(),
      "status_name" =>  $this->name(),
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
