<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Forum_PostData();
$x->Forum_GroupData();
$JSON_Array = array(
    "success" => false,
    "message" => "" 
 );
$PostID = $_POST["ForumID"];


try{

    if(Session::Validate_Session() == false){throw new Exception("You are not logged to Roblogs");}

    $Database = new Database();
    $Post = new Post_Data($PostID);
    $Post->Is_Open();
    

    $Topic = $_POST["Message"];

    if(empty($Topic)){ throw new Exception("Message Cannot be empty"); }


    $GET = $Database->Prepare_Data_BindValue("
        SELECT `CategoryID`
        FROM `forums_posts` 
        WHERE `ID` = :PostID
    ",array([":PostID",$PostID]));

    $Execute = $Database->Execute(
    "
        INSERT INTO
        `forums_posts`
        (`ParentID`,`CategoryID`,`Topic`,`Owner`,`Date`)
        VALUES
        (:ParentID,:CategoryID,:TopicPost,:OwnerPost,:DatePost)
        
    ",array(
        [":ParentID",$PostID],
        [":CategoryID",$GET[0]["CategoryID"]],
        [":TopicPost",$Topic],
        [":OwnerPost",Session::Get_Username()],
        [":DatePost",strtotime(date("F j, g:i a"))]
    ));

    $JSON_Array["success"] = true;
    $JSON_Array["message"] = "Message sent Successfuly";
    
}catch(Exception $err){ 
    $JSON_Array["message"] = $err->getMessage(); 
}

exit(json_encode($JSON_Array)); 



?>