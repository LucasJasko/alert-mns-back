<?php

namespace Src\Service;

class Image
{

  private $pathFile = ROOT . "/upload/";
  private $imageType;

  public function __construct($type)
  {
    $this->imageType = $type;
    $this->pathFile = str_replace("\\", "/", $this->pathFile);
  }

  public function createProfilePicture()
  {

    if (isset($_FILES["profile_picture"])) {

      if ($_FILES["profile_picture"]["error"] == 0) {

        $extension = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));

        if ($_FILES["profile_picture"]["type"] == "image/" . str_replace("jpg", "jpeg", $extension) && in_array($extension, ["jpg", "jpeg", "png", "gif", "webp"])) {

          $this->deleteExistingImages();

          $filename = "speak-profile-" . strtolower($_POST["profile_surname"]) . "-" . strtolower($_POST["profile_name"]);

          $this->pathFile .= $_POST["profile_id"] . "-" . $filename . "/";

          if (!is_dir($this->pathFile)) {
            mkdir($this->pathFile);
          }
          if (is_dir($this->pathFile) && !is_dir($this->pathFile . "/" . $this->imageType)) {
            mkdir($this->pathFile . "/" . $this->imageType);
          }

          $this->pathFile .= $this->imageType . "/";

          $_POST["profile_picture"] = $filename;

          $this->createIMG($filename, $extension);

        }

        if (file_exists($this->pathFile . $filename . "." . $extension)) {
          unlink($this->pathFile . $filename . "." . $extension);
        }

        \Src\App::db()->setProfilePicture("profile", "profile_picture", "profile_id", "$filename.webp", $_POST["profile_id"]);
      }
    } else {

      $_POST["profile_picture"] = "default";

    }

  }

  private function createIMG($filename, $extension)
  {
    $filename = $this->cleanFileName($filename);
    $filename = $this->incrementFileName($filename);

    move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $this->pathFile . $filename . "." . $extension);

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
      imagewebp($dest, $this->pathFile . $prefix . ($this->pathFile == "profile_picture" ? "_" : "") . $filename . ".webp", 100);

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

  private function deleteExistingImages()
  {
    if ($_POST["profile_id"] > 0) {

      if ($row = \Src\App::db()->getProfilePicture("profile", "profile_picture", "profile_id", $_POST['profile_id'])) {

        foreach (IMG_CONFIG as $prefix => $value) {
          if (file_exists($this->pathFile . $prefix . "_" . $row["profile_picture"])) {
            unlink($this->pathFile . $prefix . "_" . $row["profile_picture"]);
          }
        }

      }
    }
  }

}