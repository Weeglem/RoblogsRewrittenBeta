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

try{
    Session::Validate_Session_Exception();
    
    $NewBio = $_POST["About"];
    $UserID = Session::Get_ID();
    $Database = new Database();

    $Execute = $Database->Execute("
    UPDATE `users_data`
    SET `About` = :NewBio
    WHERE `ID` = :UserID
    ",
    array(
        [":NewBio",$NewBio],
        [":UserID",$UserID]
    ));

    $JSON_Array["success"] = true;
    $JSON_Array["message"] = "Sucess";

}catch(Exception $err)
{
    $JSON_Array["message"] = $err->getMessage(); 
}

exit(json_encode($JSON_Array)); 
?>

