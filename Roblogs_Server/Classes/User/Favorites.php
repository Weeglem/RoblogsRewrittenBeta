<?php

class Favorites_Controller
{

    static function Add($ItemID,$ItemClass)
    {

        if(Session::Validate_Session() == false) throw new Exception("Invalid Session");

        //CONVERT INTO CLASS
        $Valid1 = $ItemClass."_Data";
        if(!class_exists($Valid1)) throw new Exception("Invalid class");
        if(new $Valid1($ItemID) != true) throw new Exception("Invalid Item ID");
        
        
        $Handler = new Database();
        $Execute = $Handler->Execute("
        SELECT 1
        FROM `assets_favorites`
        WHERE
        `UserID` = :UserID
        AND `AssetID` = :AssetID
        AND `Type` = :AssetType
        
        ",array(
            [":UserID",Session::Get_ID()],
            [":AssetID",$ItemID],
            [":AssetType",$ItemClass],
        ));

        if($Execute != false) throw new Exception("You already added this Item to favorites");

        $Add = $Handler->Execute("
        INSERT INTO `assets_favorites`
        (`UserID`, `AssetID`, `Type`)
        VALUES
        (:UserID,:AssetID,:AssetType)
        ",
        array(
            [":UserID",Session::Get_ID()],
            [":AssetID",$ItemID],
            [":AssetType",$ItemClass],
        ));

        if($Add == false) throw new Exception("Failed to Add this item to favorites");

        return true;
    }

    static function Remove($ItemID,$ItemClass)
    {
        if(Session::Validate_Session() == false) throw new Exception("Invalid Session"); 

        $Handler = new Database();
        $Execute = $Handler->Execute("
        SELECT 1
        FROM `assets_favorites`
        WHERE
        `UserID` = :UserID
        AND `AssetID` = :AssetID
        AND `Type` = :AssetType
        
        ",array(
            [":UserID",Session::Get_ID()],
            [":AssetID",$ItemID],
            [":AssetType",$ItemClass],
        ));

        if($Execute != true) throw new Exception("You dont have this item in Favorites");

        $Add = $Handler->Execute("
        DELETE
        FROM `assets_favorites`
        WHERE
        `UserID` = :UserID 
        AND `AssetID`= :AssetID 
        AND `Type` = :AssetType
        ",
        array(
            [":UserID",Session::Get_ID()],
            [":AssetID",$ItemID],
            [":AssetType",$ItemClass],
        ));

        if($Add != true) throw new Exception("Failed to Remove this item from favorites");

        return true;
    }

    static function Like_Check($ItemID,$ItemClass)
    {
        if(Session::Validate_Session() == false) return false; 

        $Handler = new Database();
        $Execute = $Handler->Execute("
        SELECT 1
        FROM `assets_favorites`
        WHERE
        `UserID` = :UserID
        AND `AssetID` = :AssetID
        AND `Type` = :AssetType
        
        ",array(
            [":UserID",Session::Get_ID()],
            [":AssetID",$ItemID],
            [":AssetType",$ItemClass],
        ));

        if($Execute != true) return false;
        return true;
    }
    

}

?>