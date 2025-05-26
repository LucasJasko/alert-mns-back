<?php

namespace Src\Controller;

use Src\Model\Entity\Group as GroupModel;

class Group extends \Src\Controller\Controller
{
  private $group;
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

  public function dispatch($id = null, bool $isApi = false)
  {

    if ($isApi) {
      //  Process API
      return;
    }

    \Src\Auth\Auth::protect();

    if (isset($id)) {

      if ($_POST) {

        $group = new GroupModel($id);
        $group->submitModel($_POST);

      }

      if ($id != 0) {

        $this->getModelForm("group", $id, $this->formInfos);

      } else {
        $this->getEmptyModelForm("group", $this->formInfos);
      }

    } else {
      $this->getGroupDashboard();
    }

  }

  public function getGroupDashboard()
  {
    $recordset = $this->db->getField("group", "group_id");
    $clearedRecordset = $this->clearRecordset($recordset, "group");
    $groups = $this->getModelsFromRecordset($clearedRecordset, "Group");
    $fields = $this->unsetFieldsToRender($this->dashboardInfos, $this->fieldsToNotRender);

    $data = $groups;
    $tab = "group";
    $page = "group";

    require_once ROOT . "/pages/group.php";
  }
}
