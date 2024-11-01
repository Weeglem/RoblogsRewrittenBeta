<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Uploads_CreateImage();
$JSON_Array = array(
    "success" => false,
    "message" => "" 
 );

try{
    if(Session::Validate_Session() == false){throw new Exception("You are not logged to Roblogs");}
    $FinalFolder = $_SERVER["DOCUMENT_ROOT"]."/Website/avatars/";

    $Image_File = $_FILES["Avatar"];
    $ImageFile_Temp = $Image_File["tmp_name"];

    $ImageUploader = new ImageUploader();
    $ImageUploader->SetImageSource($ImageFile_Temp);
    $ImageUploader->SetFinalLocation($FinalFolder.Session::Get_ID().".png");
    $ImageUploader->Max_Heigth(900);
    $ImageUploader->Max_Width(900);
    $ImageUploader->Execute();

    $JSON_Array["success"] = true;
}catch(Exception $err)
{
    $JSON_Array["message"] = $err->getMessage();
}

exit(json_encode($JSON_Array)); 
?>