<?php

namespace Src\Controller;

use Core\Model\Database;
use Src\Entity\Profile as ProfileModel;

class Profile
{
  private $dashboard;
  private $dashboardInfos;
  private $form;
  private $formInfos;
  private $db;

  private array $fieldsToNotRender = ["profile_password", "language_id", "theme_id", "status_id", "profile_picture"];

  private $profileInstance;

  public function __construct()
  {
    $this->db = new Database();

    $this->formInfos = ProfileModel::MODEL_INFOS["form_infos"];
    $this->dashboardInfos = ProfileModel::MODEL_INFOS["dashboard_infos"];
    $this->formInfos = ProfileModel::MODEL_INFOS["form_infos"];
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
    require_once str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/profile.php";
  }

  public function getEmptyForm()
  {
    $this->form = new \core\model\Form("profile", "profile", $this->formInfos);
    $fieldsOfTable = $this->db->getFieldsOfTable("profile");
    return $this->form->getEmptyForm($fieldsOfTable);
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
    $this->profileInstance = new ProfileModel($data["profile_id"]);
    if (empty($data["profile_id"])) {
      $this->profileInstance->createNewModel("profile", $data);
    } else {
      //  ICI ===============
      $profileSituation = [$data["profile_id"], $data["post_id"], $data["department_id"]];

      var_dump($data);

      // $this->profileInstance->updateModel($data["profile_id"], $data);
    }
  }
}
