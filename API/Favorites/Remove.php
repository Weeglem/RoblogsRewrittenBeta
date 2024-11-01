<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Game_Data();
$x->Model_Data();
$x->Decal_Data();

include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Classes/User/Favorites.php");
$Post_ItemID = isset($_POST["id"]) ? $_POST["id"] : null;
$Post_AssetType =  isset($_POST["Type"]) ? $_POST["Type"] : null;
$Array = array("success" => false,"message" => "");

try{
    Favorites_Controller::Remove($Post_ItemID,$Post_AssetType);
    $x = $Post_AssetType."_data";

    $Item = new $x($Post_ItemID);
    $Item->UpdateFavorites();
    
    $Array["success"] = true;
}catch(Exception $err)
{
    $Array["message"] = $err->getMessage();
}

exit(json_encode($Array));
?>