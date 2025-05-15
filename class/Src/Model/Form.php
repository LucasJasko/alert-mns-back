<?php

namespace Src\Model;

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
    $except = $this->remakeExcept($except);
    $this->compareData($except);

    $formInfos = $this->formInfos;
    $redirectPage = $this->redirectPage;
    $displayedData = $this->displayedData;
    $tableName = $this->tableName;
    require ROOT . "/pages/form.php";
  }

  public function getEmptyForm(array $fieldsOfTable, array $except = [])
  {
    foreach ($fieldsOfTable as $key => $value) {
      $this->displayedData[$value] = "";
      if ($value == "situation_id") {
        $this->displayedData[$value] = [["" => ""]];
      }
    }
    $this->compareData($except);

    require ROOT . "/pages/form.php";
  }

  private function compareData(array $except)
  {
    foreach ($this->displayedData as $key => $value) {
      if (in_array($key, $except)) {
        unset($this->displayedData[$key]);
      }
    }
  }

  private function remakeExcept($except)
  {
    foreach ($except as $k => $v) {
      $except[$v] = $k;
      unset($except[$k]);
    }
    return $except;
  }

  public static function getDataOfTable($table)
  {
    return \Src\App::db()->getAll($table);
  }
}
