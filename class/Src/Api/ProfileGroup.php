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
        $res[] = $db->getMultipleWhere("group", ["group_id", "group_name", "group_picture"], "group_id", $relations[$i]["group_id"]);
      }

      echo json_encode($res);

      return;
    }
  }
}