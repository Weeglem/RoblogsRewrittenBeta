<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$JSON_Array = array(
   "success" => false,
   "message" => "" 
);

if(Session::Validate_Session() == false)
{
    $JSON_Array["message"] = "You are not logged to Roblogs";
    exit(json_encode($JSON_Array)); 
}

$Forum = $_POST["ID"];

$Database = new Database();
$Execute = $Database->Execute("
INSERT 
INTO `forums_following` 
(`UserID`,`PostID`) 
VALUES
(:UserID,:PostID)
",array(
[":UserID",Session::Get_ID()],
[":PostID",$Forum]
));



$JSON_Array["message"] = "You started to follow this thread";
$JSON_Array["success"] = true;
exit(json_encode($JSON_Array));