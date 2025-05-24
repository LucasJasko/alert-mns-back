<?php

namespace Src\Controller;

class Params extends \Src\Controller\Controller
{

  public array $paramsConfig = [
    "post" => [
      "field_name" => "post",
      "class_name" => "Post",
      "field_desc" => "Postes des utilisateurs",
      "field_p" => "un poste",
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

  private $dashboardsInfos;
  private $dashboard;
  private $form;
  public $formsInfos;

  private $paramInstance;

  public function __construct()
  {
    parent::__construct();
    foreach ($this->paramsConfig as $table => $v) {
      $model = "\Src\Entity\\" . ucfirst($table);
      $this->formsInfos[$table] = $model::formInfos();
      $this->dashboardsInfos[$table] = $model::dashboardInfos();
    }
  }

  public function dispatch($tab = null, $id = null, $del = null, $isApi = false)
  {

    if ($isApi) {
      // Process API
    } else {

      \Src\Controller\Auth::protect();

      if ($_POST) {
        $this->submitData($_POST, $_POST["table_name"]);
      }

      if (isset($id) && isset($tab)) {

        $modelName = "\Src\Entity\\" . ucfirst($tab);
        $model = new $modelName($id);

        if ($id != 0) {

          if ($del == $_SESSION["delete_key"]) {

            $res = $model->deleteModel();

            if ($res) {
              \Src\App::redirect("error");
            }
            \Src\App::redirect("params");

          } else {
            $this->getModelForm($tab, $id, $this->formsInfos[$tab], "params");
          }
        } else {
          $this->getEmptyModelForm($tab, $this->formsInfos[$tab], "params");
        }
      } else {
        $this->getParamsDashboard();
      }
    }
  }

  public function getParamsDashboard()
  {
    foreach ($this->paramsConfig as $table => $v) {
      $recordset = $this->db->getField($table, $table . "_id");
      $clearedRecordset = $this->clearRecordset($recordset, $table);

      for ($i = 0; $i < count($clearedRecordset); $i++) {
        $recordsets[$table] = $this->getModelsFromRecordset($clearedRecordset, $table);
        $ParamsFields[$table][] = $this->db->getFieldsOfTable($table);
      }
    }

    $dashboardsInfos = $this->dashboardsInfos;
    $paramsConfig = $this->paramsConfig;

    require_once ROOT . "/pages/params.php";
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
