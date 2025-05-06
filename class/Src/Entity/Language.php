<?php

namespace Src\Entity;

class Language extends \Src\Model\Model
{

  protected static array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du langage ",
      "fields_labels" => [
        "language_id" => "ID",
        "language_name" => "Nom",
      ]
    ],
    "dashboard_infos" => [
      "language_id" => "Identifiant de la langue",
      "language_name" => "Nom de la langue"
    ]
  ];

  public function __construct(int $id)
  {
    $this->id = $id;
    $this->tableName = "language";
    $this->searchField = "language_id";
    $this->initdb($this->tableName, $this->searchField);
    $row = $this->getDBModel($this->id);
    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
    }
  }

  public function all()
  {
    return [
      "language_id" => $this->id(),
      "language_name" =>  $this->name(),
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
