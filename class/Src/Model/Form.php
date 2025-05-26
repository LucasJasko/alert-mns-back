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
      "delete_key" => $_SESSION["delete_key"]
    ];

  }

  public function delete($deleteKey, $id, $isApi)
  {

    \Src\Auth\Auth::protect();

    if ($isApi) {
      // Process API
    } else {

      if ($deleteKey == $_SESSION["delete_key"]) {

        $modelName = "\Src\Model\Entity\\" . ucfirst($this->metaInfos["table_name"]);
        $model = new $modelName($id);

        $res = $model->deleteModel();

        if ($res) {
          \Src\App::redirect("error");
        }
        \Src\App::redirect($this->metaInfos["redirect_page"]);

      }

    }

  }

  public function getForm(array $displayedData, string $formTitle, array $except = [])
  {
    $except = $this->remakeExcept($except);
    $displayedData = $this->compareData($displayedData, $except);

    $fieldsInfos = $this->fieldsInfos;
    $metaInfos = $this->metaInfos;

    if (str_contains($metaInfos["redirect_page"], "room/")) {
      // TODO a terme ce code est a modifier car il genere le lien de retour pour des ID allant jusqu'à 9 !!
      $returnPage = substr(str_replace("room", "group", $metaInfos["redirect_page"]), 0, 7);
    } else {
      $returnPage = $metaInfos["redirect_page"];
    }

    require ROOT . "/pages/template/form.php";
  }

  public function getEmptyForm(array $displayedData, string $formTitle, array $except = [])
  {
    $displayedData = $this->compareData($displayedData, $except);

    $fieldsInfos = $this->fieldsInfos;
    $metaInfos = $this->metaInfos;

    if (str_contains($metaInfos["redirect_page"], "room/")) {
      $returnPage = substr(str_replace("room", "group", $metaInfos["redirect_page"]), 0, 7);
    } else {
      $returnPage = $metaInfos["redirect_page"];
    }

    if ($metaInfos["table_name"] == "room") {
      $groupName = $this->db->getFieldWhere("group", "group_name", "group_id", $displayedData["group_id"]);
    }

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
