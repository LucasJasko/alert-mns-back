<?php

namespace Src\Entity;

class Theme extends \Src\Model\Model
{

  protected static array $formInfos = [
    "form_title" => "Modification du thème",
    "form_fields" => [
      "theme_id" => [
        "label" => "Identifiant du thème",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "theme_name" => [
        "label" => "Nom du thème",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "theme_id" => "ID",
    "theme_name" => "Nom",
  ];

  public function __construct($id, $newData = [])
  {
    $this->tableName = "theme";
    $this->searchField = "theme_id";

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

  public function all()
  {
    return [
      "theme_id" => $this->id(),
      "theme_name" =>  $this->name(),
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
