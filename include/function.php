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

spl_autoload_register("loadClass");

function loadClass($class)
{
    $file = $class . ".php";
    $folders = ["controllers", "core", "models"];
    foreach ($folders as $folderName) {
        $path = $_SERVER["DOCUMENT_ROOT"] . "/class/" . $folderName . "/" . $file;
        if (file_exists($path)) require_once $path;
    }
}
