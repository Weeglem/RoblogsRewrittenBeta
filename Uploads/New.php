<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Session();
$x->WebsiteCategories();

$Preload_ROBLOXTags = WebsiteCategories::GetRobloxVersions();
$Preload_CategoriesTAGS = WebsiteCategories::GetCategories();

function DrawCategories($Categories)
{
    foreach($Categories as $Category)
    {
        echo '<option value="'.$Category[0].'">'.$Category[1].'</option>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Studio_Form"; $Page_Title = "New Asset"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<div class="Uploader_Container">
    <section class="border FormContainer" id="ItemUpload_Div">
        <h1>Upload New Asset to Roblogs</h1>
        <br>
        <p>Make sure to follow Roblogs' community rules.</p>
        <noscript><strong>JAVASCRIPT IS REQUIRED</strong></noscript>
        <hr>
        <div class="Input_Container">
            <label for="AssetType">Asset Type:</label>
            <select name="Asset" id="SelectedUploadType">
                <option value="">Choose a Type</option>
                <option value="Game">Game</option>
                <option value="Model">Model</option>
                <option value="Decal">Decal </option>
                <option value="AssetPack">Local Assets pack </option>
            </select>
            <form id="ItemUploaderForm">

                <fieldset id="BasicInformation_Fieldset" style="display:none;">
                    <legend>Item Details:</legend>
                    
                    <div class="Input_Container" id="NameDiv" style="display:none;">
                        <label for="Name">Name:</label>
                        <input type="text" name="Name" id="Name" placeholder="Name" disabled="true">
                        <p class="Error" id="NameError"></p>
                    </div>

                    <div class="Input_Container" id="AboutDiv" style="display:none;">
                        <label for="About">Description:</label>
                        <textarea name="About" id="" cols="20" rows="8" disabled="true"></textarea>
                    </div>

                    <div class="Input_Container" id="RobloxDiv">
                        <label for="ROBLOX">ROBLOX client:</label>
                        <select name="ROBLOX" id="ROBLOX">
                            <?=DrawCategories($Preload_ROBLOXTags);?>
                        </select>
                        <p class="Error" id="RobloxError"></p>
                    </div>

                    <div class="Input_Container" id="CategoryDiv">
                        <label for="Category">Category:</label>
                        <select name="Category" id="Category">
                            <?=DrawCategories($Preload_CategoriesTAGS);?>
                        </select>
                        <p class="Error" id="CategoryError"></p>
                    </div>
                </fieldset>

                <fieldset id="RequiredFiles_Fieldset" style="display:none;">
                    <legend>Required Files: </legend>

                    <div class="Input_Container" id="Audio_Div" style="display:none;">  
                        <label for="File">Audio file:</label>
                        <input type="file" name="AudioFile" id="AudioFile" disabled="true">
                        <p class="Error" id="AudioFileError"></p>
                    </div>

                    <div class="Input_Container" id="ZipFile_Div" style="display:none;">
                        <label for="File">.ZIP file:</label>
                        <input type="file" name="ZipFile" id="ZipFile" disabled="true">
                        <p class="Error" id="ZipFileError"></p>
                    </div>  

                    <div class="Input_Container" id="ThumbnailFile_Div" style="display:none;">  
                        <label for="File">Thumbnail file:</label>
                        <input type="file" name="ThumbFile" id="ThumbFile" disabled="true">
                        <p class="Error" id="ThumbFileError"></p>
                    </div>

                    <div class="Input_Container" id="DecalFile_Div" style="display:none;">  
                        <label for="File">Decal file:</label>
                        <input type="file" name="DecalFile" id="DecalFile" disabled="true">
                        <p class="Error" id="DecalFileError"></p>
                    </div>
                    
                </fieldset>

                
                <fieldset id="ItemOptions_Fieldset" style="display:none;">
                    <legend>More Options: </legend>

                    <div class="LeftCheck" id="AllowComments_Div">  
                        <label class="InputInfo" for="File">Allow Comments:</label>
                        <input type="checkbox" name="AllowComments" id="AllowComments">
                    </div>

                    <div class="LeftCheck" id="PrivateAsset_Div">  
                        <label class="InputInfo" for="File">Make Private:</label>
                        <input type="checkbox" name="PrivateAsset" id="PrivateAsset">
                    </div>
                </fieldset>
                    
                <div class="Actions" id="SubmitButton_Div">
                    <button id="LeaveWindow" type="button">Cancel</button>
                    <button id="SubmitButton" type="submit" disabled="true" style="display:none;">Submit New Asset</button>
                </div>
                
            </form>
        </div>
    </section>

    <section class="border FormContainer" id="FinishedTask" style="display:none;">
        <h1>Upload Complete</h1>
        <p style="margin:10px 0;">Item Uploaded Successfuly to Roblogs.</p>
        <button id="LeaveWindow" type="button">Back To Uploads</button>
    </section>
</div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="./NewScript.js"></script>
</body>
</html>