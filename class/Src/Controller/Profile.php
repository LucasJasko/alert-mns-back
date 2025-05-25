<?php

namespace Src\Controller;

use Src\Entity\Profile as ProfileModel;
use Src\Relation\ProfileSituation;

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
    } else {

      \Src\Controller\Auth::protect();

      if (isset($id)) {

        if ($id != 0) {

          $profile = new ProfileModel($id);

          if ($_POST) {

            $profile->submitModel($_POST);

          } else {
            $this->getModelForm("profile", $id, $this->formInfos);
          }
        } else {
          $this->getEmptyModelForm("profile", $this->formInfos);
        }
      } else {
        $this->getProfileDashboard();
      }

    }
  }

  public function getProfileDashboard()
  {

    $recordset = $this->db->getField("profile", "profile_id");
    $clearedRecordset = $this->clearRecordset($recordset, "profile");
    $profiles = $this->getModelsFromRecordset($clearedRecordset, "Profile");

    $fields = $this->unsetFieldsToRender($this->dashboardInfos, $this->fieldsToNotRender);
    $data = $profiles;
    $tab = "profile";
    $page = "profile";

    require_once ROOT . "/pages/profile.php";
  }
}
