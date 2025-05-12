<?php

namespace Src\Controller;

use Src\Entity\Profile as ProfileModel;
use Src\Relation\ProfileSituation;

class Profile extends \Src\Controller\Controller
{
  private $dashboard;
  private $dashboardInfos;
  private $form;
  private $formInfos;

  private array $fieldsToNotRender = ["profile_password", "language_id", "theme_id", "status_id", "profile_picture"];

  private $profileInstance;

  public function __construct()
  {
    parent::__construct();
    $this->formInfos = ProfileModel::formInfos();
    $this->dashboardInfos = ProfileModel::dashboardInfos();
  }

  public function getProfileDashboard()
  {
    $recordset = $this->db->getField("profile", "profile_id");

    $clearedRecordset = [];
    for ($i = 0; $i < count($recordset); $i++) {
      $clearedRecordset[$i] = $recordset[$i]["profile_id"];
    }

    $profiles = [];
    for ($i = 0; $i < count($clearedRecordset); $i++) {
      $id = $clearedRecordset[$i];
      $profile = new ProfileModel($id);
      $profiles[$i] = $profile->all();
    }

    $this->dashboard = new \core\model\Dashboard("profile", $profiles, $this->dashboardInfos, $this->fieldsToNotRender);
    require_once ROOT . "/pages/profile.php";
  }

  public function getEmptyForm()
  {
    $this->form = new \core\model\Form("profile", "profile", $this->formInfos);
    $fieldsOfTable = $this->db->getFieldsOfTable("profile");
    $fieldsOfTable[] = "situation_id";
    return $this->form->getEmptyForm($fieldsOfTable, ["profile_id"]);
  }

  public function getForm(int $id)
  {
    $this->profileInstance = new ProfileModel($id);
    $profileData = $this->profileInstance->all();

    $this->form = new \core\model\Form("profile", "profile", $this->formInfos);
    return $this->form->getForm($profileData);
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
