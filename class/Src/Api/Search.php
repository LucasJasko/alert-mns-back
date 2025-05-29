<?php

namespace Src\Api;

class Search
{

  public function dispatch($isApi)
  {
    if ($isApi) {

      if (\Src\Api\Auth::protect()) {

        echo json_encode($_COOKIE);
        return;

      }

      http_response_code(401);
    }

    http_response_code(404);
  }
}
