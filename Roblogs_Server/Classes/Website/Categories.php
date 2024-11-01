<?php

class WebsiteCategories{

    static function GetCategories()
    {
        $Database = new Database();
        $Execute = 
        $Database->Prepare_Data_BindValue("
            SELECT * FROM `categories`
        ");
        return $Execute;
    }

    static function GetRobloxVersions()
    {
        $Database = new Database();
        $Execute = 
        $Database->Prepare_Data_BindValue("
            SELECT * FROM `categories_roblox`
        ");

        return $Execute;
    }

    static function ValidateCategory_Category(string $TagID = "1")
    {
        $Database = new Database();
        $Execute = 
        $Database->Prepare_Data_BindValue("
            SELECT 1 FROM `categories` WHERE `ID` = :TagID
        ",array([":TagID",$TagID]));

        return $Execute == false ? false : true;
    }

    static function ValidateCategory_Roblox(string $TagID = "1")
    {
        $Database = new Database();
        $Execute = 
        $Database->Prepare_Data_BindValue("
            SELECT 1 FROM `categories_roblox` WHERE `ID` = :TagID
        ",array([":TagID",$TagID]));

        return $Execute == false ? false : true;
    }

}


?>