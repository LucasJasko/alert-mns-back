<?php

namespace Src\Model\Relation;

class ProfileSituation extends \Src\Model\Model
{

  private int $id;

  public function __construct(int $id)
  {
    $this->id = $id;
    $this->tableName = "profile__situation";
    $this->searchField = "profile_id";
    $this->initdb($this->tableName, $this->searchField);
  }

  public function updateSituations($data)
  {
    $this->db->deleteOne($this->tableName, $this->searchField, $this->id);

    foreach ($data as $index => $array) {
      $array["profile_id"] = $this->id;
      $this->db->createOne("profile__situation", $array, ["profile_id", "post_id", "department_id"]);
    }
  }

  public function situations()
  {
    return $this->db->getFieldsWhere("profile__situation", ["post_id", "department_id"], "profile_id", $this->id);
  }

  public function setSituations()
  {
    $situationList = [];
    $relation = $this->situations();
    for ($i = 0; $i < count($relation); $i++) {
      $post = new \Src\Model\Entity\Post($relation[$i]["post_id"]);
      $department = new \Src\Model\Entity\Department($relation[$i]["department_id"]);
      $situationList[] = [$post->name() => $department->name()];
    }
    return $situationList;
  }
}
