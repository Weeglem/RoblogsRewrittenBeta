<?php

class Includes{

    private $Database;
    private $Folder_root;
    private $Assets;
    private $Assets_Data_Folder;
    private $Functions_Folder;
    private $UserClass_Folder;

    
    public function __construct()
    {
        //CHANGE IF NEEDED
        $this->Folder_root = $_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server";
        $this->Database = $this->Folder_root."/database.php";
        $this->Assets = $this->Folder_root."/Classes/Assets/";
        $this->Functions_Folder = $this->Folder_root."/Functions/";

        include($this->Folder_root."/Classes/Website/SiteLink.php");
    }

    public function Database(){ include($this->Database);}


    //SESSION
    public function Session(){include($this->Folder_root."/Classes/User/Session.php");}
    public function Session_Comment(){include($this->Folder_root."/Classes/User/Comment.php");}
    

    //USERS 
    public function User_Data(){include($this->Folder_root."/Classes/User/Data.php");}
    public function User_Friend(){include($this->Folder_root."/Classes/User/Friends.php");}
    public function User_Message(){include($this->Folder_root."/Classes/User/Message.php");}
    public function User_FavoriteController(){include($this->Folder_root."/Classes/User/Favorites.php");}
    public function User_Ban(){include($this->Folder_root."/Classes/User/Ban.php");}

    //ASSETS
    public function Game_Data(){include($this->Assets."Game.php");}
    public function Model_Data(){include($this->Assets."Model.php");}
    public function Decal_Data(){include($this->Assets."Decal.php");}
    public function Message_Data(){include($this->Assets."Message.php");}
    public function Comment_Data(){include($this->Assets."Comment.php");}
    public function Group_Data(){include($this->Assets."Group.php");}
    public function UserImages_Data(){include($this->Assets."UserImages.php");}

    //WEBSITE
    public function ThumbnailGenerator(){include($this->Folder_root."/Classes/Website/ThumbnailGenerator.php");}
    public function WebsiteTrends(){include($this->Folder_root."/Classes/Website/Trending.php");}
    public function WebsiteCategories(){include($this->Folder_root."/Classes/Website/Categories.php");}
    public function WebsiteValidaiton(){include($this->Folder_root."/Classes/Website/Validation.php");}

    //UPLOADS
    public function Uploads_RobloxHandler(){include($this->Folder_root."/Classes/Uploads/RobloxUpload_Handler.php");}
    public function Uploads_CreateImage(){include($this->Folder_root."/Classes/Uploads/CreateImage.php");}
    public function Uploads_ZipHandler(){include($this->Folder_root."/Classes/Uploads/ZipHandler.php");}


    //PAGINATION
    public function Pagination(){
        include($this->Assets."../Pagination/Pagination.php");
        include($this->Assets."../Pagination/Users.php");
        include($this->Assets."../Pagination/Library.php");
        include($this->Assets."../Pagination/Games.php");
        include($this->Assets."../Pagination/Inbox.php");
        include($this->Assets."../Pagination/Friends.php");
        include($this->Assets."../Pagination/Inventory.php");
        include($this->Assets."../Pagination/Toolbox.php");
        include($this->Assets."../Pagination/Comments.php");
        include($this->Assets."../Pagination/GroupData/Members.php");
        include($this->Assets."../Pagination/GroupData/Allies.php");
        include($this->Assets."../Pagination/Groups.php");
        include($this->Assets."../Pagination/AdvancedPaginatorClass.php");
        include($this->Assets."../Pagination/Forum/ShowForum.php");
    }

    //STUDIO API

    public function SaveFile(){
        include($this->Folder_root."/Classes/Studio/SaveFile.php");
    }

    //FORUMS

    public function Forum_PostData()
    {
        include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Classes/Forum/NewPostData.php");
    }

    public function Forum_GroupData(){
        include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Classes/Forum/GroupData.php");
    }


}

//GLOBAL CLASSES (ALWAYS REQUIRED))


//ROBLOGS CLASS SITE

class Website{
    
    //TRANSLATE TO HTML CODE
    static function EncodeString($String){
        $text = htmlentities($String, ENT_QUOTES, 'UTF-8');
        return $text;
    }

    static function Get($Value,$Default = "")
    {
        return isset($_GET[$Value]) ? $_GET[$Value] : $Default;
    }

    static function MaxLength($String,$Max = 13)
    {
        return strlen($String) > $Max ? substr($String,0,$Max)."..." : $String;
    }

    static function RandomString($lenght = 30)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}




//LINKS



?>