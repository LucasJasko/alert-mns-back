<?php

namespace Src\Api;

use \Src\App;

class ProfileGroup
{
  public function dispatch($id, $isAPi = false)
  {

    if ($isAPi) {

      \Src\Api\Auth::protect();

      $db = App::db();
      $relations = $db->getFieldsWhere("profile__group", ["group_id"], "profile_id", $id);

      $res = [];
      for ($i = 0; $i < count($relations); $i++) {
        $res[] = $db->getMultipleWhere("group", ["group_id", "group_name", "group_picture"], "group_id", $relations[$i]["group_id"]);
      }

      for ($i = 0; $i < count($res); $i++) {
        $res[$i]["id"] = $res[$i]["group_id"];
        $res[$i]["name"] = $res[$i]["group_name"];
        $res[$i]["picture"] = $res[$i]["group_picture"];
        unset($res[$i]["group_id"]);
        unset($res[$i]["group_name"]);
        unset($res[$i]["group_picture"]);
      }

      App::sendApiData($res);
      return;
    }
  }
}