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
DELETE
FROM `forums_following`
WHERE `UserID` = :UserID AND `PostID` = :PostID
",array(
[":UserID",Session::Get_ID()],
[":PostID",$Forum]
));

$JSON_Array["success"] = true;
$JSON_Array["message"] = "Stopped Following this Thread";
exit(json_encode($JSON_Array));