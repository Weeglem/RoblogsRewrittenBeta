<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();
    $x->Session();
    $x->WebsiteCategories();
    $x->Model_Data();
    $x->Decal_Data();
    $x->Game_Data();

    $ValidItems = array("game","model","decal");

    $ItemType = $_GET["type"];
    $ItemID = $_GET["id"];

    if(!in_array(strtolower($ItemType),$ValidItems)){exit("Invalid Type");}

    try{
        $x = $ItemType."_data";
        $ItemData = new $x($ItemID);
        $Name = $ItemData->Name();
        $Description = $ItemData->Description();
    }
    catch(Exception $err)
    {
        exit($err->getMessage());
    }

    $Preload_ROBLOXTags = WebsiteCategories::GetRobloxVersions();
    $Preload_CategoriesTAGS = WebsiteCategories::GetCategories();

    //LOAD FORM
    $DrawZip = $DrawThumbnail = $DrawDecal = $DrawAudio = $DrawRoblox = $DrawCategory = false;
    $SendToForm = "roblogs.net";
    $BaseSendTo = "http://$_SERVER[SERVER_NAME]/API/Uploads/Edit/";
    //DRAW ORDER
    switch($ItemType)
    {
        case "game":
            $DrawZip = true;
            $DrawThumbnail = true;
            $DrawRoblox = true;
            $DrawCategory = true;
        break;
        case "model":
            $DrawZip = true;
            $DrawThumbnail = true;
            $DrawRoblox = true;
            $DrawCategory = true;
        break;
        case "decal":
            $DrawDecal = true;
        break;
    }

    $SendToForm = $BaseSendTo."Item.php?id=".$ItemID."&type=".$ItemType;
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Studio_Form"; $Page_Title = "New Asset"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<div class="Uploader_Container">
    <section class="border FormContainer" id="ItemUpload_Div">
        <h1><?=$Name?></h1>
        <br>
        <p>Editing ROBLOGS Asset.</p>
        <noscript><strong>JAVASCRIPT IS REQUIRED</strong></noscript>
        <hr>
        <div class="Input_Container">
            <form id="ItemUploaderForm" action="<?=$SendToForm;?>">
                <fieldset id="BasicInformation_Fieldset">
                    <legend>Item Details:</legend>
                    
                    <div class="Input_Container" id="NameDiv">
                        <label for="Name">Name:</label>
                        <input type="text" name="Name" id="Name" value="<?=Website::EncodeString($Name);?>" placeholder="Name">
                        <p class="Error" id="NameError"></p>
                    </div>

                    <div class="Input_Container" id="AboutDiv">
                        <label for="About">Description:</label>
                        <textarea name="About" id="" cols="20" rows="8"><?=Website::EncodeString($Description);?></textarea>
                    </div>

                    <?php if($DrawRoblox == true){
                        //BLAME PHP FOR THIS SHIT
                        echo'
                            <div class="Input_Container" id="RobloxDiv">
                                <label for="ROBLOX">ROBLOX client:</label>
                                <select name="ROBLOX" id="ROBLOX">
                            ';
                                    
                            foreach($Preload_ROBLOXTags as $Category)
                            {
                                echo '<option value="'.$Category[0].'">'.$Category[1].'</option>';
                            } 
                                          
                            echo'
                                </select>
                                <p class="Error" id="RobloxError"></p>
                            </div>';
                    }?>

                    <?php if($DrawCategory == true)
                    {
                        echo'
                            <div class="Input_Container" id="CategoryDiv">
                                <label for="Category">Category:</label>
                            <select name="Category" id="Category">
                        ';

                        foreach($Preload_CategoriesTAGS as $Category)
                        {
                            echo '<option value="'.$Category[0].'">'.$Category[1].'</option>';
                        }

                        echo '
                            </select>
                                <p class="Error" id="CategoryError"></p>
                            </div>
                        ';
                    }?>
                    </fieldset>

                <fieldset id="RequiredFiles_Fieldset">
                    <legend>Required Files: </legend>

                    <?php if($DrawAudio == true){
                        echo'
                            <div class="Input_Container" id="Audio_Div">  
                                <label for="File">Audio file:</label>
                                <input type="file" name="AudioFile" id="AudioFile">
                                <p class="Error" id="AudioFileError"></p>
                            </div>
                        ';
                    };?>

                    <?php if($DrawZip == true){
                        echo '
                            <div class="Input_Container" id="ZipFile_Div">
                                <label for="File">.ZIP file:</label>
                                <input type="file" name="ZipFile" id="ZipFile" disabled="true">
                                <p class="Error" id="ZipFileError"></p>
                            </div>  
                        ';
                    }?>

                    <?php if($DrawThumbnail == true){
                        echo '
                            <div class="Input_Container" id="ThumbnailFile_Div">  
                                <label for="File">Thumbnail file:</label>
                                <input type="file" name="ThumbFile" id="ThumbFile" disabled="true">
                                <p class="Error" id="ThumbFileError"></p>
                            </div>
                        ';
                    }?>

                    <?php if($DrawDecal == true){
                        echo '
                            <div class="Input_Container" id="DecalFile_Div">  
                                <label for="File">Decal file:</label>
                                <input type="file" name="DecalFile" id="DecalFile" disabled="true">
                                <p class="Error" id="DecalFileError"></p>
                            </div> 
                        </fieldset>
                    ';}?>

                
                <fieldset id="ItemOptions_Fieldset">
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
                    <button id="SubmitButton" type="submit">Submit New Asset</button>
                </div>
                <input type="number" name="ItemID" id="ItemID" value="<?=$ItemID?>">
            </form>
        </div>
    </section>
    <section class="border FormContainer" id="FinishedTask" style="display:none;">
        <h1>Update Complete</h1>
        <p style="margin:10px 0;">Item Updated Successfuly.</p>
        <button id="LeaveWindow" type="button">Back</button>
    </section>
    <script src="./EditScript.js"></script>
</div>
