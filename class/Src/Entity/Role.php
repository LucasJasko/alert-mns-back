<?php

namespace Src\Entity;

class Role extends \Src\Model\Model
{

  protected static array $formInfos = [
    "form_title" => "Modification du rôle",
    "form_fields" => [
      "role_id" => [
        "label" => "Identifiant du rôle",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "role_name" => [
        "label" => "Nom du rôle",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "role_id" => "ID",
    "role_name" => "Nom",
  ];

  public function __construct($id, $newData = [])
  {
    $this->tableName = "role";
    $this->searchField = "role_id";

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
      "role_id" => $this->id(),
      "role_name" =>  $this->name(),
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
