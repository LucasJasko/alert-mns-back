<?php

namespace Src\Api;

class Image
{

  public function dispatch($table, $folderName, $subfolder, $fileName, $isApi)
  {
    if ($isApi) {

      if (\Src\Api\Auth::protect()) {

        $path = ROOT . "/upload/" . $table . "/" . $folderName . "/" . $subfolder . "/" . $fileName;
        if (file_exists($path)) {
          $imageData = base64_encode(file_get_contents($path));
          echo json_encode($imageData);
        } else {

          http_response_code(404);
          echo json_encode(['error' => 'Image not found']);

        }

        return;

      }
    }
  }

}
