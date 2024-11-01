<?php
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->ThumbnailGenerator();
$x->Database();
$x->Game_Data();

session_cache_limiter('none');
header('Cache-control: max-age='.(360));

$ID = isset($_GET["id"]) ? $_GET["id"] : null;
$Size =  isset($_GET["size"]) ? $_GET["size"] : "Thumbnail";

try{
        $x = new Game_Data($ID);
        $Thumb = $x->Thumbnail_Server();
        
        $IMG = new ThumbnailGenerator($Thumb);
        $IMG->IMG_Link($Thumb);
        
        switch($Size){
            default:
            case "Small":
                $IMG->Width(460);
                $IMG->Height(400);
            break;
            case "Thumbnail":
                $IMG->Width(460);
                $IMG->Height(400);
            break;
            case "Big":
                $IMG->Width(850);
                $IMG->Height(800);
            break;
        }

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