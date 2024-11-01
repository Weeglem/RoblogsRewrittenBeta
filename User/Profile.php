<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->User_Data();
$x->User_Friend();
$x->Game_Data();
$x->Model_Data();
$x->Decal_Data();

$UserID = isset($_GET["id"]) == true ? $_GET["id"] : null;
$UserData = new User_Data($UserID);

$User_ID = $UserData->ID();
$Username = $UserData->Username();
$About = $UserData->About();
$Join_Date = $UserData->Join_Date();
$Avatar = $UserData->Avatar("Big");


$LastSeen = $UserData->LastSeen();
$Draw_Online = $UserData->Draw_Online();
$IsOnline = $UserData->Is_Online();
$SendMessage = $UserData->Settings_CanIMessageYou();


$Games_Count = $UserData->Count_Games();
$Models_Count = $UserData->Count_Models();
$Decals_Count = $UserData->Count_Decals();
$Friends_Count = $UserData->Count_Friends();
$Badges_Count = $UserData->Count_Badges();
$Threads_Count = $UserData->Count_Threads();
$Replies_Count = $UserData->Count_Threads_Replies();

$Games_Showcase = $UserData->Games_Showcase();
$Models_Showcase = $UserData->Models_Showcase();
$Decals_Showcase = $UserData->Decals_Showcase();
$Friends_Showcase = $UserData->Friends_Showcase(8);
$Badges_Showcase = $UserData->Badges_Showcase();

$Friend = new User_Friend($User_ID);
$FriendFR = $Friend->Get_Friend_Status();

$OnlineBar = $IsOnline == true ? "<span class='Green' >[ Online ]</span>" : "<span>[Offline. Last Seen: ".$UserData->LastSeen(true)."]</span>";

function Draw_Game_Showcase($Array = array()){
    foreach($Array as $Game)
    {
        $ID = $Game["ID"];
        $GameData = new Game_Data($ID);
        $Name = $GameData->Name();
        $Description = $GameData->Description();
        $Thumbnail = $GameData->Thumbnail();

        echo "
        <div class='GameAccordion_Div'>
        <h3 class='Accordion-Games-Normal'>$Name</h3>
            <figure class='Accordion-Game-Display Accordion-Game-Display-Hide'>
                <a href='".WebsiteLinks::Game_Page($ID)."'>
                    <img src='".$Thumbnail."' class='GamesThumbnail_Big border' alt='".$Name." thumbnail'>
                </a>
                <div class='Game-Showcase-About'>$Description</div>
            </figure>
        </div>"
        ;
    }
}
 
function Draw_Friends($Array = array()){
    foreach($Array as $Friend){
        $fid = $Friend["FriendID"];
        $f = new User_Data($fid);
        $FriendName = $f->Username();
        $FriendAvatar = $f->Avatar();
        $FriendOnline = $f->Draw_Online();


        echo "
            <figure class='User_Friend_Div'>
                <a href='".WebsiteLinks::Profile_Page($fid)."'>
                    <img src='".$FriendAvatar."' class='AvatarsThumbnail_Small' alt='".$FriendName." avatar'>
                    <p class='User_Friend_Name'>$FriendOnline.$FriendName</p>
                </a>    
            </figure>
        ";
    }
}

function Draw_Badge($Array = array()){
    foreach($Array as $Badge){
        echo "<img src='../Website//IMG/Badge.png' class='Badge_Icon' alt='BadgeName' title='BadgeName'>";
    }
}

function Draw_Inventory(){
    echo "
        <div class='Asset-Item'>
            <img src='../Website/IMG/RoblogsCrossroadsThumbnail.png' class='Asset-Item-IMG border' alt=''>
            <p class='Asset-Item-Name'>Asset name display</p>
        </div>
    ";
}

function Draw_Button($Return){
    
    global $UserData;
    if($UserData->Settings_AllowsFriendRequests() == false)
    {
        return "<p>Closed Friend Requests</p>";
    }

    switch($Return)
    {
        case "Friends":
            return '<a href="#" class="Button"><strong>Friends :D</strong></a>';
        break;
        case "Pending":
            return '<a href="#" class="Button">Friend request Pending</a>';
        break;
        case "Got":
            return '<a href="#" class="Button"><strong>New Friend Request</strong></a>';
        break;
        default:
         return '<a href="#" class="Button">Send Friend Request</a>';
        break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Profile_Page"; $Page_Title = "$Username"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>

<div class="User_Profile_Container">
    <div class="Left_Side_Div">
        <div class="User_Info_Div border BrightOldBlue">
            <h1 class="User_Name"><?=$Draw_Online." ".$Username?></h1>
            <p class="Last_Seen"><?=$OnlineBar?></p>
            <!--<p class="User_Link Link"><?=WebsiteLinks::Profile_Page($User_ID)?></p>-->
            <img draggable="false" src="<?=$Avatar?>" alt="" class="AvatarsThumbnail_Big">
            <p class="User_About"><?=$About?></p>
            <div class="User_Action_Buttons">
                <?=Session::Get_ID() != $User_ID ? Draw_Button($FriendFR) : "";?>
                <?=$SendMessage == false ? '<p class="User-DontAnnoyMe">Messages from friends only</p>' : '<a href="../Inbox/NewPrivate.php?Username='.$Username.'" class="Button">Send Message</a>';?>
            </div>
            
        </div> 
        
        <div class="User_Statics_Div border">
            <p id="UserSocial_Card_Invoke" class="Showcase Blue"><?=$Username?> Details <span id="Icon">(+)</span></p>
            <div class="User_Social_Info UserSocial_Off" id="UserSocial_Card">
                <p class="UserSocial_Info"><strong>Join Date:</strong>  <?=$Join_Date;?></p>
                <p class="UserSocial_Info"><strong>Uploaded Games:</strong> <?=$Games_Count;?></p>  
                <p class="UserSocial_Info"><strong>Uploaded Models:</strong> <?=$Models_Count;?></p>
                <p class="UserSocial_Info"><strong>Uploaded Decals:</strong> <?=$Decals_Count;?></p>

                <hr>
                <p class="UserSocial_Info"><strong>Friends:</strong> <?=$Friends_Count?></p>
                <p class="UserSocial_Info"><strong>Badges:</strong> <?=$Badges_Count?></p>
                <hr>
                
                <p class="UserSocial_Info"><strong>Forums Threads:</strong> <?=$Threads_Count;?></p>
                <p class="UserSocial_Info"><strong>Forum Replies:</strong> <?=$Replies_Count;?></p>
            </div>
        </div>
<!--
        <div class="User_Statics_Div border <?=$Friends_Count == 0 ? "Hidden" : "" ?>">
            <p class="Showcase Blue"><?=$Username?> Best Friends</p>
            <div class="User_Statics_Flex">
                <?=$Friends_Count > 0 ? Draw_Friends($Friends_Showcase) : "No friends found"?>
            </div>
        </div>
-->


        <div class="User_Statics_Div border <?=$Badges_Count == 0 ? "Hidden" : "" ?>">
            <p class="Showcase Blue"><?=$Username?> Badges</p>
            <div class="User_Statics_Flex">
                <?=$Badges_Count > 0 ? Draw_Badge($Badges_Showcase) : "No badges found"?>
            </div> 
        </div>
    </div>
    <div class="Right_Side_Div">
        
        <div class="Games-Showcase border <?=$Games_Count == 0 ? "Hidden" : "" ?>">
            <p class="Showcase Blue">Lastest Games</p>
            <div id="games-accordion">
                <?=$Games_Count > 0 ? Draw_Game_Showcase($Games_Showcase) : "No games found"?>
            </div>
        </div>


        <div class="Assets-Showcase-Div border" id="Accordion">
            <p class="Showcase Blue" id="AccordionToggle">Content Gallery <span id="Icon">(-)</span></p>
            <div class="Assets-Padding Card-Display" id="AccordionBody">
                <div class="Inventory-Actions">
                    <select name="AssetType" id="AssetType">
                        <option value="Models">Models</option>
                        <option value="Decals">Decals</option>
                    </select>
                </div>
                <div class="Assets-Showcase-Flex" id="Assets-Flex-Showcase">Loading...</div>
                <section class="Assets_Pagination JSPagination">
                    <p id="Back-Button-Assets" class="NavLink"></p>
                    <p id="Next-Button-Assets" class="NavLink"></p>
                </section>
            </div>
        </div>


    </div>
</div>
</div>

<input style="display:none;" readonly="true" class="Hidden" type="number" value="<?=$User_ID?>" name="UserID" id="UserID">
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="./Profile-Inventory.js"></script>
<script src="./Profile-Games-Accordion.js"></script>
<script src="./Profile-SocialCard.js"></script>
<script src="./Accordion.js"></script>
</body>
</html>