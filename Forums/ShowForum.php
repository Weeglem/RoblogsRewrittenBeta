<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->User_Data();
$x->Pagination();
$x->Forum_PostData();
$x->Forum_GroupData();

$CategoryID = isset($_GET["id"]) ? $_GET["id"] : 4;  //12 LONG  //24 SHORT
$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;
$Name = isset($_GET["Name"]) == true ? $_GET["Name"] : null;

try{
    $ShowForumGroup_Pagination = new Advanced_Pagination();
    $ShowForumGroup_Pagination->Database("forums_posts");
    $ShowForumGroup_Pagination->Set_Page($Page);
    $ShowForumGroup_Pagination->Max_Items_Value(16);
    $ShowForumGroup_Pagination->Order("ID");
    $ShowForumGroup_Pagination->IsNull(array(["ParentID"]));
    $ShowForumGroup_Pagination->Select(array("ID"));
    $ShowForumGroup_Pagination->Equals(array(["CategoryID",$CategoryID],["Deleted",0]));
    $ShowForumGroup_Pagination->Like(array(["Name",$Name]));
    $ShowForumGroup_Pagination->Execute_Ex();

    $TotalArray = $ShowForumGroup_Pagination->Get_Fetch();
    $TotalCount = $ShowForumGroup_Pagination->Get_Total_Count();

    function DrawNewPost()
    {
        global $CategoryID;
        try{
            if(ForumGroup_Data::IsPublic($CategoryID) != true) throw new Exception("Not allowed");
            echo '
            <a href="NewPost.php?GroupID='.$CategoryID.'" class="NewTopicButton">
                <img src="../Website/IMG/Forums/newtopic.gif" alt="New Post">
            </a>';

         }catch(Exception){return;}
        
    }
}catch(Exception $ERR)
{
    var_dump($ERR);
}


function DrawTable($Array = array())
{
    foreach($Array as $Post)
    {
        $ID = $Post["ID"];
        $ThreadData = new Post_Data($ID);
        $Name = $ThreadData->Name();
        $Name = Website::MaxLength($Name,54);
        $Owner = $ThreadData->Owner();
        $Replies = $ThreadData->Replies();
        $LastReply = $ThreadData->LastReply();

        $OwnerID = User_DataController::GetID($Owner);

        if($LastReply != false)
        {
            $LastReplyDate = $LastReply["Date"];
            $LastReplyUser = $LastReply["Owner"];

            $LastComment = '
                <li><p class="SmallText CenterText"><strong>'.$LastReplyDate.'</strong></p></li>
                <li><p class="SmallText CenterText">by <a href="" class="LinkBlueUnderline">'.$LastReplyUser.'</a></p></li>
            ';
        }else{
            $LastComment = '
                <li><p class="SmallText CenterText">No Replies Yet</p></li>
            ';
        }


        echo '
        
        <tr class="ForumRow">
        <td class="BlueRow RowTitle">
            <span class="Float" class="TopicImage">
                <img class="TopicImage" src="../Website/IMG/Forums/topic-popular.gif" alt="">
            </span>
            <span class="Float">
                <a href="ShowPost.php?id='.$ID.'" class="LinkOrangeBlue SmallText WordBreak">'.$Name.'</a>
            </span>
        </td>
        <td class="GrayHighlight RowOwner "><a href="" class="LinkBlueUnderline SmallText">'.$Owner.'</a></td>
        <td class="GrayHighlight RowView "><p class="SmallText CenterText">'.$Replies.'</p></td>
        <td class="GrayHighlight RowReply "><p class="SmallText CenterText">0</p></td>
        <td class="GrayHighlight RowLast">
            <ul>'.$LastComment.'</ul>
        </td>
    </tr>

        ';
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
                ForumTree($CategoryID,"ShowForum");
            ?>
            <div class="Forum-Options">
                <div class="LeftFloat">
                    <?=DrawNewPost()?>
                </div>
                <form action="#" class="RightFloat">
                    <label for="Name">Search this forum:</label>
                    <input type="number" name="id" id="id" value="<?=$CategoryID?>" readonly="true" style="display:none;">
                    <input type="search" class="SameSize " value="<?=Website::EncodeString($Name)?>" name="Name" id="Name">
                    <button type="submit" class="SameSize SameSize2">Go</button>
                </form>
            </div>
        </div>

        <?php

            if($TotalCount == 0){
                echo "<div style='clear:both; margin-top:10px;'>";
                echo "<h3>No Results found</h3>";
                echo "</div>";
                include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php");
                exit();
            }


?>
        <table>
            <tr>
                <th><span>Thread</span></th>
                <th class="CenterText "><span>Started By</span></th>
                <th class="CenterText "><span>Replies</span></th>
                <th class="CenterText "><span>Views</span></th>
                <th class="CenterText"><span>Last Post</span></th>
            </tr>
            <?=DrawTable($TotalArray)?>
            <tr class="NoBorderCollapse">    
                <td class="trWhite NoBorderCollapse"></td>
                <td class="trWhite NoBorderCollapse"></td>
                <td class="trWhite NoBorderCollapse"></td>
                <td class="trWhite NoBorderCollapse"></td>
                <td class="trWhite NoBorderCollapse"></td>
            </tr>
        </table>
        <section class="PostPagination">
            <span class="ActualPageSpan  ">Page <?=$ShowForumGroup_Pagination->Get_Actual_Page()?> of <?=$ShowForumGroup_Pagination->Get_Total_Pages()?></span>
            <span class="PaginatorSpan ">Goto page: <?=$ShowForumGroup_Pagination->Draw_ForumPost_Pagination()?></span>
        </section>
    </div>
</div>

<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>