<?php
class Game_Data{

    private $Asset_ID;
    private $Database;

    private $Name;
    private $Roblox;
    private $Category;
    private $Favorites;
    private $Content_Type = "Game";

    public function __construct(int $id = 0)
    {
        $this->Database = new Database();

        $Valid = $this->Database->FetchColumn("SELECT 1 FROM `games_data` WHERE `ID` = ?",array($id));

        if($Valid == false) throw new Exception("Requested Item Doesnt exists");

        $Get = $this->Database->Prepare_Data_BindValue("
            SELECT `ID`,`Name`,`Favorites`,
            (SELECT `Name` from `categories` WHERE `ID` = `category`) AS `Category`,
            (SELECT `Name` from `categories_roblox` WHERE `ID` = `category_roblox`) AS `Roblox`
            FROM `games_data` 
            WHERE `ID` = :ItemID 
        ",array([":ItemID",$id,PDO::PARAM_INT]));

        $this->Asset_ID = $id;
        $this->Name = $Get[0]["Name"];
        $this->Roblox = $Get[0]["Roblox"];
        $this->Category = $Get[0]["Category"];
        $this->Roblox = $Get[0]["Roblox"];
        $this->Favorites = $Get[0]["Favorites"];

        return true;
    }

    public function Content_Type(){ return $this->Content_Type; }

    public function ID(){ return $this->Asset_ID;}

    public function Name(){ return $this->Name;}

    public function Version(){ return $this->Roblox;}

    public function Category(){ return $this->Category;}

    public function Description(){ return $this->Database->FetchColumn("SELECT `Description` FROM `games_data` WHERE `ID` = ?",array($this->Asset_ID));  }

    public function Download_Name(){ return $this->Database->FetchColumn("SELECT `Download` FROM `games_data` WHERE `ID` = ?",array($this->Asset_ID));  }

    public function Download_Link(){ return "$_SERVER[DOCUMENT_ROOT]/Roblogs_Server/Data/Games/".basename($this->Download_Name());}

    public function Asset_Link(){   return "http://$_SERVER[SERVER_NAME]/Assets/Load/Game.php?id=".basename($this->ID());}

    public function Website_Link(){ return "https://$_SERVER[SERVER_NAME]/Asset/?id=".$this->ID()."&Type=Game";}

    public function Creation_Date(){ return $this->Database->FetchColumn("SELECT `Creation_Date` FROM `games_data` WHERE `ID` = ?",array($this->Asset_ID));  }

    public function Update_Date()
    {
        $x = $this->Database->FetchColumn("SELECT `Update_Date` FROM `games_data` WHERE `ID` = ?",array($this->Asset_ID));  
        return $x;
    }

    public function Thumbnail($Size = "Thumbnail")
    {
        return "http://$_SERVER[SERVER_NAME]/Assets/Thumbs/Game.php?id=".$this->ID()."&size=$Size";
    }

    public function Thumbnail_Server()
    {
        $x = $this->Database->FetchColumn("SELECT `Thumbnail` FROM `games_data` WHERE `ID` = ?",array($this->Asset_ID));  
        return $_SERVER["DOCUMENT_ROOT"]."/Website/thumbnails/games/".$x."Thumbnail.png";
    }

    public function Favorites_Count(){return $this->Favorites;}

    public function Comments_Count()
    {
        $x = $this->Database->FetchColumn("SELECT COUNT(*) FROM `assets_comments` WHERE `AssetID` = ? AND `Content_Type` = `Game`",array($this->Asset_ID));  
        return $x;
    }

    public function Creator()
    {
        $ID = $this->Database->FetchColumn("SELECT `Creator` FROM `games_data` WHERE `ID` = ?",array($this->Asset_ID)); 
        return $ID;
    } 

    public function Status()
    {
        //MOVE TO SQL SWITCH CASE
        $x = $this->Database->FetchColumn("SELECT `Status` FROM `games_data` WHERE `ID` = ?",array($this->Asset_ID)); 
        
        switch($x)
        {
            case 0:
                return "Pending";
            break;
            case 1:
                return "Approved";
            break;
            case 2:
                return "Deleted";
            break;
            default:
                return "Unknown";
            break;
        }
    }

    public function Creator_Username(){
        $User = new User_Data($this->Creator());
        return $User->Username();
    }


    public function UpdateFavorites()
    {
        //FIX
        $Favs = $this->Favorites_Count();
        $Execute = $this->Database->Execute("
            UPDATE
            `games_data`
            SET `Favorites` = :NewFavs
            WHERE `ID` = :NewID",
        array(
            [":NewFavs",$Favs],
            [":NewID",$this->ID()]
        ));
        return $Execute;
    }

    public function Get_Thumbnails()
    {
        return
        $this->Database->Prepare_Data_BindValue(
            "
                SELECT * FROM
                `users_images`
                WHERE `AssetID` = :AssetID
                AND `Type` = :AssetType
            ",array(
                [":AssetID",$this->Asset_ID],
                [":AssetType",$this->Content_Type]
            )
        );
    }
}

?>