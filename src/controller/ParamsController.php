<?php

namespace src\controller;

use core\model\Database;

class ParamsController
{

  private string $userSituationInstance;
  private string $userSituationInfos;
  private string $userDepartmentInstance;
  private string $userDepartmentInfos;
  private string $userThemeInstance;
  private string $userThemeInfos;
  private string $userStatusInstance;
  private string $userStatusInfos;
  private string $userRoleInstance;
  private string $userRoleInfos;
  private string $userLanguageInstance;
  private string $userLanguageInfos;

  private array $ParamsConfig = [
    "post" => [
      "field_name" => "post",
      "class_name" => "Post",
      "field_desc" => "Posts des utilisateurs",
      "field_p" => "un post",
    ],
    "department" => [
      "field_name" => "department",
      "class_name" => "Department",
      "field_desc" => "Départements de l'entreprise",
      "field_p" => "un département",
    ],
    "theme" => [
      "field_name" => "theme",
      "class_name" => "Theme",
      "field_desc" => "Thèmes de l'application",
      "field_p" => "un thème",
    ],
    "status" => [
      "field_name" => "status",
      "class_name" => "Status",
      "field_desc" => "Statuts d'activité des utilisateurs",
      "field_p" => "un statut",
    ],
    "role" => [
      "field_name" => "role",
      "class_name" => "Role",
      "field_desc" => "Rôles de l'application",
      "field_p" => "un role",
    ],
    "language" => [
      "field_name" => "language",
      "class_name" => "Language",
      "field_desc" => "Langues de l'application",
      "field_p" => "une langue",
    ],
  ];

  private $dashboard;
  private $dashboardInfos;
  private $form;
  private $formInfos;
  private $db;
  private $paramInstance;

  public function __construct()
  {
    $this->db = new Database();

    foreach ($this->ParamsConfig as $k => $v) {
      $model = "\src\model\\" . ucfirst($k);
      $this->ParamsConfig[$k]["form_infos"] = $model::$modelInfos["form_infos"];
      $this->ParamsConfig[$k]["dashboard_infos"] = $model::$modelInfos["dashboard_infos"];
    }
  }

  public function getParamsDashboard()
  {
    foreach ($this->ParamsConfig as $k => $v) {
      $this->ParamsConfig[$k]["recordset"] = [];
      $model = "\src\model\\" . ucfirst($k);
      $fielId = $k . "_id";

      $recordset = $this->db->getField($k, $fielId);

      $clearedRecordset = [];
      for ($i = 0; $i < count($recordset); $i++) {
        $clearedRecordset[$i] = $recordset[$i][$k . "_id"];
      }
      // var_dump($clearedRecordset);

      for ($i = 0; $i < count($clearedRecordset); $i++) {
        $id = $clearedRecordset[$i];
        $model = new $model($id);
        $this->ParamsConfig[$k]["recordset"][] = $model->all();
        $this->ParamsConfig[$k]["fields"][] =  $this->db->getFieldsOfTable($k);
      }
    }

    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/params.php";
  }

  public function getEmptyForm(string $tab)
  {
    $this->form = new \core\model\Form($this->ParamsConfig[$tab]["field_name"], "params", $this->ParamsConfig[$tab]["form_infos"]);
    $fieldsOfTable = $this->db->getFieldsOfTable($tab);
    return $this->form->getEmptyForm($fieldsOfTable);
  }

  public function getForm(string $tab, int $id)
  {
    $model = "\src\model\\" . ucfirst($tab);
    $this->paramInstance = new $model($id);
    $profileData = $this->paramInstance->all();

    $this->form = new \core\model\Form($tab, $tab, $this->paramInstance::$modelInfos["form_infos"]);
    return $this->form->getForm($profileData);
  }


  public function submitData(array $data, string $tab)
  {
    unset($data["table_name"]);
    if (!empty($data[$tab . "_id"])) {
      $this->ParamsConfig[$tab]["instance"]->updateModel($data[$tab . "_id"], $data);
    } else {
      $this->ParamsConfig[$tab]["instance"]->createNewModel($data);
    }
  }
}
