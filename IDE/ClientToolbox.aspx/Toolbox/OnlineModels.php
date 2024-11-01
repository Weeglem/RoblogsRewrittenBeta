<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();
    $x->User_Data();
    $x->Model_Data();
    $x->Decal_Data();
    $x->Pagination();

    header("Content-Type: application/json");

    $Get_Name = isset($_GET["Name"]) ? $_GET["Name"] : "";
    $Get_Name = isset($_GET["name"]) ? $_GET["name"] : "";
    $Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;
    $Get_Type = isset($_GET["Type"]) ? $_GET["Type"] : "Models";

    $Toolbox_Pagination = new Toolbox_Pagination();
    $Toolbox_Pagination->Execute();
    $Toolbox_Pagination->Max_Items_Value(20);
    $Toolbox_Pagination->Set_Page($Page);
    $Toolbox_Pagination->Search_Name($Get_Name);
    $Toolbox_Pagination->Search_Type("Models");
    $Toolbox_Pagination->Execute();

    $TotalCount = $Toolbox_Pagination->Get_Total_Count();
    $TotalArray = $Toolbox_Pagination->Get_Fetch();

    $Items = array();
    $Final = array(
    "Next" => $Toolbox_Pagination->Get_NextPage(),
    "Back" => $Toolbox_Pagination->Get_BackPage(),
    "Items" => "",
    "Page" => $Toolbox_Pagination->Get_Actual_Page()
    );




    if($Toolbox_Pagination->Get_Total_Count() > 0 ){
    foreach($TotalArray as $Item){
        global $Get_Type;

        
        $x = substr_replace($Get_Type, '', -1)."_Data";
        $Asset = new $x($Item["ID"]);
        $Name = $Asset->Name();
        $Thumbnail = $Asset->Thumbnail("Toolbox");
        $ID = $Asset->ID();
        $Type = $Asset->Content_Type();

        $Items[] = array(
            "Name" => $Name,
            "ID" => $ID,
            "Thumbnail" => $Thumbnail,
            "Link" => "http://$_SERVER[SERVER_NAME]/Assets/Toolbox/LoadOnlineModel.php?id=$ID&type=$Type",
        );
    }

    $Final["Items"] = $Items;
    }


    exit(json_encode($Final));
?>