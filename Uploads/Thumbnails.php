<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Game_Data();
$x->UserImages_Data();

$ID = isset($_GET["id"]) ? $_GET["id"] : 1;
$Type = isset($_GET["Type"]) ? $_GET["Type"] : "Model";

$Asset_Data = new Game_Data($ID);
$Asset_UsersThumbs = $Asset_Data->Get_Thumbnails();

function DrawThumbs_ControlPanel($Array = array())
{
        foreach($Array as $Thumbnail)
        {
            $ThumbID = $Thumbnail["ID"];
            $ImageData = new UserImages_Data($ThumbID);
            $IMG = $ImageData->Thumbnail("Big");
            $NAME = $ImageData->Get_Name();
    
            echo '
                <tr>
                    <td>
                        <img class="WorkshopThumbnail_Normal" src="'.$IMG.'" alt="'.$NAME.'">
                    </td>
                    <td>
                        <p><strong>Name: </strong>'.$NAME.'</p>
                        <p><strong>Description: </strong> </p>
                    </td>

                    <td>
                    <form id="RemoveThumbnail">
                        <input type="number" readonly="true" style="display:none" value="'.$ThumbID.'" id="AssetID" name="AssetID"/>
                        <button type="submit" value="Remove">Remove Image</button>
                    </form>
                    </td>
                <tr>
            ';
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Studio_Form"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<!---Content Container Start-->
<div class="Images_Control_Panel">
    <form action="#" id="UploadThumbnail_Form" class="BlackBorder border padding">
        <h3>New Thumbnail</h3>
        <p class="Tip">Upload an Image you want to add to your Item</p>
        <input type="file" name="DecalFile" id="DecalFile">
        <button type="submit">Add Thumbnail</button>
    </form>
    <table id="EditThumbnails_Table">
        <tr>
            <th>Image</th>
            <th>Details</th>
            <th>Manage</th>
        </tr>
        <?=DrawThumbs_ControlPanel($Asset_UsersThumbs);?>
    </table>
    
</div>
<!---Content Container Close-->
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="./ThumbnailHandler.js"></script>
</body>
</html>