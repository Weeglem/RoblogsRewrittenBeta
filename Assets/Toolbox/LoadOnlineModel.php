<?php
session_start();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Model_Data();
$x->Decal_Data();

$Model = isset($_GET["id"]) ? $_GET["id"] : exit(json_encode(array("Error" => "Invalid id input")));
if(filter_var($Model,FILTER_VALIDATE_INT) == false) exit(json_encode(array("Error" => "Invalid id input")));

$Type = isset($_GET["type"]) ? $_GET["type"] : "Model";

//GET CLASS
switch($Type){
    case "Model": $z = "Model_Data"; break;
    case "Decal": $z = "Decal_Data"; break;   
    default: exit(json_encode(array("Error" => "Undefined or Invalid Asset Type"))); break;
}

try{
    if(!class_exists($z)) exit(json_encode(array("Error" => "Invalid Asset type")));
    $Model_Data = new $z($Model);}catch(Exception $e){
    exit(json_encode(array("Error" => $e->getMessage())));
}

//VALIDATE OWNER IF PRIVATE
$Download_Type = $Model_Data->Download_Type();
switch($Download_Type)
{
    case 0:
        $Owner = $Model_Data->Creator();
        if($Owner != Session::Get_ID()) exit(json_encode(array("Error" => "You dont own this Item")));
    break;
    default: break;
}

//OK FINISH
header('Content-type: application/xml');

if($Type == "Decal"){
    echo '<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd" version="4">
                <External>null</External>
                <External>nil</External>
                <Item class="Decal" referent="RBX0">
                    <Properties>
                        <token name="Face">5</token>
                        <string name="Name">Decal</string>
                        <float name="Shiny">20</float>
                        <float name="Specular">0</float>
                        <Content name="Texture"><url>'.$Model_Data->Asset_Link().'</url></Content>
                        <bool name="archivable">true</bool>
                    </Properties>
                </Item>
            </roblox>
        ';
        exit();
}

if($Type == "Model"){
    $Data = file_get_contents($Model_Data->Download_Link());
    if(!$Data) exit(json_encode(array("Error" => "Failed to Find Data")));
    exit(gzdecode($Data)); 
}

exit();


?>