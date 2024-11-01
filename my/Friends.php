<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->User_Data();
$x->Pagination();

$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;
$PendingFriend = isset($_GET["pending"]) == true ? 1 : 0;

$Get_ID = Session::Get_ID();

if($PendingFriend == 1){
    $Friends_Pagination = new PendingFriends_Pagination($Get_ID);
}else{
    $Friends_Pagination = new Friends_Pagination($Get_ID);
}

$Friends_Pagination->Max_Items_Value(18);
$Friends_Pagination->Set_Page($Page);
$Friends_Pagination->Execute();

$TotalCount = $Friends_Pagination->Get_Total_Count();
$Total_Array = $Friends_Pagination->Get_Fetch();

function Draw_Friends($Total_Array = array()){
    foreach($Total_Array as $FriendData)
    {
        global $PendingFriend;

        $FriendID = $FriendData["FriendID"];
        $UserData = new User_Data($FriendID);
        $Username = $UserData->Username();
        $Online = $UserData->Draw_Online();
        $Avatar = $UserData->Avatar();

        if($PendingFriend == true)
        {
            $Buttons =
            '<button type="submit" name="Reject" value="Reject" id="Reject">Reject</button>
            <button type="submit" name="Accept" value="Accept" id="Accept">Accept</button>'
            ;
        }else{
            $Buttons =
            '<button type="submit" name="Unfriend" value="Unfriend" id="Unfriend">Unfriend</button>'
            ;
        }

        echo '
        <category class="Friend_Div FriendPanel" id="FriendsPanel">
            <a href="'.WebsiteLinks::Profile_Page($FriendID).'" class="SmallText Link">
                    <img src="'.$Avatar.'" class="AvatarsThumbnail_Medium" alt="'.$Username.'">
                    <p>'.$Online.$Username.'</p>
            </a>
            <form class="ActionsButton" id="FriendsManage_Form">
                    <input type="number" name="id" id="id" value="'.$FriendID.'" readonly="true" style="display:none;">
                    '.$Buttons.'
            </form>
        </category>
        ';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Friends_Page"; $Page_Title = "Modify Friends"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<!---Content Container Start-->

<div class="Friends_Cont">
    <h3>Edit Friend List</h3>
    <a href="./Friends.php">My Friends</a>
    <a href="?pending">Pending Friends</a>
    <hr>
    <div class="Friends_Container"><?=Draw_Friends($Total_Array);?></div>
</div>
<div class="Paginator"><?=$Friends_Pagination->Draw_Pagination()?></div>

<!---Content Container Close-->
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="./FriendsLogic.js"></script>
</body>
</html>