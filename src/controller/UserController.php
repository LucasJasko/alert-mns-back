<?php

namespace src\controller;

class UserController
{
  private $userManager;
  private $userInstance;
  private $userInfos;

  private $dashboard;
  private $form;

  public function __construct()
  {
    $this->userManager = new \src\model\ModelManager("_user", "User", "user_id");
    $this->userInfos = $this->userManager->getModelInfos();
  }

  public function getView()
  {
    $this->dashboard = new \core\model\Dashboard("_user", "User", $this->userInfos);
    require_once str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/user.php";
  }

  public function getForm(int $id)
  {
    $this->userInstance = $this->userManager->getModelData($id);
    $model = $this->userInstance->getModelData($id);

    $this->userInfos["form_title"] .= $model["user_name"];

    $this->form = new \core\controller\Form("_user", "user", $this->userInfos);
    return $this->form->getForm($model);
  }

  public function getEmptyForm()
  {
    $this->form = new \core\controller\Form("_group", "group", $this->userInfos);
    $fieldsOfTable = $this->userInstance->getFieldsOfTable();
    return $this->form->getEmptyForm($fieldsOfTable);
  }

  public function submitData($data)
  {
    if (!empty($data["group_id"])) {
      $this->userInstance->updateModel($data["group_id"], $data);
    } else {
      $this->userInstance->createModel($data);
    }
  }
}
