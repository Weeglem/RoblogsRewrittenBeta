<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();
    $x->User_Data();
    $x->User_Message();
    $x->Session();
    $Array = array("success" => false,"message" => "");

    try{
        if(Session::Validate_Session() == false){ throw new Exception("You are not logged to Roblogs");}
 
        $Username = isset($_POST["Username"]) == true ? $_POST["Username"] : null;
        
        $UserID = User_DataController::GetID($Username); // GET ID FROM USERNAME

        $Post_Subject = isset($_POST["Subject"]) ? $_POST["Subject"] : throw new Exception("Missing Subject");
        $Post_Message = isset($_POST["Message"]) ? $_POST["Message"] : throw new Exception("Missing Message");
        

        $Post_Subject = trim($Post_Subject);
        $Post_Message = trim($Post_Message);

        if(empty($Post_Message)) throw new Exception("Empty Message");
        if(empty($Post_Subject)) throw new Exception("Empty Message");

        if(new User_Data($UserID) != true){ throw new Exception("Invalid User");}

        $Message = new User_Message();
        $Message->From_ID(Session::Get_ID());
        $Message->To_ID($UserID);
        $Message->Subject($Post_Subject);
        $Message->Message($Post_Message);
        $Message->Send_Message();

        $Array["success"] = true;

    }catch(Exception $err){
        $Array["message"] = $err->getMessage();
    }

    exit(json_encode($Array));
?>


