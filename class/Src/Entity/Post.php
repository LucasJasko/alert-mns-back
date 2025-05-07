<?php

namespace Src\Entity;

class Post extends \Src\Model\Model
{

  protected static array $modelInfos =  [
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

  public function __construct($id, $newData = [])
  {
    $this->tableName = "post";
    $this->searchField = "post_id";

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
      "post_id" => $this->id(),
      "post_name" =>  $this->name(),
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
