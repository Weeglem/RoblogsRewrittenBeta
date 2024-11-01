<?php
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Model_Data();

$ID = $_GET["id"];

try{
    $Item = new Model_Data($ID);
}catch(Exception $e){
    exit(json_encode(array("Error" => $e->getMessage())));
}

$Data = file_get_contents($Item->Download_Link());

if(!$Data) exit("Failed to load");
header('Content-type: application/xml');
echo gzdecode($Data);
exit();
?>