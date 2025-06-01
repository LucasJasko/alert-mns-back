<?php

namespace Src\Service;

class Image
{

  private $pathFile = ROOT . "/upload/";
  private $pictureContent;
  private $imageType;
  private $id;

  public function __construct($type)
  {
    $this->imageType = $type;
    $this->pathFile = str_replace("\\", "/", $this->pathFile);
  }

  public function createPicture($table, $id = "", bool $isApi = false, array $pictureContent = "")
  {
    $this->id = $id != "" ? $id : $_POST[$table . "_id"];
    $this->pictureContent = $isApi ? $pictureContent : $_FILES[$table . "_picture"];

    if (isset($this->pictureContent)) {

      if ($this->pictureContent["error"] == 0) {

        $extension = strtolower(pathinfo($this->pictureContent["name"], PATHINFO_EXTENSION));

        if ($this->pictureContent["type"] == "image/" . str_replace("jpg", "jpeg", $extension) && in_array($extension, ["jpg", "jpeg", "png", "gif", "webp"])) {

          $this->deleteExistingImages($table);

          $firstPart = $table == "profile" ? "-" . strtolower($_POST[$table . "_surname"]) : "";
          $secondPart = $this->cleanFileName(strtolower($_POST[$table . "_name"]));
          $filename = "speak-" . $table . $firstPart . "-" . $secondPart;

          $this->pathFile .= $table . "/" . $this->id . "-" . $filename . "/";

          if (!is_dir($this->pathFile)) {
            mkdir($this->pathFile);
          }
          if (is_dir($this->pathFile) && !is_dir($this->pathFile . "/" . $this->imageType)) {
            mkdir($this->pathFile . "/" . $this->imageType);
          }

          $this->pathFile .= $this->imageType . "/";

          $_POST[$table . "_picture"] = $filename;

          $this->createIMG($table, $filename, $extension);

        }

        if (file_exists($this->pathFile . $filename . "." . $extension)) {
          unlink($this->pathFile . $filename . "." . $extension);
        }

        \Src\App::db()->setPicture($table, $table . "_picture", $table . "_id", "$filename.webp", $this->id);
      }
    } else {

      $_POST[$table . "_picture"] = "default";

    }

  }

  private function createIMG($table, $filename, $extension)
  {
    $filename = $this->cleanFileName($filename);
    $filename = $this->incrementFileName($filename);

    move_uploaded_file($this->pictureContent["tmp_name"], $this->pathFile . $filename . "." . $extension);

    $srcPrefix = "";
    $srcExtension = $extension;

    foreach (IMG_CONFIG[$this->imageType] as $prefix => $info) {

      $srcSize = getimagesize($this->pathFile . $srcPrefix . $filename . "." . $srcExtension);

      $srcWidth = $srcSize[0];
      $srcHeight = $srcSize[1];

      $srcX = 0;
      $srcY = 0;

      $destX = 0;
      $destY = 0;

      $destWidth = $info["width"];
      $destHeight = $info["height"];

      if (!$info["crop"]) {

        if ($srcWidth > $srcHeight) {
          $destHeight = round(($srcHeight * $destWidth) / $srcWidth);

          if ($srcWidth <= $destWidth) {
            $destWidth = $srcWidth;
            $destHeight = $srcHeight;
          }

        } else {
          $destWidth = round(($srcWidth * $destHeight) / $srcHeight);

          if ($srcWidth <= $destWidth) {
            $destWidth = $srcWidth;
            $destHeight = $srcHeight;
          }
        }

      } else {

        // On vérifie que l'image est au format paysage
        if ($srcWidth > $srcHeight) {
          $srcX = round(($srcWidth - $srcHeight) / 2);
          $srcWidth = $srcHeight;

          // Sinon elle est au format portrait
        } else {
          $srcY = round(($srcHeight - $srcWidth) / 2);
          $srcHeight = $srcWidth;
        }

      }

      $dest = imagecreatetruecolor($destWidth, $destHeight);

      $src = ("imagecreatefrom" . str_replace("jpg", "jpeg", $srcExtension))($this->pathFile . $srcPrefix . $filename . "." . $srcExtension);
      // On effectue une copie de l'image uploadé
      imagecopyresampled($dest, $src, $destX, $destY, $srcX, $srcY, $destWidth, $destHeight, $srcWidth, $srcHeight);

      // Et on l'enregistre au format webp
      imagewebp($dest, $this->pathFile . $prefix . ($this->pathFile == $table . "_picture" ? "_" : "") . $filename . ".webp", 100);

      $srcExtension = "webp";

      // On ne change le préfix pour l'image suivante que si l'image qu'on vient de traiter n'est pas une image rogné.
      if (!$info["crop"]) {
        $srcPrefix = $prefix . "_";
      }

    }
  }

  private function cleanFileName($str)
  {
    $result = strtolower($str);
    $charKo = ["à", "â", "è", "é", "ê", "@", " ", "\\", ","];
    $charOk = ["a", "a", "e", "e", "e", "-", "-", "", ""];

    $result = str_replace($charKo, $charOk, $result);

    return trim($result, "-");
  }

  private function incrementFileName($filename)
  {
    $is_found = false;
    $count = 1;
    while ($is_found) {
      $is_found = false;
      foreach (IMG_CONFIG[$this->imageType] as $key => $value) {
        if (file_exists($this->pathFile . $key . "_" . $filename . ($count > 1 ? "(" . $count . ")" : "") . ".webp")) {
          $is_found = true;
          break;
        }
      }
      $is_found ? $count++ : "";
    }
    if ($count > 1) {
      $filename .= "(" . $count . ")";
    }
    return $filename;
  }

  private function deleteExistingImages($table)
  {

    if ($row = \Src\App::db()->getPicture($table, $table . "_picture", $table . "_id", $this->id)) {

      foreach (IMG_CONFIG as $prefix => $value) {
        if (file_exists($this->pathFile . $prefix . "_" . $row[$table . "_picture"])) {
          unlink($this->pathFile . $prefix . "_" . $row[$table . "_picture"]);
        }
      }
    }
  }

}