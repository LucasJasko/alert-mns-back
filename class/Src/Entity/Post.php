<?php

namespace Src\Entity;

class Post extends \Src\Model\Model
{

  protected static array $formInfos = [
    "form_title" => "Modification du poste",
    "form_fields" => [
      "post_id" => [
        "label" => "Identifiant du poste",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "post_name" => [
        "label" => "Nom du poste",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "post_id" => "ID",
    "post_name" => "Nom",
  ];

  public function __construct($id, $newData = [])
  {
    $this->tableName = "post";
    $this->searchField = "post_id";

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
      "post_id" => $this->id(),
      "post_name" =>  $this->name(),
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
