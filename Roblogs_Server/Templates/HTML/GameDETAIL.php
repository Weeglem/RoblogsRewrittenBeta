<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Game_Info"; $Page_Title = "Roblogs - GameInfo"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<body>
<div class="container">
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Nav.php");?>
    <div class="Game_Container_Body">
        <div class="Game_Container">
            <div class="Games_Important_Div">
                <div class="Game_Presentation_Div border OldBlue BlueBorder">
                    <div class="margin0">
                        <h3 class="Game_Name">Roblogs Game Name Placeholder Title</h3>
                        <img src="../Website//IMG/RoblogsCrossroadsThumbnail.png" class="Game_Thumbnail_Large greyborder" alt="">
                    </div>
                </div>

                <div class="Game_Comments_Div border BlueBorder">
                    <p class="FakeLabel">Game Reviews ( 0 )</p>
                    <hr>
                    No Comments yet
                    <div class="Comment_Div">
                        <div class="Comment_UserPic"><img src="../Website//IMG/4.png" class="Comment_UserPic" alt=""></div>
                        <div class="Comment_Data">
                            <p class="Comment_Info">July 04, 2024 by <a class="Link" href="">Weeglem</a></p>
                            <p class="Comment_Content">This game sucks</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="Game_Info_Right">
                <div class="Game_Info_Div BlueBorder">
                    <div class="Game_Info_About">
                        <div class=""><img src="../Website//IMG/4.png" class="Game_Info_Avatar" alt=""></div>
                        <div class="Game_Info_Content">
                            <p class="FakeLabel">Game Details</p>
                            <p class="Game_Info_Detail">Creator: <a href="" class="Link">IAmAwesomeMan</a></p>
                            <p class="Game_Info_Detail">Created: 01-08-2024</p>
                            <p class="Game_Info_Detail">Favorites: 10</p>

                            <p class="Game_Info_Detail">Status: Public</p>
                            <p class="Game_Info_Detail">ROBLOX: 2006M</p>
                        </div>
                    </div>
                    <hr>
                    <p class="FakeLabel">Game Description</p>
                    <p class="Game_Info_Description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus minima adipisci ipsam obcaecati dolorum enim quis temporibus repellendus quam suscipit.</p>
                    <p class="Game_See_More Link">See more</p>
                    <hr>
                    <div class="Game_Action"><a href="" class="Action_Button">Download Game</a></div>
                </div>


                <div class="Game_Info_Div m BlueBorder">
                    <p class="FakeLabel">More games by Weeglem   <a class="Link Recommended_Link" href="#">See all -></a></p>
                    <hr>
                    <div class="Games_Recommendation_Flex">

                        <div class="Game_Result_Div">
                            <div class=""><img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="GameThumbnail_Small_2" alt=""></div>
                            <div class="Game_Recommendation_Info">
                                <p class="Game_Title">Roblogs Crossroads</p>
                                <p class="Game_Info">Owner: <a class="Link">1</a></p>
                            </div>
                        </div>

                        <div class="Game_Result_Div">
                            <div class=""><img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="GameThumbnail_Small_2" alt=""></div>
                            <div class="Game_Recommendation_Info">
                                <p class="Game_Title">Roblogs Crossroads</p>
                                <p class="Game_Info">Owner: <a class="Link">1</a></p>
                            </div>
                        </div>

                        <div class="Game_Result_Div">
                            <div class=""><img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="GameThumbnail_Small_2" alt=""></div>
                            <div class="Game_Recommendation_Info">
                                <p class="Game_Title">Roblogs Crossroads</p>
                                <p class="Game_Info">Owner: <a class="Link">1</a></p>
                            </div>
                        </div>

                        <div class="Game_Result_Div">
                            <div class=""><img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="GameThumbnail_Small_2" alt=""></div>
                            <div class="Game_Recommendation_Info">
                                <p class="Game_Title">Roblogs Crossroads</p>
                                <p class="Game_Info">Owner: <a class="Link">1</a></p>
                            </div>
                        </div>

                        <div class="Game_Result_Div">
                            <div class=""><img src="../Website/IMG/RoblogsCrossroadsThumbnail.png" class="GameThumbnail_Small_2" alt=""></div>
                            <div class="Game_Recommendation_Info">
                                <p class="Game_Title">Roblogs Crossroads</p>
                                <p class="Game_Info">Owner: <a class="Link">1</a></p>
                            </div>
                        </div>



                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
</body>
</html>