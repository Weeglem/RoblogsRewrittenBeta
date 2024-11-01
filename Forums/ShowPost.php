<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->User_Data();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Classes/Forum/NewPostData.php");
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Classes/Pagination/Pagination.php");
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Classes/Pagination/Forum/ThreadReplies.php");

$ThreadID = $ID = isset($_GET["id"]) ? $_GET["id"] : 24;  //12 LONG  //24 SHORT
$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;

$ThreadData = new Post_Data($ThreadID);
$Name = $ThreadData->Name();
$Topic = $ThreadData->Body();
$Owner = $ThreadData->Owner();
$Date = $ThreadData->Date();

$OwnerID = User_DataController::GetID($Owner);

$UserData = new User_Data($OwnerID);
$UserName = $UserData->Username();
$JoinDate = $UserData->Join_Date();
$Avatar = $UserData->Avatar();
$OnlineIcon = $UserData->Draw_Online();
$TotalPosts = $UserData->Count_ThreadsTotal();

$ThreadReplies_Pagination = new ThreadReplies_Pagination($ThreadID);
$ThreadReplies_Pagination->Max_Items_Value(12);
$ThreadReplies_Pagination->Set_Page($Page);
$ThreadReplies_Pagination->Execute();

$TotalCount = $ThreadReplies_Pagination->Get_Total_Count();
$TotalArray = $ThreadReplies_Pagination->Get_Results();

//TODO
//USE A SAME FUNCTION FOR COMMENTS AND MAIN POST???


function DrawComments($Array = array()){
    for($i = 0; $i < count($Array); $i++)
    {
        $ID = $Array[$i]["ID"];
        $ThreadData = new Post_Data($ID);
        $Name = $ThreadData->Name();
        $Topic = $ThreadData->Body();
        $Owner = $ThreadData->Owner();
        $Date = $ThreadData->Date();
        $BG = $i % 2 == 1 ? "BlueNormal" : "BlueAlternate";
        $OwnerID = User_DataController::GetID($Owner);

        $UserData = new User_Data($OwnerID);
        $UserName = $UserData->Username();
        $JoinDate = $UserData->Join_Date();
        $TotalPosts = $UserData->Count_ThreadsTotal();
        $Avatar = $UserData->Avatar();
        $OnlineIcon = $UserData->Draw_Online();

        echo '
        <tr class="ForumRow '.$BG.'">
            <td class="Left">
                <ul>
                    <li>
                        <a href="'.WebsiteLinks::Profile_Page($OwnerID).'" class="ForumRow-Author Link">'.$OnlineIcon.' '.$Owner.'
                            <br><img src="'.$Avatar.'" class="AvatarsThumbnail_Medium Desktop" alt="'.$Owner.'">
                        </a>
                    </li>
                    <li><p class="ForumRow-Details"><strong>Joined:</strong> '.$JoinDate.'</p></li>
                    <li><p class="ForumRow-Details"><strong>Total Posts:</strong> '.$TotalPosts.'</p></li>
                </ul>
            </td>
            <td class="Right FixCenter">
                <ul class="ForumRow-Brief">
                    <li><p class="ForumRow-Details"><strong> '.$Name.'</strong></p></li>
                    <li><p class="ForumRow-Details">Posted: '.$Date.'</p></li>
                </ul>
                <ul class="ForumText-Body">
                    <li><p class="BigText">'.$Topic.'</p></li>
                </ul>
                <div class="ForumButtons-Action">

                    <span><a href="./NewReply.php?PostID='.$ID.'"><img src="../Website/IMG/Forums/newpost.gif" alt=""></a></span>
                    <span><a href="./EditPost.php?PostID='.$ID.'"><img src="../Website/IMG/Forums/editpost.gif" alt=""></a></span>

                    <span><a href="#" class="Link Report">[Report Abuse]</a></span>
                </div>
            </td>
        </tr>
        ';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Forums_ShowPost"; $Page_Title = "$Name"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<div class="ForumContainer">
    <div class="ForumHeader">
        <?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/ForumTree.php");
            ForumTree($ThreadID,"ShowPost");
        ?>
        <div class="Forum-Options">
                <form id="FollowThread" class="LeftFloat FollowThread">
                    
                    <input type="checkbox" name="FollowThread" <?=Session::FollowingThread($ThreadID) == true ? "checked" : ""; ?> id="FollowThread_Trigger">
                    <input type="number" name="Threadid" id="Threadid" value="<?=$ThreadID?>" readonly="true" style="display:none;">
                    <label for="Name">Track this thread</label>
        
                </form>
            </div>
    </div>
    
    <table>
        <tr>
            <th class="Left"><span>Author</span></th>
            <th class="Right"><span>Thread: <?=$Name?></span></th>
        </tr>
        <tr class="ForumRow BlueNormal">
            <td class="Left">
                <ul>
                    <li>
                        <a href="<?=WebsiteLinks::Profile_Page($OwnerID)?>" class="ForumRow-Author Link"><?=$OnlineIcon." ".$Owner?>
                        <img src="<?=$Avatar?>" class="AvatarsThumbnail_Medium Desktop" alt="<?=$Owner?>">
                        </a>
                    </li>
                    <li><p class="ForumRow-Details"><strong>Joined:</strong> <?=$JoinDate?></p></li>
                    <li><p class="ForumRow-Details"><strong>Total Posts:</strong> <?=$TotalPosts?></p></li>
                </ul>
            </td>
            <td class="Right FixCenter">
                <ul class="ForumRow-Brief">
                    <li><p class="ForumRow-Details"><strong><?=$Name?></strong></p></li>
                    <li><p class="ForumRow-Details">Posted: <?=$Date;?></p></li>
                </ul>
                <ul class="ForumText-Body">
                    <li><p class="BigText"><?=$Topic?></p></li>
                </ul>
                <div class="ForumButtons-Action">

                    <span><a href="./NewReply.php?PostID=<?=$ID?>"><img src="../Website/IMG/Forums/newpost.gif" alt=""></a></span>
                    <span><a href="./EditPost.php?PostID=<?=$ID?>"><img src="../Website/IMG/Forums/editpost.gif" alt=""></a></span>

                    <span><a href="#" class="Link Report">[Report Abuse]</a></span>
                </div>

            </td>
        </tr>
        <?=DrawComments($TotalArray)?>
        <tr class="NoBorderCollapse">    
                <td class="trWhite NoBorderCollapse"></td>
                <td class="trWhite NoBorderCollapse"></td>
            </tr>
    </table>

    <section class="PostPagination">
        <span class="ActualPageSpan Desktop">Page <?=$ThreadReplies_Pagination->Get_Actual_Page()?> of <?=$ThreadReplies_Pagination->Get_Total_Pages()?></span>
        <span class="PaginatorSpan">Goto page: <?=$ThreadReplies_Pagination->Draw_ForumPost_Pagination()?></span>
    </section>
</div>
</div>

<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="./FollowThread.js"></script>
</body>
</html>