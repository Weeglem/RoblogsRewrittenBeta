<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Forum_GroupData();
$x->Forum_PostData();
$JSON_Array = array(
    "success" => false,
    "message" => "" 
 );

try{

    if(Session::Validate_Session() == false){throw new Exception("You are not logged to Roblogs");}
    $PostID = $_POST["ForumID"];
    $Topic = $_POST["Message"];

    $Database = new Database();

    $Post = new Post_Data($PostID);
    if($Post->Can_Edit() != true);

    $Execute = $Database->Execute(
    "UPDATE `forums_posts`
     SET `Topic` = :NewTopic
     WHERE `ID` = :PostID",
    array(
        [":NewTopic",$Topic],
        [":PostID",$PostID]
    ));

    $JSON_Array["success"] = true;
    $JSON_Array["message"] = "Message sent Successfuly";

}catch(Exception $err)
{
    $JSON_Array["message"] = $err->getMessage(); 
}

exit(json_encode($JSON_Array)); 
?>