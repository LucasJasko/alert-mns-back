<?php

namespace Src\Controller;

use Src\Entity\Group as GroupModel;

class Group extends \Src\Controller\Controller
{
  private $dashboard;
  private $dashboardInfos;
  private $form;
  private $formInfos;
  private array $fieldsToNotRender = [];

  private $groupInstance;

  public function __construct()
  {
    parent::__construct();
    $this->formInfos = GroupModel::formInfos();
    $this->dashboardInfos = GroupModel::dashboardInfos();
  }

  public function getGroupDashboard()
  {
    $recordset = $this->db->getField("group", "group_id");

    $clearedRecordset = [];
    for ($i = 0; $i < count($recordset); $i++) {
      $clearedRecordset[$i] = $recordset[$i]["group_id"];
    }

    $groups = [];
    for ($i = 0; $i < count($clearedRecordset); $i++) {
      $id = $clearedRecordset[$i];
      $group = new GroupModel($id);
      $groups[$i] = $group->all();
    }


    $this->dashboard = new \Core\Model\Dashboard("group", $groups, $this->dashboardInfos, $this->fieldsToNotRender);
    require_once ROOT . "/pages/group.php";
  }

  public function getEmptyForm()
  {
    $this->form = new \core\model\Form("group", "group", $this->formInfos);
    $fieldsOfTable = $this->db->getFieldsOfTable("group");

    return $this->form->getEmptyForm($fieldsOfTable, ["group_id"]);
  }

  public function getForm(int $id)
  {
    $this->groupInstance = new GroupModel($id);
    $groupData = $this->groupInstance->all();

    $this->form = new \Core\Model\Form("group", "group", $this->formInfos);
    return $this->form->getForm($groupData);
  }

  public function submitData(array $data)
  {
    if (empty($data["group_id"])) {
      $availableId = $this->getAvailableId("group", "group_id");
      $data["group_id"] = $availableId;

      $this->groupInstance = new GroupModel($data["group_id"], $data);
      $this->groupInstance->createNewModel("group", $data);
    } else {

      $this->groupInstance = new GroupModel($data["group_id"]);
      $this->groupInstance->updateModel($data["group_id"], $data);
    }
  }
}
