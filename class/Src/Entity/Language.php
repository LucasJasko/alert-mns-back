<?php

namespace Src\Entity;

class Language extends \Src\Model\Model
{

  private int $id;
  private string $name;

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
    "language_id" => "ID",
    "language_name" => "Nom"
  ];

  public function __construct(int $id, $newData = [])
  {
    $this->tableName = "language";
    $this->searchField = "language_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->db->getOneWhere($this->tableName, $this->searchField, $id);

    if ($row) {
      if (count($row) != 0) {
        $this->hydrate($row, $this->tableName);
      }
    } else {
      $this->hydrate($newData, $this->tableName);
    }
  }

  public function deleteModel()
  {
    try {
      $this->db->deleteOne($this->tableName, $this->searchField, $this->id);
      \core\Service\Log::writeLog("La langue " . $this->id() . " : " . $this->name() . " a été supprimée de la base de donnée.");
    } catch (\PDOException $e) {
      return $e;
    }
  }
  public function submitData(array $data)
  {
    if (empty($data["language_id"])) {
      $this->createNewModel("language", $data);
    } else {
      $this->updateModel($data["language_id"], $data);
    }
  }
  public function setFormTitle()
  {
    self::$formInfos["form_title"] .= $this->name();
  }
  public function setId(int $id)
  {
    $this->id = $id;
  }
  public function setName(string $name)
  {
    $this->name = $name;
  }
  public function setTableName($tableName)
  {
    $this->tableName = $tableName;
  }
  public function setSearchField($searchField)
  {
    $this->searchField = $searchField;
  }


  public function all()
  {
    return [
      "language_id" => $this->id(),
      "language_name" => $this->name(),
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
  public function id()
  {
    return htmlspecialchars($this->id);
  }
  public function name()
  {
    return htmlspecialchars($this->name);
  }
  public function tableName()
  {
    return htmlspecialchars($this->tableName);
  }
  public function searchField()
  {
    return htmlspecialchars($this->searchField);
  }
}
