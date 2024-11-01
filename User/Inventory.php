<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Session();
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
$Library_Pagination->Max_Items_Value(20);
$Library_Pagination->Set_Page($Page);
$Library_Pagination->Search_Type($Get_Type);
$Library_Pagination->Execute();

$TotalCount = $Library_Pagination->Get_Total_Count();
$TotalArray = $Library_Pagination->Get_Fetch(); 

$ActualUser = new User_Data($Get_ID);
$Username = $ActualUser->Username();
$UserID = $ActualUser->ID();

function Draw_Asset($Array = array())
{
    global $Get_Type;
    foreach($Array as $Item)
    {
        $x = substr_replace($Get_Type, '', -1)."_Data";
        $Asset = new $x($Item["ID"]);
        $Name = $Asset->Name();
        $Name = strlen($Name) > 18 ? substr($Name,0,18)."..." : $Name;
        $Thumbnail = $Asset->Thumbnail();
        $Type = $Asset->Content_Type();
        $Status = $Asset->Status();
        $Owner = $Asset->Creator();
        $Owner_Username = $Asset->Creator_Username();

        echo '
        <div class="Search_Item_Div">
            <img src="'.$Thumbnail.'" class="SearchItem_Small greyborder border" alt="">
            <p class="Title">'.$Name.'</p>
            <p class="Info">Owner: <a class="Link" href="'.$Owner.'">'.$Owner_Username.'</a></p>  
            <p class="Info">Status: '.$Status.'</p>
        </div>
        ';
    }
}

function Draw_Types($Array = array()){
    global $Get_Type;
    $X = isset($Get_Type) == true ? $Get_Type : null;
    foreach($Array as $Type)
    {
        echo $X == $Type ? 
        '<li><a class="Search_ListItem Active_ListItem" href="'.WebsiteLinks::Create_Link("Type",$Type).'">'.$Type.'</a></li>' : 
        '<li><a class="Search_ListItem" href="'.WebsiteLinks::Create_Link("Type",$Type).'">'.$Type.'</a></li>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Library"; $Page_Title = "Library"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>

<div class="Search_Container">
    <div class="Search_Filter">
        <h3>Filter Results</h3>
        <hr>
        <p class="FakeLabel">Asset Type: </p>
        <ul><?=Draw_Types($Types_Array)?></ul>
    </div>
    <div class="Search_Body">
        <div class="Search_Details">
            <h1><?=$Username;?> > <?=Website::EncodeString($Get_Type)?></h1>
        </div>
        <hr>
        <div class="Search_Flex"><?=$Library_Pagination->Get_ThisPage_Count() > 0 ? Draw_Asset($TotalArray) : "No results found" ?></div>
        <div class="Paginator"><?=$Library_Pagination->Get_ThisPage_Count() > 0 ? $Library_Pagination->Draw_Pagination() : "" ?></div>
    </div>
</div>

</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>