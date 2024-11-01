<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Uploads_CreateImage();

if(Session::Validate_Session() == false){exit("Missing Session");}

$JSONArray = array(
    "success" => false, 
    "Name" => "",
    "Desc" => "", 
    "Decal" => ""
);

$Name = $_POST["Name"];
$Description = $_POST["About"];
$Image_File = $_FILES["DecalFile"];
$Public = isset($_POST["PrivateAsset"]) ? 0 : 1;
$AllowComments = isset($_POST["AllowComments"]) ? 1: 0;

if(empty($Name)){
    $JSONArray["Name"] = "Asset name cannot be empty";
    $NameError = true;
}

if($Image_File["error"] > UPLOAD_ERR_OK){
    $JSONArray["Decal"] = "Please Submit a valid Image";
    $DecalError = true;
}

//EXIT BECAUSE ERRORS HAPPENED
if(isset($DecalError) || isset($NameError)){exit(json_encode($JSONArray));}

$FinalFolder = $_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Data/Decals/";
$ImageFile_Temp = $Image_File["tmp_name"];

try{
    $TempName = Website::RandomString();
    $ImageUploader = new ImageUploader();
    $ImageUploader->SetImageSource($ImageFile_Temp);
    $ImageUploader->SetFinalLocation($FinalFolder.$TempName);
    $ImageUploader->Max_Heigth(1200);
    $ImageUploader->Max_Width(1200);
    $ImageUploader->Transparent(true);
    $ImageUploader->Execute();

    $Database = new Database();
    $NewItem = $Database->Execute_LastID("
            INSERT INTO `decals_data`
            (`Name`,`Description`,`Creator`,`Status`,`Public`)
            VALUES
            (:NameItem,:DescItem,:CreatorItem,1,:PublicItem)",
    array(
            [":NameItem",$Name],
            [":DescItem",$Description],
            [":CreatorItem",Session::Get_ID()],
            [":PublicItem",$Public],
    ));

    rename($FinalFolder.$TempName,$FinalFolder.$NewItem);

    $JSONArray["success"] = true;
}catch(Exception $err)
{
    $JSONArray["Decal"] = $err->getMessage();
}

//FINISH SCRIPT
exit(json_encode($JSONArray));



?>