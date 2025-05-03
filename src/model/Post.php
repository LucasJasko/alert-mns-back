<?php

namespace src\model;

use core\model\ModelManager;

class Post extends ModelManager
{

  public static array $modelInfos =  [
    "form_infos" => [
      "form_title" => "Modification du poste ",
      "fields_labels" => [
        "post_id" => "Identifiant du poste",
        "post_name" => "Nom du poste"
      ]
    ],
    "dashboard_infos" => [
      "post_id" => "ID",
      "post_name" => "Nom",
    ]
  ];

  public function __construct($id)
  {

    $this->id = $id;
    $this->tableName = "post";
    $this->searchField = "post_id";

    $this->initdb($this->tableName, $this->searchField);

    $row = $this->getDBModel($id);
    if (count($row) != 0) {
      $this->hydrate($row);
    }
  }

  public function hydrate($row)
  {
    foreach ($row as $key => $value) {
      $method = "set" . ucfirst(str_replace("post_", "", $key));
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }
  }

  public function all()
  {
    return [
      "post_id" => $this->id(),
      "post_name" =>  $this->name(),
    ];
  }

  public function setFormName()
  {
    $this->modelInfos["form_infos"]["form_title"] .= $this->name();
  }
}
