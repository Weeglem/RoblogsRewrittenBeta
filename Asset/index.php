<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Model_Data();
$x->Decal_Data();
$x->Game_Data();
$x->User_Data();
$x->User_FavoriteController();
$x->UserImages_Data();

$ID = isset($_GET["id"]) ? $_GET["id"] : 1;
$Type = isset($_GET["Type"]) ? $_GET["Type"] : "Model";

$Failed = false;

try{
    $x = $Type."_Data";
    if(!class_exists($x)) throw new Exception("Invalid class");

    $Asset_Data = new $x($ID);
    $Asset_Name = $Asset_Data->Name();
    $Asset_Description = $Asset_Data->Description();
    $Asset_Creator = $Asset_Data->Creator();
    $Asset_Creation_Date = $Asset_Data->Creation_Date();

    $Creator = new User_Data($Asset_Creator);
    $Creator_Username = $Creator->Username();
    $Creator_Avatar = $Creator->Avatar();

    $Asset_Type = $Asset_Data->Content_Type();
    $Asset_ID = $Asset_Data->ID();
    $Asset_Thumbnail = $Asset_Data->Thumbnail("Big");
    $Asset_Roblox = $Asset_Data->Version();
    $Asset_Category = $Asset_Data->Category();
    $Asset_UsersThumbs = $Asset_Data->Get_Thumbnails();

    $Asset_Likes = $Asset_Data->Favorites_Count();

    $Asset_Ilike = Favorites_Controller::Like_Check($Asset_ID,$Asset_Type);

    $LikeButton = $Asset_Ilike == false ? 
    '<button type="button" value="AddFavorite" id="FavoriteHandler">Add To Favorites</button>'
    :
    '<button type="button" value="RemoveFavorite" id="FavoriteHandler">Remove From Favorites</button>';


    $Page_Title = "$Asset_Name by $Creator_Username";
}catch(Exception){
    $Failed = true;
    $Page_Title = "Unknown Asset";
}

?>

<!DOCTYPE html>
<html lang="en">
        
<?php $Page_CSS = "Asset_Details"; $Page_Title = $Page_Title?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<?php $Failed == true ? exit("<h3 style='margin-top:50px;'>The requested item doesn't exists</h3>") : "" ?>
<div class="Asset_Container">
    <!--
    <h1 style="text-align: left;"><?=$Asset_Name?></h1>
    <hr>-->

    <section class="MainFrame">
        <section class="Left BlueBorder">
            <h1><?=$Asset_Name?></h1>
            <br>
            <div class="Settings">
                <span><a class="Link" href="../Uploads/Edit.php?type=<?=$Asset_Type?>&id=<?=$ID?>">Edit</a></span>
                <span>/</span>
                <span><a class="Link" href="">History</a></span>
                <span>/</span>
                <span><a class="Link" href="">Update File</a></span>
                <span>/</span>
                <span><a class="Link" href="../Uploads/Thumbnails.php">Edit Thumbnails</a></span>
                
                
            </div>
            
            <div class="Asset_Details_Div">
                <ul class="Asset_Details">
                    <li>Creator: <a class="Link" href="<?=WebsiteLinks::Profile_Page($Asset_Creator)?>"><?=$Creator_Username?></a></li>
                    <li>Created: <?=$Asset_Creation_Date;?></li>
                    <li>Favorites: <span id="FavoritesNumber"><?=$Asset_Likes;?></span></li>
                    <li>Roblox: <?=$Asset_Roblox;?></li>
                    <li>Category: <?=$Asset_Category;?></li>
                    <!--<li><?=$LikeButton?></li>-->
                    <button class="LikeButton"><img src="../IMG/star-on.png" alt=""> <span class="LikeButton_Text">Add to Favorite</span></button>
                    <!--<li><span class="ShareLink" onclick="ShareLink()">[Share Item]</span></li>-->
                </ul>

                

                <!--
                <figure class="AvatarsThumbnail_Medium">
                    <img src="<?=$Creator_Avatar;?>" class="AvatarsThumbnail_Medium" alt="<?=$Creator_Username?>">
                </figure>
-->
            </div>
            <a href="Download.php?type=<?=$Asset_Type?>&id=<?=$Asset_ID?>" id="DownloadAsset" class="Button">Download</a>
            <a href="#" id="OpenRobloxStudio" class="Button">Open in Client Studio</a>
            
            <!--
            <a href="Download.php?type=<?=$Asset_Type?>&id=<?=$Asset_ID?>" id="DownloadAsset" class="Action_Button">Download</a>
            <a href="#" id="OpenRobloxStudio" class="Action_Button">Open in Client Studio</a>
-->
            <section class="Description <?=strlen($Asset_Description) > 0 ? "" : "Hidden"?>">
                <hr>
                <p class="FakeLabel">Description:</p>
                <p id="Description"><?=$Asset_Description;?></p>
                <p id="Description_See" class="See_More Link">See More</p>
            </section>
            <br>
            
        </section>
        <section class="Right BlueBorder">


<section id="image-carousel" class="splide Right" aria-label="Beautiful Images">
  <div class="splide__track">
		<ul class="splide__list">
			<li class="splide__slide">
                <img class="Thumbnail" src="<?=$Asset_Thumbnail;?>" alt="<?=$Asset_Name?>">
			</li>


            <?php

            foreach($Asset_UsersThumbs as $Thumbnail)
            {
                $ThumbID = $Thumbnail["ID"];
                $ImageData = new UserImages_Data($ThumbID);
                $IMG = $ImageData->Thumbnail("Big");
                $NAME = $ImageData->Get_Name();

                echo '
                <li class="splide__slide">
                    <img class="Thumbnail" src="'.$IMG.'" alt="'.$NAME.'">
                </li>
                ';
            }

            ?> 
		</ul>
  </div>
</section>

<script>
  
</script>




        </section>

    </section>

    <?php

    if(Session::Validate_Session() == true){

        echo '

    <section class="SubFrame BlueBorder">
        <ul>
            <li>
                <article class="Comment">
                    <img class="AvatarsThumbnail_Small CommentAvatar" src="'.Session::Avatar().'">
                    <div class="CommentInfo">
                        <form id="CommentForm" method="POST">
                            <ul>
                                <li><p class="Comment-Title">New Comment</p></li>
                                <li><textarea placeholder="Great!" name="Comment" id="Comment"></textarea><li>
                                <li><button type="submit" id="CommentForm_Submit">Send Comment</button></li>
                            </ul>
                        </form>
                    </div>
                </article>
            </li>
        </ul>
    </section>  ';

    }

    ?>

    <section class="SubFrame BlueBorder">
        <p class="FakeLabel">Comments</p>
        <hr>
        <section class="Comments">
            <ul id="CommentList">Getting Comments...</ul>
        </section>
        <div class="Pagination-Block">
            <p id="Back-Button" class="NavLink"></p>
            <p id="Next-Button" class="NavLink"></p>
        </div>
    </section>

    </section>
</div>

<form id="Comment-Info" class="Hidden" style="display:none">
    <input type="text" style="display:none" id="CommentsType" readonly="true" name="Type" value="<?=$Asset_Type;?>">
    <input type="text" style="display:none" id="CommentsID" readonly="true" name="id" value="<?=$Asset_ID?>">  
</form>

</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="../Website/JS/Description.js"></script>
<script src="../Website/JS/ShareLink.js"></script>
<script src="../Website/JS/Comments.js"></script>
<script src="../Website/JS/RobloxGameLauncher.js"></script>
<script src="./NewComment.js"></script>
<script src="./FavoriteHandler.js"></script>
<script src="
    https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
    "></script>

<script>
    document.addEventListener( 'DOMContentLoaded', function () {

new Splide( '#image-carousel',{
    type    : 'loop',
    autoplay: true,
    lazyLoad: 'nearby',
}
).mount();



} );
</script>
</body>
</html>