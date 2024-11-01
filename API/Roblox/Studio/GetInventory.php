<?php

session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Pagination();
$x->Model_Data();
$x->Game_Data();

$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;
$Get_Type = isset($_GET["Type"]) ? $_GET["Type"] : "Models";

$Types_Array = array("Games","Models");
if(in_array($Get_Type,$Types_Array) == false){exit("Invalid Category");}

$Library_Pagination = new Inventory_Pagination(Session::Get_ID());
$Library_Pagination->Max_Items_Value(6);
$Library_Pagination->Set_Page($Page);
$Library_Pagination->Search_Type($Get_Type);
$Library_Pagination->Execute();

$TotalCount = $Library_Pagination->Get_Total_Count();
$TotalArray = $Library_Pagination->Get_Fetch(); 

header("Content-Type: application/json");

$Items = array();
$Final = array(
    "Next" => $Library_Pagination->Get_NextPage(),
    "Back" => $Library_Pagination->Get_BackPage(),
    "Items" => "",
    "Page" => $Library_Pagination->Get_Actual_Page()
);

if($Library_Pagination->Get_ThisPage_Count() > 0){
    foreach($TotalArray as $Item)
    {
        //SANTIZE PROPERLY LOCK CATEGORIES
        $x = substr_replace($Get_Type, '', -1)."_Data";
        $Asset = new $x($Item["ID"]);


        $Name = $Asset->Name();
        $ID = $Asset->ID();

        $Items[] = array(
            "ItemID" => $ID,
            "Name" => $Name,
        );
    }
    $Final["Items"] = $Items;
}

exit(json_encode($Final));

