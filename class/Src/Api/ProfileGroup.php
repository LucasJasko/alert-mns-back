<?php

namespace Src\Api;

class ProfileGroup
{
  public function dispatch($id, $isAPi = false)
  {

    if ($isAPi) {
      $db = \Src\App::db();
      $relations = $db->getFieldsWhere("profile__group", ["group_id"], "profile_id", $id);

      $res = [];
      for ($i = 0; $i < count($relations); $i++) {
        $res[] = $db->getFieldsWhere("group", ["group_name"], "group_id", $relations[$i]["group_id"]);
      }

      echo json_encode($res);

      return;
    }
  }
}