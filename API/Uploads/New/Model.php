<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->WebsiteCategories();
$x->Uploads_CreateImage();
$x->Uploads_RobloxHandler();
$x->Uploads_ZipHandler();

function deleteDir(string $dirPath): void {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

if(Session::Validate_Session() == false){exit("Missing Session");}

$JSONArray = array(
    "success" => false, 
    "Name" => "",
    "Thumbnail" => "", 
    "Zip" => "",
    "Roblox" => "",
    "Category" => ""
);

$TempFolder = "./Temp/".Website::RandomString();
mkdir($TempFolder);

$Name = $_POST["Name"]; // error
$Description = $_POST["About"];
$Roblox = $_POST["ROBLOX"]; // error
$Category = $_POST["Category"]; // error

$ZIP_File = $_FILES["ZipFile"]; // error
$Thumbnail_File = $_FILES["ThumbFile"]; // error

$Public = isset($_POST["PrivateAsset"]) ? 0 : 1;
$AllowComments = isset($_POST["AllowComments"]) ? 1: 0;

if(empty($Name)){
    $JSONArray["Name"] = "Game name cannot be empty";
    $NameError = true;
}

if($ZIP_File["error"] > UPLOAD_ERR_OK){
    $JSONArray["Zip"] = "Zip File cannot be empty";
    $ZIPError = true;
}

if($Thumbnail_File["error"] > UPLOAD_ERR_OK){
    $JSONArray["Thumbnail"] = "Thumbnail cannot be empty";
    $THUMBError = true;
}

if(WebsiteCategories::ValidateCategory_Roblox($Roblox) == false){
    $JSONArray["Roblox"] = "Invalid Roblox Client";
    $ROBLOXError = true;
}

if(WebsiteCategories::ValidateCategory_Category($Category) == false){
    $JSONArray["Category"] = "Invalid Category";
    $CategoryError = true;
}

try{
    $ZipHandler = new ZipHandler();
    $ZipHandler->SetTempFolder("$TempFolder");
    $ZipHandler->SetZipSource($ZIP_File["tmp_name"]);
    $ZipHandler->SetAllowedTypes(array("rbxm")); //ONLY rbxl
    $ZipResult = $ZipHandler->Analyze_Roblox_ZIPHandler(); //SUCCESS
    $RobloxData = RobloxUpload_Handler::CreateGZip($ZipResult); //CREATE ROBLOX GZIP
}catch(Exception $err)
{
    $JSONArray["Zip"] = $err->getMessage();
    $ZipError = true;
}

//VALIDATE THUMBNAIL
try{
    $ThumbnailTemp = Website::RandomString();
    $ImageUploader = new ImageUploader();
    $ImageUploader->SetImageSource($Thumbnail_File["tmp_name"]);
    $ImageUploader->SetFinalLocation("$TempFolder/$ThumbnailTemp.png");
    $ImageUploader->Max_Heigth(1200);
    $ImageUploader->Max_Width(1200);
    $ImageUploader->Transparent(false);
    $ImageUploader->Execute();
}catch(Exception $err)
{
    $JSONArray["Thumbnail"] = $err->getMessage();
    $THUMBError = true;
}

//EXIT BECAUSE ERRORS HAPPENED
if(isset($NameError) || isset($ZIPError) || isset($THUMBError) || isset($ROBLOXError) || isset($CategoryError) ){    
    deleteDir($TempFolder);
    exit(json_encode($JSONArray));
}

$Database = new Database();
$NewItem = $Database->Execute_LastID("
    INSERT INTO `models_data`
    (`Name`,`Description`,`Creator`,`Status`,`Public`,`Comments`)
     VALUES
    (:NameItem,:DescItem,:CreatorItem,1,:PublicItem,:CommentsItem)",
array(
    [":NameItem",$Name],
    [":DescItem",$Description],
    [":CreatorItem",Session::Get_ID()],
    [":PublicItem",$Public],
    [":CommentsItem",$AllowComments]
));

$Execute = $Database->Execute("
    UPDATE `models_data` SET 
    `Download` = :NewID,
    `Thumbnail` = :NewID
    WHERE `ID` = :NewID
",array(
    [":NewID",$NewItem]
));

$Thumbs_FinalFolder = WebsiteLinks::ServerThumbs_Models();
$Roblox_FinalFolder = WebsiteLinks::Server_ModelsFolder();


file_put_contents("$Roblox_FinalFolder/$NewItem",$RobloxData); //create GZIP Roblox File
rename("$TempFolder/$ThumbnailTemp.png","$Thumbs_FinalFolder/".$NewItem.".png"); //Rename Thumbnail File

$JSONArray["success"] = true;

deleteDir($TempFolder);
exit(json_encode($JSONArray));


?>