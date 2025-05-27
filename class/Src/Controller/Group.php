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

    var_dump($this->db->lastInsertId());

    if (isset($id)) {

      $group = new GroupModel($id);

      if ($_POST) {
        $group->submitModel($_POST);
        \Src\App::redirect("group");
      }

      if ($id != 0) {
        $form = new \Src\Model\Form("group", "group/$id", $this->formInfos);
        $form->getForm($group->all(), "Modification du groupe $id", "group");
        return;
      }

      $form = new \Src\Model\Form("group", "group/0", $this->formInfos);

      $fieldsOfTable = $this->db->getFieldsOfTable("group");
      $fieldsOfTable = array_fill_keys($fieldsOfTable, "");

      $form->getEmptyForm($fieldsOfTable, "Création d'un nouveau groupe", "group", ["group_id"]);
      return;
    }

    $this->getDashboard("group", [], $this->dashboardInfos, $this->fieldsToNotRender);
  }
}
