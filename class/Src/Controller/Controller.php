<?php

namespace Src\Controller;

abstract class Controller extends \Core\Controller\Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getAvailableId($table, $field)
  {
    $res = $this->db->getField($table, $field);
    $id = 1;
    $notFound = true;
    while ($notFound) {
      for ($i = 0; $i < count($res); $i++) {
        if ($id == $res[$i][$field]) {
          $id += 1;
        } else {
          $notFound = false;
          return $id;
        }
      }
    }
  }

  public function modelData($id, $modelName)
  {
    $modelPath = "Src\Entity\\" . $modelName;
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

  public function getForm(string $modelName, int $id, array $formInfos, $tab = "")
  {
    $profileData = $this->modelData($id, ucfirst($modelName));
    $form = new \Src\Model\Form($modelName, !is_null($tab) ? $tab : $modelName, $formInfos);

    return $form->getForm($profileData);
  }


  public function delete(string $table, string $field, int $id)
  {
    $res = $this->db->deleteOne($table, $field, $id);
    return $res;
  }
}
