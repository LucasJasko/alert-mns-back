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
    $this->formInfos = $formInfos;
    $this->redirectPage = $redirectPage;
    $this->db = \Src\App::db();
  }


  public function getForm(array $data, array $except = [])
  {
    $this->displayedData = $data;
    foreach ($except as $k => $v) {
      $except[$v] = $k;
      unset($except[$k]);
    }
    $this->compareData($except);
    require ROOT . "/pages/form.php";
  }

  public function getEmptyForm(array $fieldsOfTable, array $except = [])
  {
    foreach ($fieldsOfTable as $key => $value) {
      $this->displayedData[$value] = "";
    }
    $this->compareData($except);
    require ROOT . "/pages/form.php";
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
