<?php

namespace core\model;

class Form
{

  private string $tableName;
  private array $formInfos;
  private $displayedData = [];
  private string $redirectPage;
  private $db;

  public function __construct(string $tableName, string $redirectPage, array $formInfos)
  {
    $this->tableName = $tableName;
    var_dump($this->tableName);
    $this->formInfos = $formInfos;
    var_dump($this->formInfos);
    $this->redirectPage = $redirectPage;
    $this->db = new Database();
  }


  public function getForm(array $data, array $except = [])
  {
    $this->displayedData = $data;
    foreach ($except as $k => $v) {
      $except[$v] = $k;
      unset($except[$k]);
    }
    $this->compareData($except);
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/form.php";
  }

  public function getEmptyForm(array $fieldsOfTable, array $except = [])
  {
    foreach ($fieldsOfTable as $key => $value) {
      $this->displayedData[$value] = "";
    }
    $this->compareData($except);
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/form.php";
  }

  private function compareData(array $except)
  {
    foreach ($this->displayedData as $key => $value) {
      if (!array_key_exists($key, $except)) {
        $this->displayedData[$key] = $value;
      }
    }
  }

  public function getDataOfTable($table)
  {
    return $this->db->getAll($table);
  }
}
