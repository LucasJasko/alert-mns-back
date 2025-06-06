<?php

namespace Src\Api;

class Image
{

  public function dispatch($table, $folderName, $subfolder, $fileName, $isApi)
  {
    if ($isApi) {

      \Src\Api\Auth::protect();

      $path = ROOT . "/upload/" . $table . "/" . $folderName . "/" . $subfolder . "/" . $fileName;
      if (file_exists($path)) {
        $imageData = base64_encode(file_get_contents($path));
      } else {
        $path = ROOT . "/upload/default/default.webp";
        $imageData = base64_encode(file_get_contents($path));
      }
      echo json_encode($imageData);
      return;
    }
  }

}
