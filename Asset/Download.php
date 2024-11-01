<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Session();
    $x->Database();
    $x->Model_Data();
    $x->Game_Data();
    $x->Decal_Data();

    $ItemID = isset($_GET["id"]) ? $_GET["id"] : null;
    $Type = isset($_GET["type"]) ? $_GET["type"] : null;
    $RandomName = uniqid();

    $z = $Type."_data";


    try{
        if(!class_exists($z)) throw new Exception("Invalid Asset Class Type");
        $ItemData = new $z($ItemID);
        $AssetLink = $ItemData->Download_Link();
        $AssetName = $ItemData->Name();
        $FileContent = @file_get_contents($AssetLink);
        if($FileContent == false) throw new Exception("Failed to get Asset Data");

    }catch(Exception $err)
    {
        exit($err->getMessage());
    }

    switch($Type){
        case "Game":
        case "Model":
        default:
            try{
                $FileGZ = @gzdecode($FileContent);
                if($FileGZ == false)throw new Exception("Failed to uncompress Roblox Type Data");

                $Zip = new ZipArchive;
                $Zip->open("$RandomName.zip",ZipArchive::CREATE);
                
                if($Type == "Game") $Zip->addFromString("$AssetName.rbxl",$FileGZ);
                if($Type == "Model") $Zip->addFromString("$AssetName.rbxm",$FileGZ);
                
                $Zip->close();

                header("Content-type: application/zip"); 
                header("Content-Disposition: attachment; filename=$AssetName.zip"); 
                readfile("$RandomName.zip");
                unlink("$RandomName.zip");

            }
            catch(Exception $err)
            {
                exit($err->getMessage());
            }
        break;
        case "Decal":
            header("Content-type: image/png");
            header("Content-Disposition: attachment; filename=$AssetName.png"); 
            readfile($AssetLink);
        break;
    }



exit();

?>