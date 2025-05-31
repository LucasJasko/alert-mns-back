<?php

namespace Src\Api;

class Search
{

  public function dispatch($subject, $isApi)
  {
    if ($isApi) {

      switch ($subject) {

        case "users":
          \Src\Api\Auth::protect();

          $req = \Src\App::clientData();
          $query = $req["query"];
          $res = \Src\App::db()->getResultsThatContain("profile", ["profile_name", "profile_id", "profile_surname", "profile_picture", "status_id"], "profile_name", "profile_surname", $query);
          echo json_encode($res);
          break;

        case "email":

          $req = \Src\App::clientData();
          $query = $req["query"];
          if ($res = \Src\App::db()->getFieldWhere("profile", "profile_mail", "profile_mail", $query)) {
            echo json_encode(true);
          } else {
            echo json_encode(false);
          }
          break;

      }
    }
  }
}
