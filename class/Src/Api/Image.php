<?php

namespace Src\Api;

class Image
{

  public function dispatch($table, $folderName, $subfolder, $fileName, $isApi)
  {
    if ($isApi) {

      if (!\Src\Api\Auth::protect()) {
        http_response_code(403);
        exit();
      }

      $path = ROOT . "/upload/" . $table . "/" . $folderName . "/" . $subfolder . "/" . $fileName;
      if (file_exists($path)) {
        $imageData = base64_encode(file_get_contents($path));
      } else {
        $path = ROOT . "/upload/default/default.webp";
        $imageData = base64_encode(file_get_contents($path));
      }
      \Src\App::sendApiData($imageData);
      return;
    } else {
      http_response_code(400);
    }
  }

}
