<?php

namespace Src\Controller;

use Src\Model\Entity\Profile as ProfileModel;

class Profile extends \Src\Controller\Controller
{
  private $profileInstance;
  private $dashboardInfos;
  private $form;
  public $formInfos;
  private array $fieldsToNotRender = ["profile_password", "language_id", "theme_id", "status_id", "profile_picture"];


  public function __construct()
  {
    parent::__construct();
    $this->formInfos = ProfileModel::formInfos();
    $this->dashboardInfos = ProfileModel::dashboardInfos();
  }

  public function dispatch($id = null, bool $isApi = false)
  {

    if ($isApi) {
      // echo json_encode($this->modelData($id, "profile"));
      return;
    }

    \Src\Auth\Auth::protect();

    if (isset($id)) {

      $profile = new ProfileModel($id);

      if ($_POST) {
        $profile->submitModel($_POST);
        \Src\App::redirect("profile");
      }

      if ($id != 0) {
        $form = new \Src\Model\Form("profile", "profile/$id", $this->formInfos);
        $form->getForm($profile->all(), "Modification du profile $id", "profile");
        return;
      }

      $form = new \Src\Model\Form("profile", "profile/0", $this->formInfos);

      $fieldsOfTable = $this->db->getFieldsOfTable("profile");
      $fieldsOfTable = array_fill_keys($fieldsOfTable, "");
      $fieldsOfTable["situation_id"] = [["" => ""]];

      $form->getEmptyForm($fieldsOfTable, "Création d'un nouveau profile", "profile", ["profile_id"]);
      return;
    }

    $this->getDashboard("profile", [], $this->dashboardInfos, $this->fieldsToNotRender);
  }
}
