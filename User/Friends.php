<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Session();
$x->Pagination();
$x->User_Data();

$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;
$Get_ID = isset($_GET["id"]) ? $_GET["id"] : Session::Get_ID();

$Friends_Pagination = new Friends_Pagination($Get_ID);
$Friends_Pagination->Max_Items_Value(18);
$Friends_Pagination->Set_Page($Page);
$Friends_Pagination->Execute();

$TotalCount = $Friends_Pagination->Get_Total_Count();
$Total_Array = $Friends_Pagination->Get_Fetch();


$ActualUser = new User_Data($Get_ID);
$Username = $ActualUser->Username();
$UserID = $ActualUser->ID();

function Draw_Friends($Array = array()){
    foreach($Array as $Friend)
    {
        $Friend_D = $Friend["FriendID"];
        $User = new User_Data($Friend_D);

        $Username = $User->Username();
        $ID = $User->ID();
        $Avatar = $User->Avatar();
        $Online = $User->Draw_Online();

        echo '
        <category class="Friend_Div" id="FriendsPanel">
            <a href="'.WebsiteLinks::Profile_Page($ID).'" class="SmallText Link">
                <img src="'.$Avatar.'" class="AvatarsThumbnail_Medium" alt="'.$Username.'">
                <p>'.$Online.$Username.'</p>
             </a>
        </category>
        ';
    }  
}
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Friends_Page"; $Page_Title = "USER Friends"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<div class="Friends_Cont">
    <h3><?=$Username;?>'s Friends</h3>
    <a class="SmallText Link" href="<?=WebsiteLinks::Profile_Page($UserID)?>">Visit Profile</a>
    <hr>
    <div class="Friends_Container">
        <?=Draw_Friends($Total_Array);?>
    </div>
</div>
<div class="Paginator"><?=$Friends_Pagination->Draw_Pagination()?></div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>