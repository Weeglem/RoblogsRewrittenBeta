<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Session();
    $x->Database();
    $x->Uploads_RobloxHandler();

    if(Session::Validate_Session() == false){exit("Login required");}

    $RobloxGZIP = file_get_contents("php://input");
    $Name = Website::Get("name","Placeholder");
    $Description = Website::Get("desc","Placeholder dsc");
    $Private = Website::Get("priv") == "on" ? 1 : 0;
    $SessionID = Session::Get_ID(); //FIX MULTIPLE EXPLORERS BUG

    try{
        $RobloxItem = RobloxUpload_Handler::CreateGZip($RobloxGZIP,true);

        $Database = new Database();
        $NewItem = $Database->Execute_LastID("
            INSERT INTO `models_data`
            (`Name`,`Description`,`Creator`,`Public`)
            VALUES
            (:NameItem,:DescItem,:CreatorItem,:PublicItem)",
        array(
            [":NameItem",$Name],
            [":DescItem",$Description],
            [":CreatorItem",$SessionID],
            [":PublicItem",$Private]
        ));

        $Execute_Update = $Database->Execute("
            UPDATE
            `models_data`
            SET
            `Thumbnail` = :NewID,
            `Download` = :NewID
            WHERE 
            `ID` = :NewID
        ",array(
            [":NewID",$NewItem]
        ));

        file_put_contents(WebsiteLinks::Server_ModelsFolder()."$NewItem",$RobloxItem);
    }
    catch(Exception $err)
    {
        file_put_contents("ErrorLog_New.txt",$err->getMessage());
        exit($err->getMessage());
    }

exit();

?>