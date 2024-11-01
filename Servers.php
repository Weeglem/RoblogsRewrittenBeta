<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();

$Database = new Database();
$FetchGames = $Database->Prepare_Data_BindValue("
SELECT 
`rccserver_games`.`GameID` AS `GameID`,
`rccserver_games`.`JobID`  AS `JobID`,
`rccserver_games`.`MaxPlayers`  AS `MaxPlayers`,
`rccserver_games`.`Client`  AS `Client`,
`rccserver_games`.`IP`  AS `IP`,
`rccserver_games`.`Port`  AS `Port`,
`games_data`.`Name` AS `MapName`,
(SELECT COUNT(*) FROM `rccserver_games` WHERE `GameID` = `GameID`) AS `OnlineServers`

FROM `rccserver_games`
INNER JOIN `games_data`
ON `rccserver_games`.`GameID` = `games_data`.`ID`
");



foreach($FetchGames as $GameServer)
{
    $MapName = $GameServer["MapName"];
    $Map = $GameServer["GameID"];
    $JobID = $GameServer["JobID"];
    $MaxPlayers = $GameServer["MaxPlayers"];
    $Client = $GameServer["Client"];
    $Port = $GameServer["Port"];
    $IP = $GameServer["IP"];
    $OnlineServers = $GameServer["OnlineServers"];

    echo "Map: $MapName    /MaxPlayers: $MaxPlayers   /Client $Client Online Users: 0<br> <a href='novetus://".base64_encode(base64_encode($IP).'|'.base64_encode($Port).'|'.base64_encode($Client))."'>Join Game</a>";


}
?>