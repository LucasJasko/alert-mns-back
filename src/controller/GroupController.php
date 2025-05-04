<?php

namespace src\controller;

use core\model\Database;
use src\model\Group;

class GroupController
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
    $this->formInfos = Group::MODEL_INFOS["form_infos"];
    $this->dashboardInfos = Group::MODEL_INFOS["dashboard_infos"];
    $this->db = new Database();
    $this->formInfos = Group::MODEL_INFOS["form_infos"];
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
      $group = new Group($id);
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
    $this->groupInstance = new Group($id);
    $groupData = $this->groupInstance->all();


    $this->form = new \core\model\Form("group", "group", $this->formInfos);
    return $this->form->getForm($groupData);
  }


  public function submitData(array $data)
  {
    $this->groupInstance = new Group($data["group_id"]);
    if (!empty($data["group_id"])) {
      $this->groupInstance->updateModel($data["group_id"], $data);
    } else {
      $this->groupInstance->createNewModel("group", $data);
    }
  }
}
