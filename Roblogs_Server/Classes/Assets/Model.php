<?php

class Model_Data{

    private $Asset_ID;
    private $Database;

    private $Name;
    private $Roblox;
    private $Category;
    private $Favorites;
    private $Content_Type = "Model";
    
    public function __construct($id = 0)
    {
        $this->Database = new Database();

        $Valid = $this->Database->FetchColumn("SELECT 1 FROM `models_data` WHERE `ID` = ?",array($id));

        if($Valid == false) throw new Exception("Requested Item Doesnt exists");

        $Get = $this->Database->Prepare_Data_BindValue("
            SELECT `ID`,`Name`,`Favorites`,
            (SELECT `Name` from `categories` WHERE `ID` = `category`) AS `Category`,
            (SELECT `Name` from `categories_roblox` WHERE `ID` = `category_roblox`) AS `Roblox`
            FROM `models_data` 
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

    public function Description(){ return $this->Database->FetchColumn("SELECT `Description` FROM `models_data` WHERE `ID` = ?",array($this->Asset_ID));  }


    public function Download_Name(){
        $x = $this->Database->FetchColumn("SELECT `Download` FROM `models_data` WHERE `ID` = ?",array($this->Asset_ID));  
        return $x;  
    }

    public function Download_Link()
    {
        $Item_ID = $this->Download_Name();
        return "$_SERVER[DOCUMENT_ROOT]/Roblogs_Server/Data/Models/$Item_ID";
    }

    public function Download_Type()
    {
        $x = $this->Database->FetchColumn("SELECT `Public` FROM `models_data` WHERE `ID` = ?",array($this->Asset_ID));  
        return $x;
    }

    public function Asset_Link()
    {
        $Item_ID = $this->ID();
        return "http://$_SERVER[SERVER_NAME]/Assets/Load/Model.php?id=$Item_ID";
    }

    public function Website_Link()
    {
        $x = $this->ID();
        return "https://$_SERVER[SERVER_NAME]/Asset/?id=$x&Type=Model";
    }
    
    public function Creation_Date()
    {
        $x = $this->Database->FetchColumn("SELECT `Creation_Date` FROM `models_data` WHERE `ID` = ?",array($this->Asset_ID));  
        return $x;
    }
    
    public function Update_Date()
    {
        $x = $this->Database->FetchColumn("SELECT `Update_Date` FROM `models_data` WHERE `ID` = ?",array($this->Asset_ID));  
        return $x;
    }
    
    public function Thumbnail($Size = "Thumbnail")
    {
        //$x = $this->Database->FetchColumn("SELECT `Thumbnail` FROM `models_data` WHERE `ID` = ?",array($this->Asset_ID));  
        //return "http://localhost/Website/thumbnails/models/".$x.".png";
        return "http://$_SERVER[SERVER_NAME]/Assets/Thumbs/Model.php?id=".$this->ID()."&size=$Size";
    }

    public function Thumbnail_Server()
    {
        $x = $this->Database->FetchColumn("SELECT `Thumbnail` FROM `models_data` WHERE `ID` = ?",array($this->Asset_ID)); 
        return $_SERVER["DOCUMENT_ROOT"]."/Website/thumbnails/models/".$x.".png";
    }
    
    public function Favorites_Count()
    {
        $x = $this->Database->FetchColumn("
        SELECT COUNT(*) 
        FROM `assets_favorites` 
        WHERE `AssetID` = ?
        AND `Type` = 'Model'

        ",array($this->Asset_ID));  
        return $x;
    }
    
    public function Comments_Count()
    {
        $x = $this->Database->FetchColumn("SELECT COUNT(*) FROM `assets_comments` WHERE `AssetID` = ? AND `Content_Type` = `Model`",array($this->Asset_ID));  
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
        $ID = $this->Database->FetchColumn("SELECT `Creator` FROM `models_data` WHERE `ID` = ?",array($this->Asset_ID)); 
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
            `models_data`
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