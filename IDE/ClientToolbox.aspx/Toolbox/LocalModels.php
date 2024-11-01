<?php
header("Content-Type: application/json");

$Page = isset($_GET["type"]) ? $_GET["type"] : exit(json_encode(array("Error" => "Invalid Toolbox <type>")));

$Final = array(
    "Next" => false,
    "Back" => false,
    "Items" => "",
    "Page" => 1
    );

$Items = array();
$File = $_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/XML/Toolbox/".basename($Page).".xml";

if(file_exists($File) == false) exit(json_encode(array("Error" => "Invalid Toolbox Class Requested")));

$XML = simplexml_load_file($File);
if(!$XML) exit(json_encode(array("Error" => "Failed to create Toolbox from XML")));

foreach($XML->children() as $Model)
{
    $Items[] = array(
        "Name" => $Model->displayname->__toString(),
        "ID" => $Model->modelname->__toString(),
        "Thumbnail" => "./Toolbox/Thumbnail/".$Model->modelname->__toString().".png",
        "Link" => "http://$_SERVER[SERVER_NAME]/Assets/Toolbox/LoadModel.php?id=".$Model->modelname->__toString(),
    );
    $Final["Items"] = $Items;
}

exit(json_encode($Final));
?>