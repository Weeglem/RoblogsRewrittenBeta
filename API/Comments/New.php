<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();
    $x->Session();
    $x->Game_Data();
    $x->Decal_Data();
    $x->Model_Data();
    $x->Comment_Data();
    if($_SERVER["REQUEST_METHOD"] != "POST") exit("Invalid Method");

    $Post_ItemID = isset($_POST["id"]) ? $_POST["id"] : null;
    $Post_AssetType =  isset($_POST["Type"]) ? $_POST["Type"] : null;
    $Post_Comment = isset($_POST["Comment"]) ? $_POST["Comment"] : null;
    $Array = array("success" => false,"message" => "");

    try{
        if(Session::Validate_Session() == false) throw new Exception("You are not logged to Roblogs");
        $Comment_Creator = new Comment_Creator();
        $Comment_Creator->AssetID($Post_ItemID);
        $Comment_Creator->AssetType($Post_AssetType);
        $Comment_Creator->Message($Post_Comment);
        $Comment_Creator->Send();
        $Array["success"] = true;
    }catch(Exception $err)
    {
        $Array["message"] = $err->getMessage();
    }

    exit(json_encode($Array));

?>

