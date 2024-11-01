<?php
    session_start();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Session();
    $x->Database();
    $x->User_Data();
    $Error = null;

    if(Session::Validate_Session() != true){
        $Error = "You need to be logged To Roblogs";}

    $Username = isset($_GET["Username"]) == true ? $_GET["Username"] : "";

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Message_Form"; $Page_Title = "New Message"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>

<div class="Message_Container">
    <?php
    if(is_null($Error) != true)
    {
        exit("<h3>".$Error."</h3>");
    }
    ?>
    <div id="MessageForm_Window" class="Message_Flex border">
        <div class="Message_Details">
            <h1>Message</h1>
            <h3>Send Message</h3>
            <p class="Mimi"><strong>From:</strong> Weeglem.</p>
        </div>
        <div class="Message_Content">
            <form id="MessageBox">
            <div class="Input_Container">
                    <label for="Username">To User: <a target="_blank" class="Link" href="../Browse.php">(userlist)</a></label>
                    <input type="text" value="<?=Website::EncodeString($Username)?>" name="Username" id="Username" placeholder="Subject">
                </div>

                <div class="Input_Container">
                    <label for="Username">Subject:</label>
                    <input type="text" name="Subject" id="Subject" placeholder="Subject">
                </div>

                <div class="Input_Container">
                    <label for="Username">Message:</label>
                    <textarea name="Message" id="Message" cols="30" rows="10"></textarea>
                </div>
                
                <input type="number" readonly="true" style="display:none;" class="Hidden" name="id" id="id" value="<?=""?>">
                <div class="Actions">
                    <button type="button" onclick="history.go(-1)">Cancel</button>
                    <button type="button" id="NewMessage">Send Message</button>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div class="SuccessMessage BlackBorder SuccessMessage border" id="SuccessMessage">
            <h2>Message Sent Successfully!</h2>
            <p>Message Sent Successfuly</p>
            <button onclick="history.go(-1)">Go back</button>
        </div>
    </div>
    
</div>

</div>
<script src="./Scripts/NewMessage.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>