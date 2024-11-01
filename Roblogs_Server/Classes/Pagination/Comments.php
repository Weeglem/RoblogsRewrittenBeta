<?php
class Comments_Pagination extends Pagination{

    private $Asset_ID;
    private $Asset_Type;
    private $database;

    public function __construct(){ $this->database = new Database();}

    public function Asset_Type($AssetType){ $this->Asset_Type = $AssetType; }

    public function Asset_ID($AssetID){ $this->Asset_ID = $AssetID; }

    public function Get_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("
            SELECT `ID`
            FROM `assets_comments`
            WHERE `Content_Type` = :ContentType
            AND `AssetID` = :AssetID
            ORDER BY `ID` DESC
            LIMIT :ActualPage,:LimitCount
        ",array(
            [":ContentType",$this->Asset_Type],
            [":AssetID",$this->Asset_ID,PDO::PARAM_INT],
            [":ActualPage",$this->StarterID,PDO::PARAM_INT],
            [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
        ));


        $this->Results_Fetch_Result = $x;
        return $x;
    }

    public function Count_Total_Results()
    {   
        $x = $this->database->Prepare_Data_BindValue("
        SELECT COUNT(*) 
        FROM `assets_comments`
        WHERE `Content_Type` = :ContentType
        AND `AssetID` = :AssetID
        ",array(
        [":ContentType",$this->Asset_Type],
        [":AssetID",$this->Asset_ID,PDO::PARAM_INT],
        ));

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("
            SELECT SQL_CALC_FOUND_ROWS `ID` 
            FROM `assets_comments`
            WHERE `Content_Type` = :ContentType
            AND `AssetID` = :AssetID
            LIMIT :ActualPage,:LimitCount
        ",array(
            [":ContentType",$this->Asset_Type],
            [":AssetID",$this->Asset_ID,PDO::PARAM_INT],
            [":ActualPage",$this->StarterID,PDO::PARAM_INT],
            [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
        ));

        if(count($x) == 0){
            $x = array();
            $x[0][0] = 0;
        }



        $this->Results_ThisPage_Count = $x[0][0];
        return $x[0][0];
    }



}
?>