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


      // TODO voir comment passer par le modèle pour soumettre les données car plus d'id pour initialiser l'objet, éventuellement récupérer l'id avec les données adjacentes

      if ($_POST) {

        var_dump($_POST);

        $group = new GroupModel($_POST["group_id"]);
        $group->submitModel($_POST);

      }

      if (isset($id)) {

        if ($id != 0) {

          $this->getModelForm("group", $id, $this->formInfos);

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
