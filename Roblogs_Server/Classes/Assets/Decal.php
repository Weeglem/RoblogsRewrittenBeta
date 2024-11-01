<?php
class Decal_Data{
    private $Asset_ID;
    private $Database;

    private $Name;
    private $Roblox;
    private $Category;
    private $Favorites;
    private $Content_Type = "Decal";

    public function __construct($id = 0)
    {
        $this->Database = new Database();

        $Valid = $this->Database->FetchColumn("SELECT 1 FROM `decals_data` WHERE `ID` = ?",array($id));

        if($Valid == false) throw new Exception("Requested Item Doesnt exists");

        $Get = $this->Database->Prepare_Data_BindValue("
            SELECT `ID`,`Name`,`Favorites`,
            (SELECT `Name` from `categories` WHERE `ID` = `category`) AS `Category`,
            (SELECT `Name` from `categories_roblox` WHERE `ID` = `category_roblox`) AS `Roblox`
            FROM `decals_data` 
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

    public function Description(){ return $this->Database->FetchColumn("SELECT `Description` FROM `decals_data` WHERE `ID` = ?",array($this->Asset_ID));  }

    public function Download_Name(){return $this->ID(); }

    public function Download_Link()
    {
        $Item_ID = $this->Download_Name();
        return "$_SERVER[DOCUMENT_ROOT]/Roblogs_Server/Data/Decals/$Item_ID";
    }
    
    public function Asset_Link()
    {
        $Item_ID = $this->Download_Name();
        return "http://$_SERVER[SERVER_NAME]/Assets/Load/Decal.php?id=$Item_ID";
    }

    public function Website_Link()
    {
        $x = $this->ID();
        return "https://$_SERVER[SERVER_NAME]/Asset/?id=$x&Type=Decal";
    }

    public function Creation_Date()
    {
        $x = $this->Database->FetchColumn("SELECT `Creation_Date` FROM `decals_data` WHERE `ID` = ?",array($this->Asset_ID));  
        return $x;
    }

    public function Update_Date()
    {
        $x = $this->Database->FetchColumn("SELECT `Update_Date` FROM `decals_data` WHERE `ID` = ?",array($this->Asset_ID));  
        return $x;
    }

    public function Thumbnail($Size = "Thumbnail")
    {
        return "http://$_SERVER[SERVER_NAME]/Assets/Thumbs/Decal.php?id=".$this->ID()."&size=$Size";
    }

    public function Thumbnail_Server()
    {
        return $_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Data/Decals/".$this->ID();
    }

    public function Favorites_Count()
    {
        $x = $this->Database->FetchColumn("
        SELECT COUNT(*) 
        FROM `assets_favorites` 
        WHERE `AssetID` = ?
        AND `Type` = 'Decal'

        ",array($this->Asset_ID));  
        return $x;
    }

    public function Comments_Count()
    {
        $x = $this->Database->FetchColumn("SELECT COUNT(*) FROM `assets_comments` WHERE `AssetID` = ? AND `Content_Type` = `Decal`",array($this->Asset_ID));  
        return $x;
    }

    public function Status()
    {
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

    public function Creator()
    {
        $ID = $this->Database->FetchColumn("SELECT `Creator` FROM `decals_data` WHERE `ID` = ?",array($this->Asset_ID)); 
        return $ID;
    }  
    
    public function Creator_Username(){
        $User = new User_Data($this->Creator());
        return $User->Username();
    }

    public function UpdateFavorites()
    {
        $Favs = $this->Favorites_Count();
        $Execute = $this->Database->Execute("
            UPDATE
            `decals_data`
            SET `Favorites` = :NewFavs
            WHERE `ID` = :NewID",
        array(
            [":NewFavs",$Favs],
            [":NewID",$this->ID()]
        ));
        return $Execute;
    }
}
?>