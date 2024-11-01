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

<!---Content Container Close-->
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>