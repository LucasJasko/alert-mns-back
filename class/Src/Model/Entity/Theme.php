<?php

namespace Src\Model\Entity;

class Theme extends \Src\Model\Model
{

  private int $id;
  private string $name;
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

  public function __construct(int $id, $newData = [])
  {
    $this->tableName = "theme";
    $this->searchField = "theme_id";

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
      \core\Service\Log::writeLog("Le thème " . $this->id() . " : " . $this->name() . " a été supprimé de la base de donnée.");
    } catch (\PDOException $e) {
      return $e;
    }
  }
  public function submitData(array $data)
  {
    if (empty($data["theme_id"])) {
      $this->createNewModel("theme", $data);
    } else {
      $this->updateModel($data["theme_id"], $data);
    }
    \Src\App::redirect("params");
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
      "theme_id" => $this->id(),
      "theme_name" => $this->name(),
    ];
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
  public static function formInfos()
  {
    return self::$formInfos;
  }
  public static function dashboardInfos()
  {
    return self::$dashboardInfos;
  }
}
