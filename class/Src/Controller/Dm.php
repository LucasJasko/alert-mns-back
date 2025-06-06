<?php

namespace Src\Controller;

class Dm extends \Src\Controller\Controller
{

  public function dispatch($id, bool $isApi = false)
  {

    if ($isApi) {
      \Src\Api\Auth::protect();

      if ($res = \Src\App::db()->getDmOfProfile("dm", "profile_id_A", "profile_id_B", $id)) {

        for ($i = 0; $i < count($res); $i++) {
          $res[$i]["target"] = $res[$i]["profile_id_A"];
          $res[$i]["origin"] = $res[$i]["profile_id_B"];
          $res[$i]["state"] = $res[$i]["state_id"];
          $res[$i]["creation"] = $res[$i]["dm_creation_time"];
          unset($res[$i]["profile_id_A"]);
          unset($res[$i]["profile_id_B"]);
          unset($res[$i]["dm_id"]);
          unset($res[$i]["dm_creation_time"]);
          unset($res[$i]["state_id"]);
        }

      } else {
        $res = "";
      }
      return \Src\App::sendApiData($res);
    }

    http_response_code(404);
  }
}