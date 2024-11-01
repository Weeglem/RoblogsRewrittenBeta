<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();

if(Session::Validate_Session() == false){exit("Missing Session");}


//OPTIMIZE ANTI INJECTION
$JSONArray = array(
    "success" => false, 
    "Name" => "",
    "Desc" => "",
);

$ValidItems = array("game","model","decal");

$ItemType = $_GET["type"];
$ItemID = $_GET["id"];

if(!in_array(strtolower($ItemType),$ValidItems)){exit("Invalid Type");}

$FinalDB = "";

//FUCK
switch($ItemType){
    case "Game":
        $FinalDB = "games_data";
    break;
    case "Model":
        $FinalDB = "models_data";
    break;
    case "Decal":
        $FinalDB = "decals_data";
    break;
}

$Name = $_POST["Name"];
$Description = $_POST["About"];
$Public = isset($_POST["PrivateAsset"]) ? 0 : 1;
$AllowComments = isset($_POST["AllowComments"]) ? 1: 0;
$ItemID = $_POST["ItemID"];
$MyID = Session::Get_ID();

$Database = new Database();
$Valid = $Database->FetchColumn("
SELECT 1 
FROM ".$FinalDB."
WHERE `ID` = ?
AND `Creator` = ?",
array($ItemID,$MyID));

if($Valid == false)
{
    $JSONArray["Name"] = "Invalid Request for Asset.";
    exit(json_encode($JSONArray));
}

if(empty($Name)){
    $JSONArray["Name"] = "Asset name cannot be empty";
    $NameError = true;
}
if(isset($NameError)){exit(json_encode($JSONArray));}

try{
    
    $Execute = $Database->Execute("
    UPDATE ".$FinalDB."
    SET `Name` = :NameItem,
    `Description` = :DescItem,
    `Public` = :PublicItem
    WHERE `ID` = :ItemID  
    ",array(
        [":NameItem",$Name],
        [":DescItem",$Description],
        [":PublicItem",$Public],
        [":ItemID",$ItemID]
    ));
    $JSONArray["success"] = true;
}catch(Exception $err)
{
    echo $err->getMessage();
}

exit(json_encode($JSONArray));


?>