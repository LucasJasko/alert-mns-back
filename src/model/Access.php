<?php

namespace src\model;

use core\model\ModelManager;

class Access extends ModelManager
{

  public static array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du département ",
      "fields_labels" => [
        "access_id" => "Identifiant du département",
        "access_name" => "Nom du département"
      ]
    ],
    "dashboard_infos" => [
      "access_id" => "ID",
      "access_name" => "Nom",
    ]
  ];

  function __construct($id)
  {
    $row = $this->getDBModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
      $this->modelInfos["form_infos"]["form_title"] .= $this->name();
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("department", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }
}
