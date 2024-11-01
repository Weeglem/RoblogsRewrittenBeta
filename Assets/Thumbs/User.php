<?php
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->ThumbnailGenerator();
$x->Database();
$x->User_Data();

session_cache_limiter('none');
header('Cache-control: max-age='.(360));

$ID = isset($_GET["id"]) ? $_GET["id"] : null;
$Size =  isset($_GET["size"]) ? $_GET["size"] : "Thumbnail";

try{
        $x = new User_Data($ID);
        $Thumb = $x->Thumbnail_Server();
        
        $IMG = new ThumbnailGenerator($Thumb);
        $IMG->IMG_Link($Thumb);

        switch($Size){
            default:
            case "Thumbnail":
                $IMG->Width(200);
                $IMG->Height(150);
            break;
            case "Big":
                $IMG->Width(550);
                $IMG->Height(400);
            break;
        }

        $IMG->Transparent();

        header("Content-type: image/png");
        $IMG->Generate();
}
catch(Exception $err)
{
    $x = new ThumbnailGenerator();
    $x->IMG_Link(WebsiteLinks::Missing_Thumbnail_ServerFile());
    header("Content-type: image/png");
    $x->Generate();
}





?>