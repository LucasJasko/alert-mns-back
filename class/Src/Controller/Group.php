<?php

namespace Src\Controller;

use Core\Model\Database;
use Src\Model\Group as GroupModel;

class Group
{
  private $dashboard;
  private $dashboardInfos;
  private $form;
  private $formInfos;
  private $db;

  private array $fieldsToNotRender = [];

  private $groupInstance;

  public function __construct()
  {
    $this->formInfos = GroupModel::MODEL_INFOS["form_infos"];
    $this->dashboardInfos = GroupModel::MODEL_INFOS["dashboard_infos"];
    $this->formInfos = GroupModel::MODEL_INFOS["form_infos"];
    $this->db = new Database();
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


    $this->dashboard = new \core\model\Dashboard("group", $groups, $this->dashboardInfos, $this->fieldsToNotRender);
    require_once str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/group.php";
  }

  public function getEmptyForm()
  {
    $this->form = new \core\model\Form("group", "group", $this->formInfos);
    $fieldsOfTable = $this->db->getFieldsOfTable("group");
    return $this->form->getEmptyForm($fieldsOfTable);
  }

  public function getForm(int $id)
  {
    $this->groupInstance = new GroupModel($id);
    $groupData = $this->groupInstance->all();


    $this->form = new \core\model\Form("group", "group", $this->formInfos);
    return $this->form->getForm($groupData);
  }


  public function submitData(array $data)
  {
    $this->groupInstance = new GroupModel($data["group_id"]);
    if (!empty($data["group_id"])) {
      $this->groupInstance->updateModel($data["group_id"], $data);
    } else {
      $this->groupInstance->createNewModel("group", $data);
    }
  }
}
