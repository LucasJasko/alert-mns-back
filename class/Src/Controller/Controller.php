<?php

namespace Src\Controller;

abstract class Controller extends \Core\Controller\Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function modelData($id, $modelName)
  {
    $modelPath = "Src\Entity\\" . ucfirst($modelName);
    $groupInstance = new $modelPath($id);
    return $groupInstance->all();
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
      $models[$i] = $this->modelData($id, $modelName);
    }
    return $models;
  }

  public function unsetFieldsToRender(array $fields, array $fieldsToNotRender)
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

  public function getModelForm(string $modelName, int $id, array $formInfos, $redirectPage = "", $linkedId = "")
  {
    $profileData = $this->modelData($id, $modelName);
    $form = new \Src\Model\Form($modelName, !empty($redirectPage) ? $redirectPage : $modelName, $formInfos, $linkedId);

    return $form->getForm($profileData);
  }

  public function getEmptyModelForm(string $modelName, array $formInfos, $redirectPage = "", $linkedId = "")
  {
    unset($formInfos["form_fields"][$modelName . "_id"]);

    $form = new \Src\Model\Form($modelName, !empty($redirectPage) ? $redirectPage : $modelName, $formInfos, $linkedId);
    $fieldsOfTable = $this->db->getFieldsOfTable($modelName);

    $fieldsOfTable = array_fill_keys($fieldsOfTable, "");

    if (array_key_exists("profile_id", $fieldsOfTable)) {
      $fieldsOfTable["situation_id"] = [["" => ""]];
    }

    if (array_key_exists("room_id", $fieldsOfTable) && array_key_exists("room_id", $fieldsOfTable)) {
      $fieldsOfTable["group_id"] = $linkedId;
    }

    return $form->getEmptyForm($fieldsOfTable, [$modelName . "_id"]);
  }
}
