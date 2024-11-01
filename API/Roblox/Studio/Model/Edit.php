<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Session();
    $x->Database();
    $x->Uploads_RobloxHandler();
    $x->Game_Data();

    if(Session::Validate_Session() == false){exit("Login required");}

    $RobloxGZIP = file_get_contents("php://input");
    $ItemID = Website::Get("id");
    $SessionID = Session::Get_ID();

    try{
        $Data = new Game_Data($ItemID);
        if($SessionID != $Data->Creator()) throw new Exception("You dont own this Item");   
        $RobloxItem = RobloxUpload_Handler::CreateGZip($RobloxGZIP,true);
        file_put_contents(WebsiteLinks::Server_GamesFolder()."$ItemID",$RobloxItem);
    }
    catch(Exception $err)
    {
        file_put_contents("ErrorLog_Update.txt",$err->getMessage());
        exit($err->getMessage());
    }

exit();

?>