<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Pagination();
$x->User_Data();

header("Content-Type: application/json");

$GET_group = isset($_GET["group"]) ? $_GET["group"] : null;
$GET_rank = isset($_GET["rank"]) ? $_GET["rank"] : null;
$GET_page = isset($_GET["page"]) ? $_GET["page"] : 1;

$Groups_Member_Pagination = new Group_Members_Pagination();
$Groups_Member_Pagination->Max_Items_Value(6);
$Groups_Member_Pagination->Search_GroupID($GET_group);
$Groups_Member_Pagination->Set_Page($GET_page);
$Groups_Member_Pagination->Search_RankID($GET_rank);
$Groups_Member_Pagination->execute();
$TotalCount = $Groups_Member_Pagination->Get_Total_Count();
$TotalArray = $Groups_Member_Pagination->Get_Fetch();

$Items = array();
$Final = array(
    "Next" => $Groups_Member_Pagination->Get_NextPage(),
    "Back" => $Groups_Member_Pagination->Get_BackPage(),
    "Items" => "",
    "Page" => $Groups_Member_Pagination->Get_Actual_Page()
);

if($Groups_Member_Pagination->Get_ThisPage_Count() > 0){
    foreach($TotalArray as $Item){

        $Rank = $Item["Rank"];
        $UserID = $Item["UserID"];
        $User = new User_Data($UserID);
        $Username = $User->Username();

        $Items[] = array(
            "UserID" => $UserID,
            "Username" => $Username,
            "Rank" => $Rank,
        );
    }
    $Final["Items"] = $Items;
}

exit(json_encode($Final));

?>