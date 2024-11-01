<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->User_Data();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Classes/Forum/GroupData.php");

$CategoryID = isset($_GET["id"]) ? $_GET["id"] : false; 
$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;

$GroupsArray = ForumGroup_Data::Get($CategoryID);

function DrawTable($Array = array())
{
    foreach($Array as $Groups)
    {
        $Name = $Groups["Name"];
        $ID = $Groups["ID"];
        
        echo '
            <tr class="NoBorderCollapse">    
                <td class="trWhite LargeRow NoBorderCollapse"><a href="ShowForumGroup.php?id='.$ID.'" class="SmallText LinkOrangeBlue">'.$Name.'</a></td>
                <td class="trWhite MediumRow NoBorderCollapse"></td>
                <td class="trWhite MediumRow NoBorderCollapse"></td>
                <td class="trWhite LargeRow NoBorderCollapse"></td>
            </tr>
        ';
        
        foreach($Groups["Content"] as $Thread)
        {
            $Name = $Thread["ForumName"];
            $About = $Thread["ForumAbout"];
            $Posts = $Thread["Posts"];
            $Replies = $Thread["Replies"];
            $ID = $Thread["ForumID"];

            echo '
                <tr class="ForumRow">
                    <td class="BlueRow ClickForum LargeRow">
                        <span>
                            <img src="../Website/IMG/Forums/topic-popular.gif" alt="" style="float:left;">
                        </span>
                        <span style="margin-left:7px;">
                            <a href="ShowForum.php?id='.$ID.'" class=" LinkOrangeBlue BigText">'.$Name.'</a>
                            <p class="SmallText">'.$About.'</p>
                        </span>
                    </td>
                    <td class="GrayHighlight MediumRow"><p class="SmallText CenterText">'.$Posts.'</p></td>
                    <td class="GrayHighlight MediumRow"><p class="SmallText CenterText">'.$Replies.'</p></td>
                    <td class="GrayHighlight LastRow">
                        <ul>
                            <li><p class="SmallText CenterText"><strong>Today @ 07:57 PM</strong></p></li>
                            <li><p class="SmallText CenterText">by <a href="" class="LinkBlueUnderline">reesemcblox</a></p></li>
                        </ul>
                    </td>
                </tr>
            ';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Forums_ShowForum"; $Page_Title = "Forums"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>

<div class="ForumContainer">
    <div class="ForumHeader">
        <?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/ForumTree.php");
                ForumTree($CategoryID,"ShowForumGroup");   
        ?>
        <p class="BigText"><strong>Current time:</strong> <?=date("M j, g:i a")?></p>
    </div>
    <table>
        <tr>
            <th class="CenterText"><span>Forum</span></th>
            <th class="CenterText"><span>Threads</span></th>
            <th class="CenterText"><span>Posts</span></th>
            <th class="CenterText"><span>Last Post</span></th>
        </tr>
        <?=DrawTable($GroupsArray)?>   
    </table>
</div>

</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>