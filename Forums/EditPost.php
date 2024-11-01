<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->User_Data();
$x->Forum_PostData();
$x->Forum_GroupData();

$Error = null;
$ID = isset($_GET["PostID"]) ? $_GET["PostID"] : null;  //12 LONG  //24 SHORT

try{
    $ThreadData = new Post_Data($ID);
    if($ThreadData->Can_Edit() != true) throw new Exception("You dont own this post");
    $Name = $ThreadData->Name();
    $top = $ThreadData->Body();
    $Topic = Website::MaxLength($top,60);
    $Message = $ThreadData->Body();
    $Owner = $ThreadData->Owner();
    $Date = $ThreadData->Date();
    $Topic = $ThreadData->Body();
    $ThreadData->Is_Open();
    
}catch(Exception $err){$Error = $err->getMessage();}


?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Forums_Form"; $Page_Title = "Edit Post"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
    <div class="ForumContainer">
    
        <div class="ForumHeader">
            <?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/ForumTree.php"); 
            ForumTree($ID,"EditPost",false,"Edit"); ?>
        </div>

        <?php
            if($Error != null)
            {
                echo "<h3 style='margin:30px;'>$Error</h3>";
                include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php");
                return;
            }

        ?>
        
        <div class="ForumFormBody BlueNormal">
            <h1 class="BlueBG Title">Edit an existing post</h1>
            <div class="FormReply-Brief">
                <p>The message you are going to edit:</p>
                <p><strong>Posted by</strong> <a href="ShowPost.php?id=<?=$ID?>" class="BigText Link"><?=$Owner?></a> on <?=$Date?></p>
                <p><strong>Subject:</strong> <?=$Name?></p>
                <p><strong>Message:</strong> <?=$Topic?></p>
            </div>
            <form id="PostSubmit">
                <div class="FormPart">
                    <label for="Message">Message:</label>
                    <textarea name="Message" id="Message" cols="51" rows="10"><?=Website::EncodeString($Message);?></textarea>
                </div>
                <input type="number" name="ForumID" value="<?=$ID;?>" id="ForumID" readonly="true" style="display:none">
                <div class="FormPart ButtonPart">
                    <button id="Cancel" type="button">Cancel</button>
                    <button class="Preview" type="button">Preview ></button>
                </div>
                <div class="FormPart ButtonPart"><button id="SubmitButton" value="Edit">Edit</button></div>
            </form>
        </div>

    </div>
</div>

<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="NewPost.js"></script>
</body>
</html>