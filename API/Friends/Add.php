<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");

$x = new Includes();
$x->Database();
$x->Session();
$x->User_Friend();
$x->User_Data();

$GET_id = isset($_POST["id"]) ? $_POST["id"] : null;
$Array = array("success" => false,"message" => "");

try{
    if(Session::Validate_Session() != true) throw new Exception("You are not logged");
    
    $SendRequest = User_FriendController::Add($GET_id);
    $Array["success"] = true;
}catch(Exception $err)
{
    $Array["message"] = $err->getMessage();
}

exit(json_encode($Array));


?>