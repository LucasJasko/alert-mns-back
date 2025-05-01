<?php

namespace src\controller;

use core\model\Database;
use src\model\Profile;

class ProfileController
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
    $this->formInfos = Profile::$modelInfos["form_infos"];
    $this->dashboardInfos = Profile::$modelInfos["dashboard_infos"];
  }

  public function getProfileDashboard()
  {
    $this->db = new Database();
    $recordset = $this->db->getField("profile", "profile_id");

    $models = [];
    for ($i = 0; $i < count($recordset); $i++) {
      $id = $recordset[$i]["profile_id"];
      $model = new Profile($id);
      $models[$i] = $model->all();
    }

    $this->dashboard = new \core\model\Dashboard("profile", $models, $this->dashboardInfos, $this->fieldsToNotRender);
    require_once str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/profile.php";
  }

  public function getEmptyForm()
  {
    $this->form = new \core\model\Form("profile", "profile", $this->profileInfos["form_infos"]);
    $fieldsOfTable = $this->profileManager->getFieldsOfTable();
    return $this->form->getEmptyForm($fieldsOfTable);
  }

  public function getForm(int $id)
  {
    $this->profileInstance = new Profile($id);

    $this->form = new \core\model\Form("profile", "Profile", $this->profileInfos["form_infos"]);
    return $this->form->getForm($this->profileInstance);
  }


  public function submitData(array $data)
  {
    if (!empty($data["profile_id"])) {
      $this->profileManager->updateModel($data["profile_id"], $data);
    } else {
      $this->profileManager->createNewModel($data);
    }
  }
}
