<?php

namespace Src\Entity;

class State extends \Src\Model\Model
{

  protected static array $formInfos = [
    "form_title" => "Modification de l'état",
    "form_fields" => [
      "state_id" => [
        "label" => "Identifiant de l'état",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "state_name" => [
        "label" => "Nom de l'état",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "state_id" => "ID",
    "state_name" => "Nom",
  ];


  public function __construct(int $id, $newData = [])
  {
    $this->tableName = "state";
    $this->searchField = "state_id";
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
