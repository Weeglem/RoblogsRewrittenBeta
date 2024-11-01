<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Pagination();
$x->Group_Data();

header("Content-Type: application/json");

$GET_group = isset($_GET["group"]) ? $_GET["group"] : null;
$GET_ally = isset($_GET["enemy"]) ? $_GET["enemy"] : 0;
$GET_page = isset($_GET["page"]) ? $_GET["page"] : 1;

$Group_Allies_Pagination = new Group_Allies_Pagination();
$Group_Allies_Pagination->Max_Items_Value(6);
$Group_Allies_Pagination->GroupID($GET_group);
$Group_Allies_Pagination->Enemy($GET_ally);
$Group_Allies_Pagination->Set_Page($GET_page);
$Group_Allies_Pagination->execute();

$TotalCount = $Group_Allies_Pagination->Get_Total_Count();
$TotalArray = $Group_Allies_Pagination->Get_Fetch();

$Items = array();
$Final = array(
    "Next" => $Group_Allies_Pagination->Get_NextPage(),
    "Back" => $Group_Allies_Pagination->Get_BackPage(),
    "Items" => "",
    "Page" => $Group_Allies_Pagination->Get_Actual_Page()
);

if($Group_Allies_Pagination->Get_ThisPage_Count() > 0){
    foreach($TotalArray as $Item){

        $GroupID = $Item["AllyID"];
        $Group = new Group_Data($GroupID);
        $GroupName = $Group->Name();

        $Items[] = array(
            "GroupID" => $GroupID,
            "GroupName" => $GroupName,
        );
    }
    $Final["Items"] = $Items;
}

exit(json_encode($Final));

?>