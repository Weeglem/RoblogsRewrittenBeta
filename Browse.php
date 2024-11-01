<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->User_Data();
$x->Pagination();

$User_Pagination = new Users_Pagination();

$Username = isset($_GET["username"]) == true ? $_GET["username"] : "";
$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;

$User_Pagination->Username($Username);
$User_Pagination->Set_Page($Page);
$User_Pagination->Execute();
$TotalCount = $User_Pagination->Get_Total_Count();
$Users_Array = $User_Pagination->Get_Fetch();

function Draw_User($array = array()){
    foreach($array as $User){
        $UserID = $User["ID"];


        $x = new User_Data($UserID);
        $UserName = $x->Username();
        $Description = $x->About();
        $Avatar = $x->Avatar();
        $OnlineIcon = $x->Draw_Online();

        $z = new DateTime($x->Join_Date());
        $a = $z->format('F jS\,\ Y');


        echo '
        <div class="Search_User" onclick="GoToProfile('.$UserID.')">
            <div class="Part1"><img src="'.$Avatar.'" class="UserIMG AlignVertical" alt=""></div>
            <div class="Part2">
                <div class="AlignVertical">
                    <p class="Username">'.$OnlineIcon." ".$UserName.'</p>
                    <p class="Description">'.$Description.'</p>
                </div>
            </div>
            <div class="Part3">
                <p class="AlignVertical JoinDate">Joined '.$a.'</p>
            </div>
        </div>
        
        ';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "User_Explore"; $Page_Title = "Roblogs - Home"?>
<style>
    .Search_User:hover{
        cursor:pointer;
    }
</style>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>


<div class="Search_Container">
    <div class="Search_Window border">
        <div class="Search_Entry OldBlue">
            <div><p class="PageName">Search Users</p></div>
            <form action="" class="ExploreUser">
                <label for="Username">Find User: </label>
                <input type="text" name="username" id="Username">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="Search_Body"><?=$User_Pagination->Get_ThisPage_Count() > 0 ? Draw_User($Users_Array) : "No Results"; ?></div>
    </div>
    <div class="Pagination_Bottom"><?=$User_Pagination->Draw_Pagination()?></div>
</div>

</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="./Website/JS/GoToProfile.js"></script>
</body>
</html>