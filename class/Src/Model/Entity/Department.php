<?php

namespace Src\Model\Entity;

class Department extends \Src\Model\Model
{

  private int $id;
  private string $name;

  protected static array $formInfos = [

    "form_title" => "Modification du département ",
    "form_fields" => [
      "department_id" => [
        "label" => "Identifiant du département",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required readonly"
      ],
      "department_name" => [
        "label" => "Nom du département",
        "placeholder" => "",
        "input_type" => "text",
        "attributes" => "required"
      ],
    ]
  ];

  protected static array $dashboardInfos = [
    "department_id" => "ID",
    "department_name" => "Nom",
  ];

  public function __construct(int $id, $newData = [])
  {
    $this->tableName = "department";
    $this->searchField = "department_id";

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
      \core\Service\Log::writeLog("Le département " . $this->id() . " : " . $this->name() . " a été supprimé de la base de donnée.");
    } catch (\PDOException $e) {
      return $e;
    }
  }
  public function submitData(array $data)
  {
    if (empty($data["department_id"])) {
      $this->createNewModel("department", $data);
    } else {
      $this->updateModel($data["department_id"], $data);
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
      "department_id" => $this->id(),
      "department_name" => $this->name(),
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
