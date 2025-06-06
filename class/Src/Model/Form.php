<?php

namespace Src\Model;

class Form
{

  private array $metaInfos;
  private array $fieldsInfos;
  private $db;

  public function __construct(string $tableName, string $redirectPage, array $fieldsInfos = [], $linkedId = "")
  {
    $this->fieldsInfos = $fieldsInfos;
    $this->db = \Src\App::db();

    $this->metaInfos = [
      "table_name" => $tableName,
      "redirect_page" => $redirectPage,
      "linked_id" => $linkedId,
    ];

  }

  public function delete($deleteKey, $id, $isApi)
  {

    if ($isApi) {
      // Process API
    } else {

      \Src\Auth\Auth::protect();

      if ($deleteKey == $_SESSION["delete_key"]) {

        $modelName = "\Src\Model\Entity\\" . ucfirst($this->metaInfos["table_name"]);
        $model = new $modelName($id);

        if ($res = $model->deleteModel()) {
          \Src\App::redirect("error");
        }

        \Src\App::redirect($this->metaInfos["redirect_page"]);

      }

    }

  }

  public function getForm(array $displayedData, string $formTitle, string $returnPage, array $except = [])
  {
    $except = $this->remakeExcept($except);
    $displayedData = $this->compareData($displayedData, $except);

    $fieldsInfos = $this->fieldsInfos;
    $metaInfos = $this->metaInfos;
    $metaInfos["form_title"] = $formTitle;
    $metaInfos["return_page"] = $returnPage;

    require ROOT . "/pages/template/form.php";
  }

  public function getEmptyForm(array $displayedData, string $formTitle, string $returnPage, array $except = [])
  {
    $displayedData = $this->compareData($displayedData, $except);

    $fieldsInfos = $this->fieldsInfos;
    $metaInfos = $this->metaInfos;
    $metaInfos["form_title"] = $formTitle;
    $metaInfos["return_page"] = $returnPage;

    require ROOT . "/pages/template/form.php";
  }

  private function compareData($displayedData, array $except)
  {
    foreach ($displayedData as $key => $value) {
      if (in_array($key, $except)) {
        unset($displayedData[$key]);
      }
    }
    return $displayedData;
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
