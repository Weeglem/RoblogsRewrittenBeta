<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Group_Data();
$x->Pagination();

$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;
$Get_Name = isset($_GET["Name"]) ? $_GET["Name"] : "";

$Group_Pagination = new Groups_Pagination();
$Group_Pagination->Max_Items_Value(12);
$Group_Pagination->Set_Page($Page);
$Group_Pagination->Search_Name($Get_Name);
$Group_Pagination->Execute();

$TotalCount = $Group_Pagination->Get_Total_Count();
$TotalArray = $Group_Pagination->Get_Fetch();

function DrawGroups($Array = array()){
    foreach($Array as $Group)
    {
        try{
            
            $ID = $Group["ID"];
            $GroupData = new Group_Data($Group["ID"]);
            $Name = $GroupData->Name();
            $Description = $GroupData->Description();
            $Owner = $GroupData->Creator();
            $Members = $GroupData->Members_Count();

            echo "
            
            <figure>

                <a href='./Group/?id=$ID'>$Name</a>

            </figure>
            <br>
            
            ";

        }catch(Exception $err)
        {
            //SKIP GROUP IF FAILED
            echo "";
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Home"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<h1>ROBLOGS GROUPS</h1>
<?=DrawGroups($TotalArray)?>
<?=$Group_Pagination->Draw_Pagination();?>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>