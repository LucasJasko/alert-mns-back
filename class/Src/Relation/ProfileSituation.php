<?php

namespace Src\Relation;

class ProfileSituation extends \Src\Model\Model
{

  public function __construct(int $id)
  {
    $this->id = $id;
    $this->tableName = "profile__situation";
    $this->searchField = "profile_id";
    $this->initdb($this->tableName, $this->searchField);
  }

  private function clearSituations()
  {
    $this->db->deleteOne($this->tableName, $this->searchField, $this->id);
  }

  public function updateSituations($data)
  {
    $this->clearSituations();
    for ($i = 0; $i < count($data); $i++) {
      $data[$i]["profile_id"] = $this->id;
      $this->db->createOne("profile__situation", $data[$i], ["profile_id", "post_id", "department_id"]);
    }
  }

  public function getSituations()
  {
    return  $this->db->getFieldsWhere("profile__situation", ["post_id", "department_id"], "profile_id", $this->id);
  }

  public function setSituations()
  {
    $situationList = [];
    $relation = $this->getSituations();
    for ($i = 0; $i < count($relation); $i++) {
      $post = new \Src\Entity\Post($relation[$i]["post_id"]);
      $department = new \Src\Entity\Department($relation[$i]["department_id"]);
      $situationList[] = [$post->name() => $department->name()];
    }
    return $situationList;
  }
}
