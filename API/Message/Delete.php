<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();
    $x->Session();
    $x->User_Data();
    $x->User_Message();
    $x->Message_Data();

    if(Session::Validate_Session() != true){ exit(json_encode(array("message" => "Not logged to roblogs"))); }

    $Checks = $_POST['check_list'];

    if(count($Checks) == 0){ exit(json_encode(array("message" => "There are no messages to Delete.")));}


    foreach($Checks as $check) {
        try{
            //REMOVE ID VALIDATION HARD CODING FROM THE CLASS
            //MOSTLY FOR MODERATION 

            Message_Controller::Delete($check);
        }catch(Exception $err)
        {
            echo "Failed to delete message";
        }
    }

    return true;

    exit(json_encode(array("message" => "Finished")));

?>