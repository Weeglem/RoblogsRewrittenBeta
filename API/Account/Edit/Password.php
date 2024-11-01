<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->WebsiteValidaiton();

$JSON_Array = array(
    "success" => false,
    "message" => "" 
 );

$NewPassword = $_POST["NewPassword"];
$NewPassword_Repeat = $_POST["NewPassword2"];
$OldPassword = $_POST["OldPassword"];

try{
    Session::Validate_Session_Exception();
    Website_Validation::Valid_Password($NewPassword,$NewPassword_Repeat);
    Session::Change_Password($OldPassword,$NewPassword);

    $JSON_Array["success"] = true;
    $JSON_Array["message"] = "Sucess";

}catch(Exception $err)
{
    $JSON_Array["message"] = $err->getMessage(); 
}

exit(json_encode($JSON_Array)); 
?>

