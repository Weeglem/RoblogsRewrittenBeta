<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Asset_Details"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<body>
<div class="container">
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Nav.php");?>

<div class="Asset_Container">
    <section class="MainFrame BlueBorder">
        <section class="Left ">
            <h3>Asset Name Placeholder</h3>
            <p class="FakeLabel">Details:</p>
            <div class="Asset_Details_Div">
                <ul class="Asset_Details">
                    <li>Creator: Weeglem</li>
                    <li>Created: 16-08-2024</li>
                    <li>Asset Type: Model</li>
                    <li>Reviews : 0</li>
                </ul>
                <figure class="AvatarsThumbnail_Medium">
                    <img src="../Website/avatars/4.png" class="AvatarsThumbnail_Medium" alt="">
                </figure>
            </div>
            <hr>
            <p class="FakeLabel">Description:</p>
            <p id="Description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatem nemo nostrum sed consectetur ab optio porro laboriosam adipisci dolor. Voluptas, facere reprehenderit. Iure eum aut, asperiores facere quia maxime. Repudiandae.</p>
            <p id="Description_See" class="See_More Link">See More</p>

        </section>
        <section class="Right">
            <figure class="Thumbnail">
                <img class="Thumbnail" src="../Website/thumbnails/models/114.png" alt="">
            </figure>
        </section>
    </section>

    <section class="Frame BlueBorder">
        <p class="FakeLabel">Asset Reviews (0)</p>
    </section>
</div>

</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>