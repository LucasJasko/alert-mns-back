<?php

namespace Src\Controller;

class Params extends \Src\Controller\Controller
{

  private array $paramsConfig = [
    "post" => [
      "field_name" => "post",
      "class_name" => "Post",
      "field_desc" => "Postes des utilisateurs",
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

  private $paramInstance;

  public function __construct()
  {
    parent::__construct();
    foreach ($this->paramsConfig as $k => $v) {
      $model = "\Src\Entity\\" . ucfirst($k);
      $this->paramsConfig[$k]["form_infos"] = $model::formInfos();
      $this->paramsConfig[$k]["dashboard_infos"] = $model::dashboardInfos();
    }
  }

  public function getParamsDashboard()
  {
    foreach ($this->paramsConfig as $k => $v) {
      $this->paramsConfig[$k]["recordset"] = [];
      $model = "\Src\Entity\\" . ucfirst($k);
      $fielId = $k . "_id";

      $recordset = $this->db->getField($k, $fielId);

      $clearedRecordset = [];
      for ($i = 0; $i < count($recordset); $i++) {
        $clearedRecordset[$i] = $recordset[$i][$k . "_id"];
      }

      for ($i = 0; $i < count($clearedRecordset); $i++) {
        $id = $clearedRecordset[$i];
        $model = new $model($id);
        $this->paramsConfig[$k]["recordset"][] = $model->all();
        $this->paramsConfig[$k]["fields"][] = $this->db->getFieldsOfTable($k);
      }
    }

    $paramsConfig = $this->paramsConfig;
    require ROOT . "/pages/params.php";
  }

  public function getEmptyForm(string $tab)
  {
    $fieldName = $this->paramsConfig[$tab]["field_name"];
    $formInfos = $this->paramsConfig[$tab]["form_infos"];
    $this->form = new \core\model\Form($fieldName, "params", $formInfos);
    $fieldsOfTable = $this->db->getFieldsOfTable($tab);
    return $this->form->getEmptyForm($fieldsOfTable, [$fieldName . "_id"]);
  }

  public function getForm(string $tab, int $id)
  {
    $model = "\Src\Entity\\" . ucfirst($tab);
    $this->paramInstance = new $model($id);
    $profileData = $this->paramInstance->all();
    $formInfos = $this->paramInstance::formInfos();

    $this->form = new \core\model\Form($tab, "params", $formInfos);
    return $this->form->getForm($profileData);
  }


  public function submitData(array $data, string $tab)
  {
    $model = "\Src\Entity\\" . ucfirst($tab);
    unset($data["table_name"]);

    if (empty($data[$tab . "_id"])) {
      $availableId = $this->getAvailableId($tab, $tab . "_id");
      $data[$tab . "_id"] = $availableId;

      $this->paramInstance = new $model($data[$tab . "_id"], $data);
      $this->paramInstance->createNewModel($tab, $data);
    } else {
      $modelId = $data[$tab . "_id"];

      $this->paramInstance = new $model($modelId);
      $this->paramInstance->updateModel($modelId, $data);
    }
  }
}
