<?php

namespace src\controller;

class GroupController
{
  private $groupManager;
  private $groupInstance;
  private $groupInfos;

  private $dashboard;
  private $form;

  public function __construct()
  {
    $this->groupManager = new \src\model\ModelManager("_group", "Group", "group_id");
    $this->groupInfos = $this->groupManager->getModelInfos();
  }

  public function getView()
  {
    $this->dashboard = new \core\model\Dashboard("_group", "Group", $this->groupInfos);
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/group.php";
  }



  public function getForm(int $id)
  {
    $this->groupInstance = $this->groupManager->getModelData($id);
    $model = $this->groupInstance->getModelData($id);

    $this->groupInfos["form_title"] .= $model["group_name"];

    $this->form = new \core\controller\Form("_group", "group", $this->groupInfos);
    return $this->form->getForm($model);
  }

  public function getEmptyForm()
  {
    $this->form = new \core\controller\Form("_group", "group", $this->groupInfos);
    $fieldsOfTable = $this->groupInstance->getFieldsOfTable();
    return $this->form->getEmptyForm($fieldsOfTable);
  }

  public function submitData($data)
  {
    if (!empty($data["group_id"])) {
      $this->groupInstance->updateModel($data["group_id"], $data);
    } else {
      $this->groupInstance->createModel($data);
    }
  }
}
