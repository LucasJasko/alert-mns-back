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
    "user_situation" => [
      "field_name" => "user_situation",
      "class_name" => "UserSituation",
      "field_desc" => "Situations des utilisateurs",
      "field_p" => "une situation",
    ],
    "situation_department" => [
      "field_name" => "situation_department",
      "field_desc" => "Départements de l'entreprise",
      "field_p" => "un département",
      "class_name" => "SituationDepartment"
    ],
    "user_theme" => [
      "field_name" => "user_theme",
      "class_name" => "UserTheme",
      "field_desc" => "Thèmes de l'application",
      "field_p" => "un thème",
    ],
    "user_status" => [
      "field_name" => "user_status",
      "class_name" => "UserStatus",
      "field_desc" => "Statuts d'activité des utilisateurs",
      "field_p" => "un statut",
    ],
    "user_role" => [
      "field_name" => "user_role",
      "class_name" => "UserRole",
      "field_desc" => "Rôles de l'application",
      "field_p" => "un role",
    ],
    "user_language" => [
      "field_name" => "user_language",
      "class_name" => "UserLanguage",
      "field_desc" => "Langues de l'application",
      "field_p" => "une langue",
    ],
  ];

  private $dashboard;

  public function __construct()
  {

    foreach ($this->ParamsConfig as $k => $v) {
      $this->ParamsConfig[$k]["instance"] = new \src\model\ModelManager($this->ParamsConfig[$k]["field_name"], $this->ParamsConfig[$k]["class_name"], $this->ParamsConfig[$k]["field_name"] . "_id");
      $this->ParamsConfig[$k]["infos"] = $this->ParamsConfig[$k]["instance"]->getModelInfos();
    }
  }

  public function getView()
  {
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/params.php";
  }
}
