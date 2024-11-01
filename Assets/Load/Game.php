<?php
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Game_Data();

function isValidXml($content)
{
    $content = trim($content);
    if (empty($content)) {
        return false;
    }
    //html go to hell!
    if (stripos($content, '<!DOCTYPE html>') !== false) {
        return false;
    }

    libxml_use_internal_errors(true);
    simplexml_load_string($content);
    $errors = libxml_get_errors();          
    libxml_clear_errors();  

    return empty($errors);
}

$ID = $_GET["id"];

try{
    $Item = new Game_Data($ID);
}catch(Exception $e){
    exit(json_encode(array("Error" => $e->getMessage())));
}

$Data = file_get_contents($Item->Download_Link());
if(!$Data) exit("Failed to load");
header('Content-type: application/xml');

$Data = gzdecode($Data);
if(isValidXml($Data) == false) exit("Invalid XML format");
exit(strip_tags($Data));

?>