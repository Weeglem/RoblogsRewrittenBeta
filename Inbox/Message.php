<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->User_Data();
$x->Message_Data();

$ID = isset($_GET["id"]) == true ? $_GET["id"] : 0;

try{
    $Message_Data = new Message_Data($ID);

    $Subject = $Message_Data->Subject();
    $Body = $Message_Data->Message();
    $From = $Message_Data->From();
    $From_Username = $Message_Data->From_Username();
    $Date = $Message_Data->Date();

    $UserData = new User_Data($From);
    $UserAvatar = $UserData->Avatar();
}catch(Exception $err)
{
    exit($err->getMessage());
}



?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Message_Form"; $Page_Title = Website::EncodeString($Subject) ." - ".Website::EncodeString($From_Username)?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<div class="Message_Container">
    <div class="Message_Flex border">
        <div class="Message_Details">
            <h1>Message</h1>
            <h3>Private Message</h3>
            <p class="Mimi"><strong>From:</strong> <a href="<?=$From?>" class="Link"><?=$From_Username?></a>.</p>
            <p class="Mimi"><strong>Date:</strong> <?=$Date?></p>
            <br>
            <img src="<?=$UserAvatar?>" class="AvatarsThumbnail_Medium" alt="">
        </div>
        <div class="Message_Content">
            <form>
                <div class="Input_Container">
                    <label for="Username">Subject:</label>
                    <p class="Message-Title"><?=$Subject?></p>
                </div>

                <div class="Input_Container">
                    <label for="Username">Message:</label>
                    <textarea name="" id="" cols="20" rows="20"><?=$Body?></textarea>
                </div>
                
                <div class="Actions">
                    <button type="button" onclick="history.go(-1)">Back</button>
                    
                    <button type="button" onclick="DeleteMessagesMes(this.value)" id="DeleteMessage" name="check_list[]" value="<?=$ID?>">Delete Message</button>

                    <button type="button">Reply Message</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="./Scripts/Message_DeleteMessage.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>