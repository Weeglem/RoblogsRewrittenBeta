<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Forum_GroupData();
$x->Forum_PostData();

$GroupID = $_POST["ForumID"];
$Name = $_POST["Subject"];
$Topic = $_POST["Message"];

try{
    if(Session::Validate_Session() == false){ throw new Exception("You are not logged to Roblogs"); }
    if(empty($Name)){throw new Exception("Name cannot be empty");}
    if(empty($Topic)){throw new Exception("Message cannot be empty");}

    $Database = new Database();
    ForumGroup_Data::IsPublic($GroupID);
    $Execute = $Database->Execute_LastID(
    "
    INSERT INTO
    `forums_posts`
    (`CategoryID`,`Name`,`Topic`,`Owner`,`Date`)
    VALUES
    (:CategoryID,:NamePost,:TopicPost,:OwnerPost,:DatePost)

    ",array(
        [":CategoryID",$GroupID],
        [":NamePost",$Name],
        [":TopicPost",$Topic],
        [":OwnerPost",Session::Get_Username()],
        [":DatePost",strtotime(date("F j, g:i a"))]
    ));

    $JSON_Array["success"] = true;
    $JSON_Array["message"] = "http://localhost/Forums/ShowPost.php?id=".$Execute;

}catch(Exception $err)
{
    $JSON_Array["message"] = $err->getMessage(); 
}


exit(json_encode($JSON_Array)); 


?>