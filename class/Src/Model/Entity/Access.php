<?php

namespace Src\Model\Entity;

class Access extends \Src\Model\Model
{

  private int $id;
  private string $name;

  protected static array $formInfos = [
    "access_id" => "Identifiant du département",
    "access_name" => "Nom du département"
  ];

  protected static array $dashboardInfos = [
    "access_id" => "ID",
    "access_name" => "Nom",
  ];

  function __construct($id)
  {
    $this->tableName = "access";
    $this->searchField = "access_id";

    $this->initdb($this->tableName, $this->searchField);
    $row = $this->db->getOneWhere($this->tableName, $this->searchField, $id)[0];

    if (count($row) != 0) {
      $this->hydrate($row, $this->tableName);
    }
  }

  public function deleteModel()
  {
    try {
      $this->db->deleteOne($this->tableName, $this->searchField, $this->id);
      \core\Service\Log::writeLog("L'autorisation " . $this->id() . " : " . $this->name() . " a été supprimée de la base de donnée.");
    } catch (\PDOException $e) {
      return $e;
    }
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
