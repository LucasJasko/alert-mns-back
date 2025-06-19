<?php

namespace Src\Api;

class PublicKey
{

  public function dispatch($isApi)
  {

    if ($isApi) {

      if (!\Src\Api\Auth::protect()) {
        http_response_code(403);
        exit();
      }

      $req = \Src\App::getApiData();

      \Src\App::sendApiData($req);

    } else {
      http_response_code(400);
    }

  }

}