<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Home"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<!---Content Container Start-->
<form id="RoblogsLogin_Form" method="post" class="border" style=" width:400px; margin:10px auto; padding:8px; border:1px solid black;">
    <h2>Roblogs Login</h2>
        <div class="Input_Container">
            <label for="User">Username:</label>
            <input type="text" name="Username" id="Username">
        </div>
        <div class="Input_Container">
            <label for="User">Password:</label>
            <input type="password" name="Password" id="Password">
        </div>
        <p id="LoginError" class="Error"></p>
        <div class="Actions">
            <button type="submit" id="RoblogsLogin_Submit">Login</button><br>
    </div>
</form>
<!---Content Container Close-->
<script src="../Website/JS/LoginScript.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>