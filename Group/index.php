<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Group_Data();
$x->User_Data();

$ID = isset($_GET["id"]) ? $_GET["id"] : 1;

try{
    
    $GroupData = new Group_Data($ID);
    $GroupName = $GroupData->Name();
    $GroupDescription = $GroupData->Description();
    $GroupMembers = $GroupData->Members_Count();
    $GroupOwner = $GroupData->Creator();
    $GroupRanks = $GroupData->Ranks_Data();

    $UserData = new User_Data($GroupOwner);
    $Owner_Username = $UserData->Username();
}catch(Exception $e){
    exit($e->getMessage());
}

function DrawRanks($Array = array())
{
    echo '<option value="0">Users</option>';
    foreach($Array as $Rank)
    {
        $Name = $Rank["RankName"];
        $ID = $Rank["RankID"];

        echo '<option value="'.$ID.'">'.$Name.'</option>';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Group_Page"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<div class="Group_Container">
    <section>
        <h1><?=$GroupName?></h1>
        <section class="Group-Brief-Div border BlueBorder">
            <div class="Group-Details">
                <figure><img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="Group-Icon border greyborder" alt=""></figure>
                <ul>
                    <li><p class="FakeLabel">About Us:</p></li>
                    <li>Owner: <?=$Owner_Username?></li>
                    <li>Members: <?=$GroupMembers?></li>
                </ul>
            </div>
            <div class="Group-CTA">
                <ul>
                    <li>
                        <p class="FakeLabel">About Group</p>
                        <p id="Description"><?=$GroupDescription?></p>
                        <p id="Description_See" class="See_More Link">See More</p>
                    </li>
                    <li><!--<p class="GroupMessage">Test Message</p>--></li>
                    <li class="Group-Buttons">
                        <a href="#" id="JoinGroup" class="Action_Button">Join Group</a>
                    </li>
                </ul>
            </div>
        </section>

        <section class="Group-Members-Allies-Div">
            <div class="CardBody-Tags">
                <span><input type="button" class="CardBody-Selected" id="MemberCard_Button" value="Members"></span>
                <span><input type="button" id="AlliesCard_Button" value="Allies"></span>
            </div>
            <section id="Members_Tag" class="CardBody BlueBorder">
                <div class="CardEntry">
                    <p class="FakeLabel">Members</p>
                    <div class="CardNav">
                        <section class="NavLink-Pagination">
                            <p class="NavLink" id="Back-Button-Member"></p>
                            <p class="NavLink" id="Next-Button-Member"></p>
                        </section>
                        <select name="Rank" id="Rank">
                            <?=DrawRanks($GroupRanks)?>
                        </select>
                    </div>
                </div>
                <div class="CardBody_Flex" id="MembersDrawFlex"></div>
            </section>
            <section id="Allies_Tag" class="CardBody BlueBorder Hidden">
                <div class="EnemiesGroupDiv" id="AlliesGroupDiv">
                    <div class="CardEntry">
                        <h2 class="FakeLabel">Allies</h2>
                        <div class="CardNav">
                            <section class="NavLink-Pagination">
                                <p class="NavLink" id="Back-Button-Ally"></p>
                                <p class="NavLink" id="Next-Button-Ally"></p>
                            </section>
                        </div>
                    </div>
                    <div class="CardBody_Flex" id="AlliesDrawFlex">Loading...</div>
                </div>
                <hr id="Separator" class="Hidden">
                <div class="EnemiesGroupDiv Hidden" id="EnemiesGroupDiv">
                <div class="CardEntry">
                        <p class="FakeLabel">Enemies</p>
                        <div class="CardNav">
                            <section class="NavLink-Pagination">
                                <p class="NavLink" id="Back-Button-Enemy">Loading...</p>
                                <p class="NavLink" id="Next-Button-Enemy">Loading...</p>
                            </section>
                        </div>
                    </div>
                    <div class="CardBody_Flex" id="EnemiesDrawFlex"></div>
                </div>
            </section>
        </section>

        <section class="Group-Wall-Div border BlueBorder">
            <h2 class="FakeLabel">Wall</h2>
            
        </section>

    </section>
</div>
</div>
<input type="number" readonly="true" class="Hidden" style="display:none" value="<?=$ID;?>" name="GroupID" id="GroupID">
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="../Website/JS/Description.js"></script>
<script src="../Website/JS/ShareLink.js"></script>
<script src="./CardManager.js"></script>
<script src="./Allies.js"></script>
<script src="./Members.js"></script>
<script src="./GroupWall.js"></script>
</body>
</html>