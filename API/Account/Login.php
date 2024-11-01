<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Session();
    $x->Database();

    function LoginFail($message)
    {
       global $Array;
       $Array["message"] = $message;
       exit(json_encode($Array));
    }

    $Array = array("success" => false,"message" => "");
    if((Session::Validate_Session()) == true) LoginFail("Session already started");  
    //if(@$_SERVER["HTTPS"] != "on") LoginFail("Because Security reasons, This server only accepts HTTPS");
    if($_SERVER["REQUEST_METHOD"] != "POST") LoginFail("Invalid Request Method");

    $Username = $_POST["Username"];
    $Password = $_POST["Password"];
    $Database = new Database();

    $Count = $Database->FetchColumn("SELECT 1 FROM `users_data` WHERE `Username` = ?",array($Username));
    if($Count == 0)
    { 
        LoginFail("Invalid Username or Password");
    };

    $Password_DB = $Database->FetchColumn("SELECT `Password` FROM `users_data` WHERE `Username` = ?",array($Username));
    if(password_verify($Password,$Password_DB) != true){
        LoginFail("Invalid Username or Password");
    };

    $UserData = $Database->Prepare_Data("SELECT `Username`,`ID` FROM `users_data` WHERE `Username` = ?",array($Username));
    $Username_DB = $UserData[0]["Username"];
    $ID_DB = $UserData[0]["ID"];

    session::Create($Username_DB,$ID_DB,55);
    $Array["success"] = true;
    exit(json_encode($Array));





?>