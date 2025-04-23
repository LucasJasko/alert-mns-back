<?php

namespace core;

class Log
{

  public static function writeLog($message)
  {
    date_default_timezone_set("Europe/Paris");
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $pathfile   = $_SERVER["DOCUMENT_ROOT"] . "/logs/" . $date . "-logs.txt";
    $openedfile = fopen($pathfile, "a");

    $logmessage = "[ " . $date . " ] [ " . $time . " ] " . $message . "\n";
    fwrite($openedfile, $logmessage);

    fclose($openedfile);
  }
}
