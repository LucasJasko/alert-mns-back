<?php

namespace Src\Controller;

use Src\Entity\Group as GroupModel;

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
    } else {

      \Src\Controller\Auth::protect();

      if (isset($id)) {

        if ($id != 0) {

          $group = new GroupModel($id);

          if ($_POST) {

            if (isset($_POST["delete_key"]) && $_POST["delete_key"] == $_SESSION["delete_key"]) {

              $res = $group->deleteModel();

              if ($res) {
                \Src\App::redirect("error");
              }
              \Src\App::redirect("group");

            }

            $group->submitModel($_POST);

          } else {
            $this->getModelForm("group", $id, $this->formInfos);
          }

        } else {
          $this->getEmptyModelForm("group", $this->formInfos);
        }

      } else {
        $this->getGroupDashboard();
      }

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
