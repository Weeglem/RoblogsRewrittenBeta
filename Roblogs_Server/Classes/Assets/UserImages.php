<?php

class UserImages_Data{

    private $ID;
    private $Name;
    private $Description;
    private $Type;
    private $AssetID;
    private $Creator;
    private $Date;

    public function __construct($ID = 0) {

        $Database = new Database();
        $Validate = $Database->FetchColumn("SELECT 1 FROM `users_images` WHERE `ID` = ? ",array($ID));
        if($Validate == false) throw new Exception("Invalid User Image");

        $GetData = $Database->Prepare_Data_BindValue(
            "SELECT 
            `Type`,
            `UserID`,
            `Date`,
            `Description`,
            COALESCE(`Name`,`Date`) AS `Name`

            FROM `users_images` 
            WHERE `ID` = :AssetID ",array([":AssetID",$ID]));
        
        
        $this->Name = $GetData[0]["Name"];
        $this->Description = $GetData[0]["Description"];
        $this->Type = $GetData[0]["Type"];
        $this->AssetID = $ID;
        $this->Creator = $GetData[0]["UserID"];
        $this->ID = $ID;
        $this->Date = $GetData[0]["Date"];

        return true;
    }

    public function Get_Name(){return $this->Name;}
    public function Get_Description(){return $this->Description;}
    public function Get_Creator(){return $this->Creator;}
    public function Get_ID(){return $this->ID;}
    public function Get_Date(){return $this->Date;}
    public function Get_AssetID(){return $this->AssetID;}
    public function Get_AssetType(){return $this->Type;}

    public function Thumbnail($Size = "Thumbnail")
    {
        return "http://$_SERVER[SERVER_NAME]/Assets/Thumbs/User_Images.php?id=".$this->ID."&size=$Size";
    }




    public function Change_Name()
    {

    }

    public function Change_Description()
    {

    }

}