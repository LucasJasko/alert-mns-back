<?php

namespace src\controller;

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
    "situation" => [
      "field_name" => "situation",
      "class_name" => "Situation",
      "field_desc" => "Situations des utilisateurs",
      "field_p" => "une situation",
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
  private $form;

  public function __construct()
  {

    foreach ($this->ParamsConfig as $k => $v) {
      $this->ParamsConfig[$k]["instance"] = new \core\model\ModelManager($this->ParamsConfig[$k]["field_name"], $this->ParamsConfig[$k]["class_name"], $this->ParamsConfig[$k]["field_name"] . "_id");
      $this->ParamsConfig[$k]["infos"] = $this->ParamsConfig[$k]["instance"]->getModelInfos();
    }
  }

  public function getView()
  {
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/params.php";
  }

  public function getEmptyForm(string $tab)
  {
    $this->form = new \core\model\Form($this->ParamsConfig[$tab]["field_name"], "params", $this->ParamsConfig[$tab]["infos"]["form_infos"]);
    $fieldsOfTable = $this->ParamsConfig[$tab]["instance"]->getFIeldsOfTable();
    return $this->form->getEmptyForm($fieldsOfTable);
  }

  public function getForm(string $tab, int $id)
  {
    $this->ParamsConfig[$tab]["instance"]->getModelData($id);

    $this->form = new \core\model\Form($this->ParamsConfig[$tab]["field_name"], "params", $this->ParamsConfig[$tab]["infos"]["form_infos"]);

    return $this->form->getForm($this->ParamsConfig[$tab]["instance"]->getModelData($id));
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
