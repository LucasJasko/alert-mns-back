<?php

namespace Src\Service;

class Image
{

  public function process()
  {
    if (isset($_FILES["product_image"])) {

      if ($_FILES["product_image"]["error"] == 0) {
        $extension = strtolower(pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION));
        $pathFile = $_SERVER["DOCUMENT_ROOT"] . "/upload/";

        if ($_FILES["product_image"]["type"] == "image/" . str_replace("jpg", "jpeg", $extension) && in_array($extension, ["jpg", "jpeg", "png", "gif", "webp"])) {

          if ($_POST["product_id"] > 0) {

            $stmt = $db->prepare("SELECT product_image FROM table_product WHERE product_id = :product_id AND product_image IS NOT NULL AND product_image <> ''");
            $stmt->bindValue(":product_id", $id);
            $stmt->execute();

            if ($row = $stmt->fetch()) {

              foreach (IMG_CONFIG as $prefix => $value) {

                if (file_exists($pathFile . $prefix . "_" . $row["product_image"])) {
                  unlink($pathFile . $prefix . "_" . $row["product_image"]);
                }
              }
            }
          }


          $filename = "bdshop-" . $_POST["product_serie"] . "-" . $_POST["product_name"];

          $this->createIMG($filename, ".webp");

        }

        if (file_exists($pathFile . $filename . "." . $extension)) {
          unlink($pathFile . $filename . "." . $extension);
        }



        // On effectue une requete pour le cas ou une image a été traité
        $stmt = $db->prepare("UPDATE table_product SET product_image = :product_image WHERE product_id = :product_id");
        // Il faut rajoute l'extension car elle n'existe pas dans le nom originel
        $stmt->bindValue(":product_image", $filename . ".webp");
        $stmt->bindValue(":product_id", $id);
        $stmt->execute();

      }
    }
  }

  public function createIMG($filename, $extension)
  {
    $filename = $this->cleanFilename($filename);
    $pathFile = $_SERVER["DOCUMENT_ROOT"] . "/upload/";

    $is_found = false;
    $count = 1;
    while ($is_found) {
      $is_found = false;
      foreach (IMG_CONFIG as $key => $value) {
        if (file_exists($pathFile . $key . "_" . $filename . ($count > 1 ? "(" . $count . ")" : "") . ".webp")) {
          $is_found = true;
          break;
        }
      }
      $is_found ? $count++ : "";
    }
    if ($count > 1) {
      $filename .= "(" . $count . ")";
    }

    move_uploaded_file($_FILES["product_image"]["tmp_name"], $pathFile . $filename . "." . $extension);

    $srcPrefix = "";
    $srcExtension = $extension;

    foreach (IMG_CONFIG as $prefix => $info) {

      $srcSize = getimagesize($pathFile . $srcPrefix . $filename . "." . $srcExtension);

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

      $src = ("imagecreatefrom" . str_replace("jpg", "jpeg", $srcExtension))($pathFile . $srcPrefix . $filename . "." . $srcExtension);

      // On effectue une copie de l'image uploadé
      imagecopyresampled($dest, $src, $destX, $destY, $srcX, $srcY, $destWidth, $destHeight, $srcWidth, $srcHeight);

      // Et on l'enregistre au format webp
      imagewebp($dest, $pathFile . $prefix . "_" . $filename . ".webp", 100);

      $srcExtension = "webp";

      // On ne change le préfix pour l'image suivante que si l'image qu'on vient de traiter n'est pas une image rogné.
      if (!$info["crop"]) {
        $srcPrefix = $prefix . "_";
      }

    }
  }

  public function cleanFilename($str)
  {
    $result = strtolower($str);
    $charKo = ["à", "â", "è", "é", "ê", "@", " ", "\\", ","];
    $charOk = ["a", "a", "e", "e", "e", "-", "-", "", ""];

    $result = str_replace($charKo, $charOk, $result);

    return trim($result, "-");
  }

}