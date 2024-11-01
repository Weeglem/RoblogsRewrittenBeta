<?php
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();

    $JobID = isset($_GET["id"]) ? $_GET["id"] : 0;
    $SK = isset($_GET["sk"]) ? $_GET["sk"] : 0;
    $Database = new Database();
    $ValidateJob = $Database->FetchColumn("SELECT 1 FROM `rccserver_games` WHERE `JobID` = ? ",array($JobID));
    if($ValidateJob == false){exit("Invalid Job Instance");}

    $SecurityKey = $Database->FetchColumn("
    SELECT 1 
    FROM `rccserver_games` 
    WHERE `JobID` = ? 
    AND `SecurityKey` = ? ",array($JobID,$SK));

    if($SecurityKey == false){exit("Invalid security key");}

    $RequestGame = curl_init("http://localhost:8000/game/kill?JobID=".$JobID);
    curl_setopt($RequestGame, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($RequestGame,CURLOPT_PROXY_SSL_VERIFYPEER,false);
    $Response = curl_exec($RequestGame);
    
    if($Response != true){
        exit("Failed to kill instance");
    }
    exit("Killed Instance");
?>