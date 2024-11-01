<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Game_Data();
$x->User_Data();
$x->Model_Data();
$x->Decal_Data();
$x->Pagination();

$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;
$Get_ID = isset($_GET["id"]) ? $_GET["id"] : "";
$Get_Type = isset($_GET["Type"]) ? $_GET["Type"] : "Models";


$Types_Array = array("Games","Models","Decals");

$Library_Pagination = new Inventory_Pagination($Get_ID);
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
        $ID = $Item["ID"];
        $x = substr_replace($Get_Type, '', -1)."_Data";

        if(!class_exists($x)) exit(json_encode(array("Error" => "Invalid Asset type"))); //ADD TO ALL CODE THAT RELIES ON THIS

        try{

        $Asset = new $x($ID);
        $Name = $Asset->Name();
        $Thumbnail = $Asset->Thumbnail();
        $Type = $Asset->Content_Type();
        $Link = $Asset->Website_Link();

        }catch(Exception $e){
            exit(json_encode(array("Error" => $e->getMessage())));
        }

        $Items[] = array(
            "ItemID" => $ID,
            "Name" => $Name,
            "Thumbnail" => $Thumbnail,
            "Link" => $Link,
        );
    }
    $Final["Items"] = $Items;
}

exit(json_encode($Final));
?>