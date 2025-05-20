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

  public function dispatch($id = null, bool $isApi = false, $isDelete = false)
  {

    \Core\Controller\Auth::protect();

    if ($isApi) {
      echo json_encode($this->modelData($id, "profile"));
    } else {

      if ($_POST) {
        // TODO message d'erreur lors de l'ajout d'une situation de profile
        $this->submitData($_POST);
      }

      if (isset($id)) {

        if ($id != 0) {

          if ($isDelete) {

            $res = $this->delete("profile", "profile_id", $id);

            if ($res) {
              \Src\App::redirect("error");
            }
            \Src\App::redirect("profile");

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

  public function submitData(array $data)
  {
    if (empty($data["profile_id"])) {
      $availableId = $this->getAvailableId("profile", "profile_id");
      $data["profile_id"] = $availableId;

      $profileSituation = $this->isolateSituations($data);
      unset($data["situation_id"]);
      $this->profileInstance = new ProfileModel($data["profile_id"], $data);
      $this->profileInstance->createNewModel("profile", $data);

      $profileSituationInstance = new ProfileSituation($data["profile_id"]);
      $profileSituationInstance->updateSituations($profileSituation);
    } else {

      $profileSituation = $this->isolateSituations($data);
      unset($data["situation_id"]);
      $profileSituationInstance = new ProfileSituation($data["profile_id"]);
      $profileSituationInstance->updateSituations($profileSituation);

      $this->profileInstance = new ProfileModel($data["profile_id"]);
      $this->profileInstance->updateModel($data["profile_id"], $data);
    }
  }

  private function isolateSituations($data)
  {
    $profileSituation = $data["situation_id"];
    for ($i = 0; $i <= count($profileSituation); $i++) {
      if (empty($profileSituation[$i]["post_id"]) || empty($profileSituation[$i]["department_id"])) {
        unset($profileSituation[$i]);
      }
    }

    return array_unique($profileSituation, SORT_REGULAR);
  }
}
