<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Profile_Page"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<head>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
</head>
<body>
<div class="container">
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Nav.php");?>
<div class="User_Profile_Container">
    <div class="Left_Side_Div">
        <div class="User_Info_Div border BrightOldBlue">
            <h1 class="User_Name">Username</h1>
            <p class="Last_Seen">[Offline. Last Seen: August 4, 5:51 am]</p>
            <p class="User_Link Link">https://roblogs.net/profile.php?id=2</p>
            <img src="../Website//IMG//4.png" alt="" class="User_IMG">
            <p class="User_About">Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio quia laboriosam iure nulla deleniti. Sunt molestias dolore quis rem laborum repudiandae aspernatur, ipsa quam qui! Dolores iure ducimus nihil architecto.</p>
            <div class="User_Action_Buttons"><a href="#" class="Button">Pending friend request</a><a href="#" class="Button">Send Message</a></div>
            <p class="User-DontAnnoyMe">Messaging Disabled</p>
        </div> 
        
        <div class="User_Statics_Div border">
            <p class="Showcase Blue">Username Details </p>
            <div class="User_Social_Info">
                <p class="UserSocial_Info"><strong>Join Date:</strong>  06-08-2024</p>
                <p class="UserSocial_Info"><strong>Added Friends:</strong> 0</p>
                <p class="UserSocial_Info"><strong>Uploaded Models:</strong> 0</p>
                <p class="UserSocial_Info"><strong>Uploaded Decals:</strong> 0</p>
                <p class="UserSocial_Info"><strong>Uploaded Games:</strong> 0</p>  
            </div>
        </div>



        <div class="User_Statics_Div border">
            <p class="Showcase Blue">Username Friends</p>
            <div class="User_Statics_Flex">
                <div class="User_Friend_Div">
                    <img src="../Website//IMG/4.png" class="User_Friend_IMG" alt="">
                    <p class="User_Friend_Name">Weeglem</p>
                </div>
                <div class="User_Friend_Div">
                    <img src="../Website//IMG/4.png" class="User_Friend_IMG" alt="">
                    <p class="User_Friend_Name">Weeglem</p>
                </div>
                <div class="User_Friend_Div">
                    <img src="../Website//IMG/4.png" class="User_Friend_IMG" alt="">
                    <p class="User_Friend_Name">Weeglem</p>
                </div>
                <div class="User_Friend_Div">
                    <img src="../Website//IMG/4.png" class="User_Friend_IMG" alt="">
                    <p class="User_Friend_Name">Weeglem</p>
                </div>
                <div class="User_Friend_Div">
                    <img src="../Website//IMG/4.png" class="User_Friend_IMG" alt="">
                    <p class="User_Friend_Name">Weeglem</p>
                </div>
                <div class="User_Friend_Div">
                    <img src="../Website//IMG/4.png" class="User_Friend_IMG" alt="">
                    <p class="User_Friend_Name">Weeglem</p>
                </div>
            </div>
        </div>

        <div class="User_Statics_Div border">
            <p class="Showcase Blue">Username Badges</p>
            <div class="User_Statics_Flex">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
                <img src="../Website//IMG/Badge.png" class="Badge_Icon" alt="BadgeName" title="BadgeName">
            </div> 
        </div>
    
    
    
    
    
    
    </div>
    <div class="Right_Side_Div">
        <div class="Games-Showcase border">
            <p class="Showcase Blue">Lastest Games</p>
            <div id="games-accordion">
                <h3>test</h3>
                <div>
                    <div class="Accordion-Game-Display">
                        <img src="../Website//IMG//RoblogsCrossroadsThumbnail.png" class="Game-Showcase-Thumb border">
                        <div class="Game-Showcase-About">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam inventore provident voluptatum voluptatem ipsa! Voluptate vitae unde distinctio provident vel ipsam. Voluptate, quo dolor asperiores quisquam a ipsa eligendi tenetur. Modi esse fugit non earum voluptate, fuga consequuntur, eius sequi perspiciatis natus facere officia nesciunt enim facilis ea voluptatibus corporis nihil laboriosam sit quia voluptas labore accusantium in? Eum unde fugiat repellendus, incidunt, amet quae nam earum aspernatur odit dolorem excepturi asperiores provident explicabo hic blanditiis cupiditate! Fugiat fugit facere facilis iusto vitae maxime. Laboriosam veritatis, reprehenderit quod laudantium nesciunt est omnis minima rerum a officia! Maxime laudantium sunt perferendis?</div>
                    </div>
                </div>
                <h3>test</h3>
                <div>
                    <div class="Accordion-Game-Display">
                        <img src="../Website//IMG//RoblogsCrossroadsThumbnail.png" class="Game-Showcase-Thumb border">
                        <div class="Game-Showcase-About">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam inventore provident voluptatum voluptatem ipsa! Voluptate vitae unde distinctio provident vel ipsam. Voluptate, quo dolor asperiores quisquam a ipsa eligendi tenetur. Modi esse fugit non earum voluptate, fuga consequuntur, eius sequi perspiciatis natus facere officia nesciunt enim facilis ea voluptatibus corporis nihil laboriosam sit quia voluptas labore accusantium in? Eum unde fugiat repellendus, incidunt, amet quae nam earum aspernatur odit dolorem excepturi asperiores provident explicabo hic blanditiis cupiditate! Fugiat fugit facere facilis iusto vitae maxime. Laboriosam veritatis, reprehenderit quod laudantium nesciunt est omnis minima rerum a officia! Maxime laudantium sunt perferendis?</div>
                    </div>
                </div>
                <h3>test</h3>
                <div>
                    <div class="Accordion-Game-Display">
                        <img src="../Website//IMG//RoblogsCrossroadsThumbnail.png" class="Game-Showcase-Thumb border">
                        <div class="Game-Showcase-About">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam inventore provident voluptatum voluptatem ipsa! Voluptate vitae unde distinctio provident vel ipsam. Voluptate, quo dolor asperiores quisquam a ipsa eligendi tenetur. Modi esse fugit non earum voluptate, fuga consequuntur, eius sequi perspiciatis natus facere officia nesciunt enim facilis ea voluptatibus corporis nihil laboriosam sit quia voluptas labore accusantium in? Eum unde fugiat repellendus, incidunt, amet quae nam earum aspernatur odit dolorem excepturi asperiores provident explicabo hic blanditiis cupiditate! Fugiat fugit facere facilis iusto vitae maxime. Laboriosam veritatis, reprehenderit quod laudantium nesciunt est omnis minima rerum a officia! Maxime laudantium sunt perferendis?</div>
                    </div>
                </div>
                <h3>test</h3>
                <div>
                    <div class="Accordion-Game-Display">
                        <img src="../Website//IMG//RoblogsCrossroadsThumbnail.png" class="Game-Showcase-Thumb border">
                        <div class="Game-Showcase-About">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam inventore provident voluptatum voluptatem ipsa! Voluptate vitae unde distinctio provident vel ipsam. Voluptate, quo dolor asperiores quisquam a ipsa eligendi tenetur. Modi esse fugit non earum voluptate, fuga consequuntur, eius sequi perspiciatis natus facere officia nesciunt enim facilis ea voluptatibus corporis nihil laboriosam sit quia voluptas labore accusantium in? Eum unde fugiat repellendus, incidunt, amet quae nam earum aspernatur odit dolorem excepturi asperiores provident explicabo hic blanditiis cupiditate! Fugiat fugit facere facilis iusto vitae maxime. Laboriosam veritatis, reprehenderit quod laudantium nesciunt est omnis minima rerum a officia! Maxime laudantium sunt perferendis?</div>
                    </div>
                </div>
                <h3>test</h3>
                <div>
                    <div class="Accordion-Game-Display">
                        <img src="../Website//IMG//RoblogsCrossroadsThumbnail.png" class="Game-Showcase-Thumb border">
                        <div class="Game-Showcase-About">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam inventore provident voluptatum voluptatem ipsa! Voluptate vitae unde distinctio provident vel ipsam. Voluptate, quo dolor asperiores quisquam a ipsa eligendi tenetur. Modi esse fugit non earum voluptate, fuga consequuntur, eius sequi perspiciatis natus facere officia nesciunt enim facilis ea voluptatibus corporis nihil laboriosam sit quia voluptas labore accusantium in? Eum unde fugiat repellendus, incidunt, amet quae nam earum aspernatur odit dolorem excepturi asperiores provident explicabo hic blanditiis cupiditate! Fugiat fugit facere facilis iusto vitae maxime. Laboriosam veritatis, reprehenderit quod laudantium nesciunt est omnis minima rerum a officia! Maxime laudantium sunt perferendis?</div>
                    </div>
                </div>
                <h3>test</h3>
                <div>
                    <div class="Accordion-Game-Display">
                        <img src="../Website//IMG//RoblogsCrossroadsThumbnail.png" class="Game-Showcase-Thumb border">
                        <div class="Game-Showcase-About">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam inventore provident voluptatum voluptatem ipsa! Voluptate vitae unde distinctio provident vel ipsam. Voluptate, quo dolor asperiores quisquam a ipsa eligendi tenetur. Modi esse fugit non earum voluptate, fuga consequuntur, eius sequi perspiciatis natus facere officia nesciunt enim facilis ea voluptatibus corporis nihil laboriosam sit quia voluptas labore accusantium in? Eum unde fugiat repellendus, incidunt, amet quae nam earum aspernatur odit dolorem excepturi asperiores provident explicabo hic blanditiis cupiditate! Fugiat fugit facere facilis iusto vitae maxime. Laboriosam veritatis, reprehenderit quod laudantium nesciunt est omnis minima rerum a officia! Maxime laudantium sunt perferendis?</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="Assets-Showcase-Div border">
            <p class="Showcase Blue">Content Gallery</p>
            <div class="Inventory-Actions"><select name="Mama" id="mama">
                <option value="Models">Models</option>
                <option value="Decals">Decals</option>
            </select></div>
            <div class="Assets-Showcase-Flex">
                
                <div class="Asset-Item">
                    <img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="Asset-Item-IMG border" alt="">
                    <p class="Asset-Item-Name">Asset name display</p>
                </div>

                <div class="Asset-Item">
                    <img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="Asset-Item-IMG border" alt="">
                    <p class="Asset-Item-Name">Asset name display</p>
                </div>

                <div class="Asset-Item">
                    <img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="Asset-Item-IMG border" alt="">
                    <p class="Asset-Item-Name">Asset name display</p>
                </div>

                <div class="Asset-Item">
                    <img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="Asset-Item-IMG border" alt="">
                    <p class="Asset-Item-Name">Asset name display</p>
                </div>

                <div class="Asset-Item">
                    <img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="Asset-Item-IMG border" alt="">
                    <p class="Asset-Item-Name">Asset name display</p>
                </div>

                <div class="Asset-Item">
                    <img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="Asset-Item-IMG border" alt="">
                    <p class="Asset-Item-Name">Asset name display</p>
                </div>

            </div>
        </div>

    </div>
</div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script>
$( "#games-accordion" ).accordion({
    animate:350,
    classes: {
    "ui-accordion": "Accordion-Games-Container",
    "ui-accordion-header": "Accordion-Games-Default",
    "ui-accordion-header-collapsed": "Accordion-Games-Active",
    "ui-accordion-content": "Accordion-Games-Inside",
    }
});
</script>
</body>
</html>