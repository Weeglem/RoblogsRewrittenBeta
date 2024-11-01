<?php
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();

    $Database = new Database();
    $Execute = $Database->Execute("TRUNCATE TABLE `rccserver_games`");
    exit();
?>