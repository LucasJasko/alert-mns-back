<?php

namespace Src\Controller;

abstract class Controller extends \Core\Controller\Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function clearRecordset($recordset, $tab)
  {
    for ($i = 0; $i < count($recordset); $i++) {
      $clearedRecordset[$i] = $recordset[$i][$tab . "_id"];
    }
    return $clearedRecordset;
  }

  public function getModelsFromRecordset($recordset, $modelName)
  {
    for ($i = 0; $i < count($recordset); $i++) {
      $id = $recordset[$i];
      $modelPath = "Src\Model\Entity\\" . ucfirst($modelName);
      $modelInstance = new $modelPath($id);
      $models[$i] = $modelInstance->all();
    }
    return $models;
  }

  public function unsetFieldsToNotRender(array $fields, array $fieldsToNotRender)
  {
    if (count($fieldsToNotRender) != 0) {
      foreach ($fieldsToNotRender as $index => $field) {
        if ($fields[$field]) {
          unset($fields[$field]);
        }
      }
    }
    return $fields;
  }

  public function getDashboard($pageName, $paramsConfig = [], $dashboardInfos = [], $fieldsToNotRender = [])
  {

    if ($pageName == "profile" || $pageName == "group") {
      $recordset = $this->db->getField($pageName, $pageName . "_id");
      $clearedRecordset = $this->clearRecordset($recordset, $pageName);
      $profiles = $this->getModelsFromRecordset($clearedRecordset, ucfirst($pageName));

      $fields = $this->unsetFieldsToNotRender($dashboardInfos, $fieldsToNotRender);
      $data = $profiles;
      $tab = $pageName;
      $page = $pageName;

      require_once ROOT . "/pages/" . $pageName . ".php";
      return;
    }

    foreach ($paramsConfig as $table => $v) {
      $recordset = $this->db->getField($table, $table . "_id");
      $clearedRecordset = $this->clearRecordset($recordset, $table);

      for ($i = 0; $i < count($clearedRecordset); $i++) {
        $recordsets[$table] = $this->getModelsFromRecordset($clearedRecordset, $table);
        $ParamsFields[$table][] = $this->db->getFieldsOfTable($table);
      }
    }

    require_once ROOT . "/pages/params.php";
  }


  // TODO réimplémenter les appels au formualires (getModelForm et getEmptyModelForm) dans les controleurs à l'image du group

  public function getModelForm(string $modelName, int $id, array $formInfos, string $formTitle, $redirectPage = "", $linkedId = "")
  {
    $modelPath = "Src\Model\Entity\\" . ucfirst($modelName);
    $modelInstance = new $modelPath($id);
    $modelData = $modelInstance->all();

    $form = new \Src\Model\Form($modelName, empty($redirectPage) ? $modelName : $redirectPage, $formInfos, $linkedId);

    $form->getForm($modelData, $formTitle);
  }





  public function getEmptyModelForm(string $modelName, array $formInfos, string $formTitle, $redirectPage = "", $linkedId = "")
  {
    unset($formInfos[$modelName . "_id"]);

    $form = new \Src\Model\Form($modelName, empty($redirectPage) ? $modelName : $redirectPage, $formInfos, $linkedId);
    $fieldsOfTable = $this->db->getFieldsOfTable($modelName);

    $fieldsOfTable = array_fill_keys($fieldsOfTable, "");

    if (array_key_exists("profile_id", $fieldsOfTable)) {
      $fieldsOfTable["situation_id"] = [["" => ""]];
    }

    if (array_key_exists("room_id", $fieldsOfTable) && array_key_exists("room_id", $fieldsOfTable)) {
      $fieldsOfTable["model_id"] = $linkedId;
    }

    $form->getEmptyForm($fieldsOfTable, $formTitle, [$modelName . "_id"]);
  }



}
