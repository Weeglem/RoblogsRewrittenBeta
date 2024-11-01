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
    $WebsiteNames = $_POST["SocialMedia"];
    $WebsiteLinks = $_POST["SocialMediaLink"];
    $Database = new Database();

    $Clean = $Database->Execute("DELETE FROM `users_socialmedia` WHERE `UserID` = :UserID",array([":UserID",4]));

    for($i = 0; $i < count($WebsiteNames); $i ++)
    {
        if(empty($WebsiteLinks[$i]) || empty($WebsiteNames[$i]))
        {
            throw new Exception("Complete all slots");
        }
    }

    for($i = 0; $i < count($WebsiteNames); $i ++)
    {
        $ActualName = $WebsiteNames[$i];
        $ActualLink = $WebsiteLinks[$i];

        $Insert = $Database->Execute(
            "INSERT INTO `users_socialmedia` 
            (`UserID`, `Site`, `Link`) 
            VALUES (:UserID,:SiteName,:SiteURL)",
        array([":UserID",Session::Get_ID()],[":SiteName",$ActualName],[":SiteURL",$ActualLink]));
    }

    $JSON_Array["success"] = true;
    $JSON_Array["message"] = "Sucess";

}catch(Exception $err){
    $JSON_Array["message"] = $err->getMessage(); 
}

exit(json_encode($JSON_Array));
?>