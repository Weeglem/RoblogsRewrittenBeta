<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$Database = new Database();
$JSON_data = array(
    "success" => false,
    "error" => "",
    "uri" => null,
    "ip" => null,
    "port" => null,
    "client" => null,
);

$GameID = 1;
$Client = "2010L";


//DOES GAMES EXISTS ? 
$ValidGame = $Database->FetchColumn("
SELECT 1 
FROM `games_data`
WHERE `ID` = ?
AND `Status` = 1
LIMIT 1
",array($GameID));

if($ValidGame == false)
{
    $JSON_data["error"] = "Requested game is invalid";
    exit(json_encode($JSON_data));
}

//YES PROCCEED

$Ask = $Database->FetchColumn("
SELECT 1 
FROM `rccserver_games` 
WHERE `GameID` = ?
AND `PlayersOnline` < `MaxPlayers`
LIMIT 1",array($GameID));

if($Ask == false){
    $RequestGame = curl_init("http://localhost:8000/game/new?MapID=".$GameID."&RobloxVer=".$Client);
    curl_setopt($RequestGame,CURLOPT_POST,true);
    curl_setopt($RequestGame, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($RequestGame,CURLOPT_PROXY_SSL_VERIFYPEER,false);
    $Response = curl_exec($RequestGame);
    if($Response != true){
        $JSON_data["error"] = "Failed to initializate Server for this game";
        exit(json_encode($JSON_data));
    }
}

$Execute = $Database->Prepare_Data_BindValue("
SELECT `IP`,`Port`,`Client` 
FROM `rccserver_games` 
WHERE `GameID` = :GameID
AND `PlayersOnline` < `MaxPlayers`
LIMIT 1",array([":GameID",$GameID]));

$Client = $Execute[0]["Client"];
$Port = $Execute[0]["Port"];
$IP = $Execute[0]["IP"];

$ServerURI = base64_encode(base64_encode($IP).'|'.base64_encode($Port).'|'.base64_encode($Client));

$JSON_data["success"] = true;
$JSON_data["ip"] = $IP;
$JSON_data["port"] = $Port;
$JSON_data["client"] = $Client;
$JSON_data["uri"] = $ServerURI;

exit(json_encode($JSON_data));
?>