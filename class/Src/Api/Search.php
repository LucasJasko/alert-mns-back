<?php

namespace Src\Api;

class Search
{

  public function dispatch($isApi)
  {
    if ($isApi) {

      \Src\Api\Auth::protect();

      $req = \Src\App::clientData();
      $query = $req["query"];
      $res = \Src\App::db()->getResultsThatContain("profile", "profile_name", "profile_surname", $query);
      echo json_encode($res);
      return;
    }
  }
}
