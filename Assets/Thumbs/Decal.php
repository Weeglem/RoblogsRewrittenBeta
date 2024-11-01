<?php
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->ThumbnailGenerator();
$x->Database();
$x->Decal_Data();

session_cache_limiter('none');
header('Cache-control: max-age='.(360));

$ID = isset($_GET["id"]) ? $_GET["id"] : null;
$Size =  isset($_GET["size"]) ? $_GET["size"] : "Toolbox";

try{
        $x = new Decal_Data($ID);
        $Thumb = $x->Thumbnail_Server();
        $IMG = new ThumbnailGenerator($Thumb);
        $IMG->IMG_Link($Thumb);

        switch($Size){
            case "Toolbox":
                $IMG->Width(100);
                $IMG->Height(100);
            break;
            default:
            case "Thumbnail":
                $IMG->Width(200);
                $IMG->Height(200);
            break;
            case "Big":
                $IMG->Width(390);
                $IMG->Height(271);
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
exit();
?>