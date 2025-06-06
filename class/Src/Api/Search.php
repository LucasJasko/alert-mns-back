<?php

namespace Src\Api;

use \Src\App;

class Search
{

  public function dispatch($subject, $isApi)
  {
    if ($isApi) {

      switch ($subject) {

        case "profiles":
          \Src\Api\Auth::protect();

          $req = App::getApiData();
          $res = App::db()->getResultsThatContain("profile", ["profile_name", "profile_id", "profile_surname", "profile_picture", "status_id"], "profile_name", "profile_surname", $req["query"]);
          App::sendApiData($res);
          break;

        case "email":

          $req = App::getApiData();

          if ($res = App::db()->getFieldWhere("profile", "profile_mail", "profile_mail", $req["query"])) {
            App::sendApiData(true);
          } else {
            App::sendApiData(false);
          }
          break;

      }
    }
  }
}
