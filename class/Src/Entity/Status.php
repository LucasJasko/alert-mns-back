<?php

namespace Src\Entity;

class Status extends \Src\Model\Model
{

  protected static array $formInfos = [
    "form_title" => "Modification du statut",
    "form_fields" => [
      "status_id" => [
        "label" => "Identifiant du statut",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "status_name" => [
        "label" => "Nom du statut",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "status_id" => "ID",
    "status_name" => "Nom",
  ];

  public function __construct(int $id, $newData = [])
  {
    $this->tableName = "status";
    $this->searchField = "status_id";

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
      "status_id" => $this->id(),
      "status_name" => $this->name(),
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
