<?php

namespace Src\Entity;

class Language extends \Src\Model\Model
{

  protected static array $formInfos = [
    "form_title" => "Modification de la langue",
    "form_fields" => [
      "language_id" => [
        "label" => "Identifiant de la langue",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "language_name" => [
        "label" => "Nom de la langue",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "language_id" => "Identifiant de la langue",
    "language_name" => "Nom de la langue"
  ];

  public function __construct(int $id, $newData = [])
  {
    $this->tableName = "language";
    $this->searchField = "language_id";

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
      "language_id" => $this->id(),
      "language_name" =>  $this->name(),
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
