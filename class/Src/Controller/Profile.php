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

      \Src\Api\Auth::protect();

      $profile = new ProfileModel($id);
      $data = $profile->all();
      unset($data["profile_password"]);

      echo json_encode($data);

      return;
    }

    \Src\Auth\Auth::protect();



    if (isset($id)) {


      $profile = new ProfileModel($id);

      if ($_POST) {
        $profile->submitModel($_POST);
        var_dump($_FILES);
        // \Src\App::redirect("profile");
      }

      if ($id != 0) {
        $form = new \Src\Model\Form("profile", "profile/$id", $this->formInfos);
        $data = $profile->all();
        $data["profile_password"] = "";
        return $form->getForm($data, "Modification du profile $id", "profile");
      }

      $form = new \Src\Model\Form("profile", "profile/0", $this->formInfos);

      $fieldsOfTable = $this->db->getFieldsOfTable("profile");
      $fieldsOfTable = array_fill_keys($fieldsOfTable, "");
      $fieldsOfTable["situation_id"] = [["" => ""]];

      return $form->getEmptyForm($fieldsOfTable, "Création d'un nouveau profile", "profile", ["profile_id"]);
    }

    $this->getDashboard("profile", [], $this->dashboardInfos, $this->fieldsToNotRender);
  }
}
