<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Session();
    $x->Database();
    $x->User_Data();
    $x->User_Ban();
    
    try{
        UserBan::UnbanUser(4);
    }
    catch(Exception $err)
    {
        echo $err->getMessage();
    }
    exit();
?>