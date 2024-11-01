<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();
    $x->Pagination();
    $x->Comment_Data();
    $x->User_Data();

    header("Content-Type: application/json");
    if($_SERVER["REQUEST_METHOD"] != "GET") exit("Invalid Method");

    $GET_id = isset($_GET["id"]) ? $_GET["id"] : null;
    $GET_type = isset($_GET["Type"]) ? $_GET["Type"] : null;
    $GET_page = isset($_GET["page"]) ? $_GET["page"] : 1;

    $Comments_Pagination = new Comments_Pagination();
    $Comments_Pagination->Max_Items_Value(7);
    $Comments_Pagination->Set_Page($GET_page);
    $Comments_Pagination->Asset_Type($GET_type);
    $Comments_Pagination->Asset_ID($GET_id);
    $Comments_Pagination->Execute();

    $TotalCount = $Comments_Pagination->Get_Total_Count();
    $TotalArray = $Comments_Pagination->Get_Results();

    $Final = array(
        "Next" => $Comments_Pagination->Get_NextPage(),
        "Back" => $Comments_Pagination->Get_BackPage(),
        "Items" => "",
        "Page" => $Comments_Pagination->Get_Actual_Page()
    );

    $Items = array();
    
    foreach($TotalArray as $Comment){
        $Comment_Data = new Comment_Data($Comment["ID"]);
        $UserID = $Comment_Data->UserID();
        $Message = $Comment_Data->Message();
        $Date = $Comment_Data->Date();

        $User = new User_Data($UserID);
        $Username = $User->Username();

        $Items[] = array(
            "UserID" => $UserID,
            "Username" => $Username,
            "Comment" => $Message,
            "Date" => $Date,
        );
    }

    $Final["Items"] = $Items;
        
    exit(json_encode($Final));


?>