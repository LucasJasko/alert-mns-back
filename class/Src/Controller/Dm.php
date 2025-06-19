<?php

namespace Src\Controller;

use \Src\App;

class Dm extends \Src\Controller\Controller
{

  public function dispatch($id, bool $isApi = false)
  {

    if ($isApi) {

      if (!\Src\Api\Auth::protect()) {
        http_response_code(403);
        exit();
      }

      if ($res = App::db()->getDmOfProfile("dm", "profile_id_A", "profile_id_B", $id)) {

        for ($i = 0; $i < count($res); $i++) {
          $query[] = $res[$i]["profile_id_A"];
        }
        $res = App::db()->getAllWhereOr("profile", "profile_id", $query);

        for ($i = 0; $i < count($res); $i++) {

          unset($res[$i]["profile_password"]);
          unset($res[$i]["profile_mail"]);
          unset($res[$i]["theme_id"]);
          unset($res[$i]["language_id"]);

          $res[$i]["creation"] = $res[$i]["profile_creation_time"];
          unset($res[$i]["profile_creation_time"]);

          $res[$i]["id"] = $res[$i]["profile_id"];
          unset($res[$i]["profile_id"]);

          $res[$i]["name"] = $res[$i]["profile_name"];
          unset($res[$i]["profile_name"]);

          $res[$i]["picture"] = $res[$i]["profile_picture"];
          unset($res[$i]["profile_picture"]);

          $res[$i]["surname"] = $res[$i]["profile_surname"];
          unset($res[$i]["profile_surname"]);

          $res[$i]["role"] = $res[$i]["role_id"];
          unset($res[$i]["role_id"]);

          $res[$i]["status"] = $res[$i]["status_id"];
          unset($res[$i]["status_id"]);

        }
      } else {
        $res = "";
      }
      return App::sendApiData($res);

    } else {
      http_response_code(400);
    }

  }
}