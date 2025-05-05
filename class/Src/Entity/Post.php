<?php

namespace Src\Entity;

use Src\Model\Model;

class Post extends Model
{

  const MODEL_INFOS =  [
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
      $this->hydrate($row, $this->tableName);
    }
  }

  public function all()
  {
    return [
      "post_id" => $this->id(),
      "post_name" =>  $this->name(),
    ];
  }
}
