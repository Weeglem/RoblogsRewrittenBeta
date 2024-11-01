<?php
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();

    $JobID = 1;
    $SecKey = 1;
    $GameID = 1;
    $GamePort = 25565;
    $GameIP = 1;
    $GameClient = "2010L";
    $MaxPlayers = 12;

    $Database = new Database();
    $Execute = $Database->Execute(
        "INSERT INTO `rccserver_games`(`JobID`, `SecurityKey`, `GameID`, `Port`, `IP`, `Client`, `MaxPlayers`) 
        VALUES (:JobID,:SecurityKey,:GameID,:GamePort,:GameIP,:GameClient,:MaxPlayers)"
    ,array(
        [":JobID",$JobID],
        [":SecurityKey",$SecKey],
        [":GameID",$GameID],
        [":GamePort",$GamePort],
        [":GameIP",$GameIP],
        [":GameClient",$GameClient],
        [":MaxPlayers",$MaxPlayers]
    ));

    exit();
?>