<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();



?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Message_Form"; $Page_Title = "Message"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<body>
<div class="container">
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Nav.php");?>
<div class="Message_Container">
    <div class="Message_Flex border">
        <div class="Message_Details">
            <h1>Message</h1>
            <h3>Private Message</h3>
            <p class="Mimi"><strong>From:</strong> <a href="" class="Link">Weeglem</a>.</p>
            <p class="Mimi"><strong>Date:</strong> Sun Aug 4 20:58:55</p>
            <br>
            <img src="../Website/IMG/4.png" class="AvatarsThumbnail_Medium" alt="">
        </div>
        <div class="Message_Content">
            <form>
                <div class="Input_Container">
                    <label for="Username">Subject:</label>
                    <p class="Message-Title">Could you give a 2 sentence on roblogs?</p>
                </div>

                <div class="Input_Container">
                    <label for="Username">Message:</label>
                    <textarea name="" id="" cols="20" rows="20">Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, voluptatem necessitatibus facilis dolor, at quibusdam assumenda magnam non quis suscipit consequuntur nihil voluptas dignissimos rerum cum eius quod! Totam adipisci, rerum cumque tenetur voluptatum odio odit. Consequatur provident quo deserunt, dolores, animi mollitia similique necessitatibus incidunt laboriosam quos fuga porro officia explicabo autem tempore. Quisquam similique enim nisi earum, ullam fugiat iusto voluptatem fugit alias iure inventore cum asperiores temporibus ipsam impedit sapiente nostrum atque quas. Culpa labore nam pariatur repellat eum quo quae adipisci, odio sapiente nulla sit nostrum neque rem voluptate dolores. Voluptates quod laboriosam veniam accusamus esse.</textarea>
                </div>
                
                <div class="Actions">
                    <button type="button" onclick="history.go(-1)">Back</button>
                    <button type="button">Delete Message</button>
                    <button type="button">Reply Message</button>
                </div>
            </form>
        </div>
    </div>
</div>



</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>