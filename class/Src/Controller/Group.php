<?php

namespace Src\Controller;

use Src\Entity\Group as GroupModel;

class Group extends \Src\Controller\Controller
{
  private $groupInstance;
  private $dashboardInfos;
  private $form;
  public $formInfos;
  private array $fieldsToNotRender = [];

  public function __construct()
  {
    parent::__construct();
    $this->formInfos = GroupModel::formInfos();
    $this->dashboardInfos = GroupModel::dashboardInfos();
  }

  public function getGroupDashboard()
  {
    $recordset = $this->db->getField("group", "group_id");
    $clearedRecordset = $this->clearRecordset($recordset, "group");
    $groups = $this->getModelsFromRecordset($clearedRecordset, "Group");
    $fields = $this->unsetFieldsToRender($this->dashboardInfos, $this->fieldsToNotRender);

    $data = $groups;
    $tab = "group";
    $page = isset($_GET["page"]) ? $_GET["page"] : "";

    require_once ROOT . "/pages/group.php";
  }

  public function getEmptyForm()
  {
    $this->form = new \Src\Model\Form("group", "group", $this->formInfos);
    $fieldsOfTable = $this->db->getFieldsOfTable("group");

    return $this->form->getEmptyForm($fieldsOfTable, ["group_id"]);
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
