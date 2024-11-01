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

$AllowMessages = isset($_POST["AllowMessages"]) ? 1 : 0;
$AllowFriendRequests = isset($_POST["FriendRequest"]) ? 1 : 0;
$FilterText = isset($_POST["FilterText"]) ? 1 : 0;
$PublicContact = isset($_POST["PublicContact"]) ? 1 : 0;

try{
    Session::Validate_Session_Exception();
    $Database = new Database();
    $Execute = $Database->Execute(
        "UPDATE `users_settings` 
        SET `AllowMessages`=:AllowMessages,
        `FriendRequests`=:FriendRequests,
        `CensorText`= :FilterText,
        `PublicContact`= :PublicContact
        WHERE `ID` = :UserID",
        array(
            [":AllowMessages",$AllowMessages],
            [":FriendRequests",$AllowFriendRequests],
            [":FilterText",$FilterText],
            [":PublicContact",$PublicContact],
            [":UserID",Session::Get_ID()]
        ));

    $JSON_Array["success"] = true;
    $JSON_Array["message"] = "Sucess";

}catch(Exception $err)
{
    $JSON_Array["message"] = $err->getMessage(); 
}

exit(json_encode($JSON_Array));  
?>