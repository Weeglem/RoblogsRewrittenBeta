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

$ID = isset($_GET["GroupID"]) ? $_GET["GroupID"] : 4;  //12 LONG  //24 SHORT
try{
    ForumGroup_Data::IsPublic($ID);
}catch(Exception $e)
{
    $Error = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Forums_Form"; $Page_Title = "New Post"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
    <div class="ForumContainer">
    
        <div class="ForumHeader">
            <?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/ForumTree.php"); ForumTree($ID,"ShowForum",true,"New"); ?>
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
            <h1 class="BlueBG Title">Post a new message</h1>
            <form id="PostSubmit">
            <div class="FormPart">
                    <label for="Subject">Author:</label>
                    <span class="BigText Link">Weeglem</span>
                </div>
                <div class="FormPart">
                    <label for="Subject">Subject:</label>
                    <input type="text" name="Subject" id="Subject">
                </div>
                <div class="FormPart">
                    <label for="Message">Message:</label>
                    <textarea name="Message" id="Message" cols="51" rows="10"></textarea>
                </div>
                <input type="number" name="ForumID" value="<?=$ID;?>" id="ForumID" readonly="true" style="display:none">
                <div class="FormPart ButtonPart">
                    <button id="Cancel" type="button">Cancel</button>
                    <button class="Preview" type="button">Preview ></button>
                </div>
                <div class="FormPart ButtonPart"><button id="SubmitButton" value="New">Create</button></div>
            </form>
        </div>

    </div>
</div>

<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="NewPost.js"></script>
</body>
</html>