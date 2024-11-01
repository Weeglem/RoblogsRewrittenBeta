<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Message_Form"; $Page_Title = "New Message"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<body>
<div class="container">
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Nav.php");?>
<div class="Message_Container">
    <div class="Message_Flex border">
        <div class="Message_Details">
            <h1>Message</h1>
            <h3>Send Message</h3>
            <p class="Mimi"><strong>From:</strong> Weeglem.</p>
        </div>
        <div class="Message_Content">
            <form>
                <div class="Input_Container">
                    <label for="Username">To Username:</label>
                    <input type="text" name="Username" id="Username" placeholder="Weeglem">
                </div>

                <div class="Input_Container">
                    <label for="Username">Subject:</label>
                    <input type="text" name="Username" id="Username" placeholder="Subject">
                </div>

                <div class="Input_Container">
                    <label for="Username">Message:</label>
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                </div>
                
                <div class="Actions">
                    <button type="button" onclick="history.go(-1)">Cancel</button>
                    <button type="button">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>



</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>