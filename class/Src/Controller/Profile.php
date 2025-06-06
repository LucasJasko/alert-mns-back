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

      if ($id == "0") {
        if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
          http_response_code(200);
          exit();
        }

        $res = \Src\App::clientData();

        if (isset($res)) {

          if (isset($res["secure"]) && $res["secure"] == "client-speak") {

            $pictureContent = $res["pictureContent"];
            unset($res["pictureContent"]);

            $userData = [
              "profile_name" => $res["name"],
              "profile_surname" => $res["surname"],
              "profile_mail" => $res["mail"],
              "profile_password" => $res["password"],
              "profile_picture" => $res["picture"],
              "language_id" => $res["language"],
              "theme_id" => $this->db->getFieldWhere("theme", "theme_id", "theme_name", $res["theme"])["theme_id"],
              "status_id" => $res["status"],
              "role_id" => $res["role"],
              "situation_id" => [["" => ""]]
            ];

            $profile = new ProfileModel("0");

            if ($profile->submitModel($userData, $isApi, $pictureContent)) {
              echo json_encode("Account created !");
              return http_response_code(201);
            }
          }
          return http_response_code(403);
        }
        return http_response_code(403);
      }

      \Src\Api\Auth::protect();

      $profile = new ProfileModel($id);
      $data = $profile->all();

      $res = [
        "picture" => $data["profile_picture"],
        "situations" => $data["situation_id"],
        "language" => $data["language_id"],
        "status" => $data["status_id"],
        "name" => $data["profile_name"],
        "surname" => $data["profile_surname"],
        "theme" => $data["theme_id"],
      ];

      echo json_encode($res);

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
        $data = $profile->all();
        $data["profile_password"] = "";
        return $form->getForm($data, "Modification du profile de " . $profile->name() . " " . $profile->surname(), "profile");
      }

      $form = new \Src\Model\Form("profile", "profile/0", $this->formInfos);

      $fieldsOfTable = $this->db->getFieldsOfTable("profile");
      $fieldsOfTable = array_fill_keys($fieldsOfTable, "");
      $fieldsOfTable["situation_id"] = [["" => ""]];

      return $form->getEmptyForm($fieldsOfTable, "Création d'un nouveau profile", "profile", ["profile_id", "profile_creation_time"]);
    }

    $this->getDashboard("profile", [], $this->dashboardInfos, $this->fieldsToNotRender);
  }
}
