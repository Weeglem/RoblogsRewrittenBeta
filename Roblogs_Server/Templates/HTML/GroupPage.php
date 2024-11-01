<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Group_Page"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<body>
<div class="container">
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Nav.php");?>
<div class="Group_Container">
    <section>
        <h1>Group Name Placeholder</h1>
        <section class="Group-Brief-Div border BlueBorder">
            <div class="Group-Details">
                <figure><img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="Group-Icon border greyborder" alt=""></figure>
                <ul>
                    <li><p class="FakeLabel">Group Name</p></li>
                    <li>Owner: Weeglem</li>
                    <li>Members: 100000</li>
                    <li>Power: 100000</li>
                </ul>
            </div>
            <div class="Group-CTA">
                <ul>
                    <li>
                        <p class="FakeLabel">About Group</p>
                        <p id="Description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque officia minima natus rerum facere minus quibusdam animi nemo reiciendis, veniam illum dolorem necessitatibus praesentium iusto velit similique, aliquam dolore ab? Quisquam expedita atque odio recusandae consequatur, vel, eius dolorum architecto error libero facilis! Dolore in hic quisquam minima libero vero quod voluptatum quos? Laudantium consequatur qui provident ab molestias cupiditate exercitationem at blanditiis aspernatur sit sapiente quidem sint officiis voluptatibus ipsa, corrupti ipsum perspiciatis in mollitia rem quasi impedit? Cumque ad, illo minima quae, tempore quos expedita harum ipsam, ipsa libero quod eum rem laborum? Asperiores pariatur minus natus culpa facere cupiditate blanditiis recusandae exercitationem. Facilis quo aperiam error, earum accusamus unde aut, ad officiis officia blanditiis delectus, harum cupiditate. Laudantium facere quisquam sunt, perferendis voluptas odit aut deleniti est libero laborum excepturi harum, ea magni doloremque impedit vero placeat? Veritatis aliquam omnis sequi, consequatur nesciunt rem dolor, facere at hic nostrum quidem, ipsum assumenda perferendis magnam eveniet quod quaerat magni. Dolores reprehenderit alias, nemo nam officiis expedita aliquid labore? Temporibus ducimus perferendis et, sit, modi sapiente doloremque esse at debitis ipsam omnis quo culpa nobis, perspiciatis nulla neque consectetur rerum ipsa nostrum dolorum libero. Rem provident beatae consectetur quibusdam!</p>
                        <p id="Description_See" class="See_More Link">See More</p>
                    </li>
                    <li><!--<p class="GroupMessage">Test Message</p>--></li>
                    <li class="Group-Buttons">
                        <a href="#" id="JoinGroup" class="Action_Button">Join Group</a>
                    </li>
                </ul>
            </div>
        </section>
        <section class="Group-Members-Allies-Div">
            <div class="CardBody-Tags">
                <span><input type="button" value="Members"></span>
                <span><input type="button" value="Allies"></span>
            </div>
            <section class="CardBody BlueBorder">
                
            </section>
        </section>
    </section>
</div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="../Website/JS/Description.js"></script>
<script src="../Website/JS/ShareLink.js"></script>
</body>
</html>