<?php
function redirect($path)
{
    header("Location:" . $path);
    exit();
}

function writeLog($message)
{
    date_default_timezone_set("Europe/Paris");
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $pathfile   = "../logs/" . $date . "-logs.txt";
    $openedfile = fopen($pathfile, "a");

    $logmessage = "[ " . $date . " ] [ " . $time . " ] " . $message . "\n";
    fwrite($openedfile, $logmessage);

    fclose($openedfile);
}
