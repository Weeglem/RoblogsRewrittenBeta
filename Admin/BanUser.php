<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Session();
    $x->Database();
    $x->User_Data();
    $x->User_Ban();

    try{
        UserBan::BanUser(4,false,"1 Day");
    }
    catch(Exception $err)
    {
        echo $err->getMessage();
    }
    exit();
?>