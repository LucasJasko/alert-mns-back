<?php

// TODO faire une méthode d'affichage des var dump dans la console du navigateur via la génération d'un console.log 

namespace Core\Utils;

class Dump
{
  public static function log($value)
  {
    if (!is_array($value)) {
      echo ' <script> console.log("' . $value . '"); </script>';
    } else {
      echo ' <script> console.log(';
      for ($i = 0; $i < count($value); $i++) {
        echo $value[$i];
      }
      echo '); </script>';
    }
  }
}