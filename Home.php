<?php 
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Classes/Wall/WallPage.php");
$x = new Includes();
$x->Database();
$x->Session();
$x->Game_Data();
$x->Model_Data();
$x->Decal_Data();
$x->User_Data();
$x->WebsiteTrends();


$WallContent = User_Wall::Get(12);


if(Session::Validate_Session() == false){exit(header("Location: Landing.php"));}

//var_dump(Session::Create("Ad",1));

$Session_Username = Session::Get_Username();
$Session_ID = Session::Get_ID();

try{
    $MySession_User = new User_Data($Session_ID); 
    $MySession_Avatar = $MySession_User->avatar("Big");
}catch(Exception){
    Session::Destroy();
    exit(header("Location: Landing.php"));
}

function Draw_Items($Array = array(),$Type = "Game")
{
    foreach($Array as $Item)
    {
        $AssetType = $Type."_data";

        try{ 
            $ID = $Item["ID"];
            $ItemData = new $AssetType($ID);
            $Name = $ItemData->Name();
            $Name = strlen($Name) > 20 ? substr($Name,0,20)."..." : $Name;
            $Thumb = $ItemData->Thumbnail();
            $Creator = $ItemData->Creator();
            $Creator_Username = $ItemData->Creator_Username();
            $Favorites = $ItemData->Favorites_Count();

            echo "
                <figure class='Games_List_Div'>
                    <a class='Link' href='".WebsiteLinks::Asset_Page($ID,$Type)."'>
                        <img draggable='false' class='Games_List_Thumbnail GamesThumbnail_Small border' src='$Thumb' alt=''>
                        <p' class='Games_List_Name'>$Name</p>
                    </a>
                    <p class='Games_List_Desc'>Owner: <a class='Link' href='".WebsiteLinks::Profile_Page($Creator)."'>$Creator_Username</a></p>
                    <p class='Games_List_Desc Favorites'>Favorites: $Favorites</p>
                </figure>
            ";

        }
        catch(Exception)
        {
            echo "";
        }


    }
}

function Draw_Blog($Array = array())
{
    foreach($Array as $Blog)
    {
        echo '<a href="#" class="Link Home_BlogEntry_Title">Blog entry name</a>';
    }
}

function Draw_Users($Array = array())
{
    foreach($Array as $Friend){
        $ID= $Friend["FriendID"];
        $f = new User_Data($ID);
        $FriendName = $f->Username();
        $Friend_DN = $f->DisplayName();
        $FriendAvatar = $f->Avatar();
        $FriendOnline = $f->Draw_Online();

        echo 
        '<figure class="Friends_List_Div">
            <a href="'.WebsiteLinks::Profile_Page($ID).'">
                <img draggable="false" class="AvatarsThumbnail_Small" src="'.$FriendAvatar.'" alt="">
                <p class="Link Friends_List_Name">'.$FriendOnline." ".$Friend_DN.'</p>
                <p class="Link Friends_List_Name"> "'.$FriendName.'</p>
            </a>
        </figure>';
    }
}
function DrawFeed($Array = array())
{
    for($i = 0; $i < count($Array); $i++)
    {
        $UserID = $Array[$i]["UserID"];
        $User_Data = new User_Data($UserID);
        $Username = $User_Data->Username();
        $IsOnline = $User_Data->Draw_Online();
        $Avatar = $User_Data->Avatar();
        $MessageID = $Array[$i]["MessageID"];
        $Message = $Array[$i]["Message"];
        $Date = $Array[$i]["Date"];

        $HR = isset($Array[$i+1]) ? "<hr>" : "";

        echo '
        
        
            <li class="Feed_Item">
                <article>
                    <figure><img src="'.$Avatar.'" class="AvatarsThumbnail_Small" alt="'.$Username.'"></figure>
                    <a href="'.WebsiteLinks::Profile_Page($UserID).'" class="Link">'.$IsOnline.$Username.' </a>
                    <span class="FeedDate"><strong> '.$Date.'</strong></span>       
                    <p class="FeedText">'.$Message.'</p>
                    
                    '.$HR.'
                </article>  
             </li>       
        
        ';  
    }
}

try{
$Trend_Games = WebsiteTrends::GetTrendingGames();
}catch(Exception $e)
{
    $HideTrend = true;
    $Trend_Games = array();
    echo "";
}

$User_Data = new User_Data($Session_ID);
$Friends_Count = $User_Data->Count_Friends();


?>
<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Home"; $Page_Title = "Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<div class="Home_Container">
    <section class="Home_Important BlueBorder ContainerBG">
        <figure class="Home_MyAvatar"><img draggable="false" src="<?=$MySession_Avatar?>" class="Home_MyAvatar AvatarsThumbnail_Big" alt="<?=$Session_Username;?>"></figure>
        <section class="Home_Actions">
            <hr>
            <h3><?=$Session_Username?></h3>
            <a href="<?=WebsiteLinks::Profile_Page($Session_ID)?>" class="Link">My Profile</a>
            <a href="<?=WebsiteLinks::MyUploads_Page();?>" class="Link">My Uploads</a>
            <a href="./Inbox/" class="Link">My Inbox</a>
            <a href="./my/Settings.php" class="Link">Edit Settings</a>
            <a href="./Account/logout.php" class="Link">Log out</a>
        </section>
    </section>    
    <div class="Home_Wall BlueBorder ContainerBG">
        <div class="Home_Wall_Hello">
            <h1>Welcome back, <?=$Session_Username?></h1>
            <hr>
        </div>
        <div class="flex js">
            <div class="Home_Wall_Details ">
                <section class="Home_Wall_Friends <?=$Friends_Count == 0 ? "Hidden" : ""?>">
                    <h2>Friends <a href="./User/Friends.php?id=<?=$Session_ID?>" class="Link">See All</a></h2>
                    <div class="Home_Wall_Friends_List">
                        <?=$Friends_Count > 0 ? Draw_Users($User_Data->Friends_Showcase()) : ""?>
                    </div>
                    <hr>
                </section>

                <section class="Home_Wall_Games">     
                    <h2>Top Games <a href="./Workshop.php?type=Games&order=MostFavorites" class="Link">See All</a></h2>
                    <div class="Home_Wall_Games_List">
                        <?=Draw_Items(WebsiteTrends::GetTrendingGames());?> 
                    </div>
                </section>

                <section class="Home_Wall_Games"> 
                    <hr>    
                    <h2>Top Models <a href="./Workshop.php?type=Models&order=MostFavorites" class="Link">See All</a></h2>
                    <div class="Home_Wall_Games_List">
                        <?=Draw_Items(WebsiteTrends::GetTrendingModels(3),"Model");?> 
                    </div>
                </section>
                <section class="Home_Wall_Games">  
                    <hr>   
                    <h2>Top Decals <a href="./Workshop.php?type=Decals&order=MostFavorites" class="Link">See All</a></h2>
                    <div class="Home_Wall_Games_List">
                        <?=Draw_Items(WebsiteTrends::GetTrendingDecals(3),"Decal");?> 
                    </div>
                </section>
            </div>

            <section class="Home_Wall_Feed">
                <h2>Lastest Feed <a href="#" class="Link">See All</a></h2>
                <hr>
                <ul class="Feed_List">
                   <?= DrawFeed($WallContent) ?>
                   <!--
                   <li class="Feed_Item">
                        <article>
                            <figure><img src="./Website/avatars/1.png" class="AvatarsThumbnail_Small" alt=""></figure>
                            <a href="'.WebsiteLinks::Profile_Page($UserID).'" class="Link">Weeglem Says</a>
                            
                            <p class="FeedText">Lorem ipsum dolor sit amet consectetur adipisicing elit. Error quidem impedit enim quisquam quia repellat eveniet tempora sequi sunt, quasi atque eos officia mollitia ipsam earum voluptas quo dignissimos ipsa recusandae incidunt similique! Quidem repellat eos sapiente nemo eius quos, est libero id sequi excepturi. Veniam totam adipisci hic animi doloribus quibusdam voluptate? Dicta illum nam dolor delectus repudiandae eaque quo, ullam quasi fugiat, nesciunt totam non accusamus. Quod consequuntur tenetur nesciunt facilis. Fugiat ipsa commodi incidunt porro voluptatem at nostrum in. Similique debitis aspernatur enim quisquam ducimus quam aut est. Iste, harum. Suscipit doloremque quod perspiciatis natus? Quisquam, recusandae.</p>
                            <p><strong>Date: 12-08-2024</strong></p>
                        </article>  
                    </li>
-->
                </ul>

                </div>
            </section>
        </div>
    </div>
</div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="./Website/JS/GoToProfile.js"></script>
</body>
</html>