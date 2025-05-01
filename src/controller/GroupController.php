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
    $this->groupManager = new \core\model\ModelManager("group", "Group", "group_id");
    $this->groupInfos = $this->groupManager->getModelInfos();
  }

  public function getView()
  {
    $this->dashboard = new \core\model\Dashboard("group", "Group", $this->groupInfos);
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/group.php";
  }

  public function getEmptyForm()
  {
    $this->form = new \core\model\Form("group", "Group", $this->groupInfos["form_infos"]);
    $fieldsOfTable = $this->groupManager->getFieldsOfTable();
    return $this->form->getEmptyForm($fieldsOfTable);
  }

  public function getForm(int $id)
  {
    $this->groupInstance = $this->groupManager->getModelData($id);

    $this->form = new \core\model\Form("group", "Group", $this->groupInfos["form_infos"]);

    return $this->form->getForm($this->groupInstance);
  }


  public function submitData(array $data)
  {
    if (!empty($data["group_id"])) {
      $this->groupManager->updateModel($data["group_id"], $data);
    } else {
      $this->groupManager->createNewModel($data);
    }
  }
}
