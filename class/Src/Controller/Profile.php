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

      if ($_POST) {
        $profile = new ProfileModel($id);
        $profile->submitModel($_POST);
      }

      if ($id != 0) {
        $this->getModelForm("profile", $id, $this->formInfos, "Modification du profile " . $id);
        return;
      }

      $this->getEmptyModelForm("profile", $this->formInfos, "Création d'un nouveau profile");
      return;
    }

    $this->getDashboard("profile", [], $this->dashboardInfos, $this->fieldsToNotRender);
  }
}
