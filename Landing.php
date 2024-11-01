<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Session();

if(Session::Validate_Session() == true){exit(header("Location: Home.php"));}
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Landing"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>

<div class="Landing-Container">
    <div class="Landing-Main BlackBorder border Desktop">
        <section class="Landing-Login">
            <form action="#" id="RoblogsLogin_Form" method="post" class="border">
                <h3>Roblogs Login</h3>
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
                    <p class="NewACC">or</p>
                    <a class="NewACC Link" href="#">Create a New Account</a>
                </div>
            </form>
        </section>
    </div>
</div>

</div>
<script src="./Website/JS/LoginScript.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</main>
</html>