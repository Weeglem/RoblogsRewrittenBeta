<?php
class Group_Members_Pagination extends Pagination{
    protected $GroupID;
    protected $RankID;
    protected $Database;

    public function __construct(){ 
        $this->Database = new Database(); 
    }

    public function Search_GroupID($GroupID){ $this->GroupID = $GroupID; }
    
    public function Search_RankID($RankID){$this->RankID = $RankID;}

    public function Get_Results()
    {
        $x = $this->Database->Prepare_Data_BindValue(
            "
            SELECT `UserID`,
            (
                SELECT `RankName`
                FROM `groups_ranks`
                WHERE `GroupID` = :GroupID
                AND `RankID` = :RankID

            ) AS `Rank`
            FROM `groups_members`
            WHERE `Rank` = :RankID
            AND `GroupID` = :GroupID

            LIMIT :ActualPage,:LimitCount
        "
        ,array(
            [":GroupID",$this->GroupID,PDO::PARAM_INT],
            [":RankID",$this->RankID,PDO::PARAM_INT],
            [":ActualPage",$this->StarterID,PDO::PARAM_INT],
            [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
        ));

        $this->Results_Fetch_Result = $x;
        return $x;
    }

    public function Count_Total_Results()
    {   
        $x = $this->Database->Prepare_Data_BindValue("
            SELECT count(*)
            FROM `groups_members`
            WHERE `Rank` = :RankID
            AND `GroupID` = :GroupID
        "
        ,array(
            [":GroupID",$this->GroupID,PDO::PARAM_INT],
            [":RankID",$this->RankID,PDO::PARAM_INT],
        ));

        if(count($x) == 0){
            $x = array();
            $x[0][0] = 0;
        }

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        $x = $this->Database->Prepare_Data_BindValue("
            SELECT SQL_CALC_FOUND_ROWS `UserID` 
            FROM `groups_members`
            WHERE `Rank` = :RankID
            AND `GroupID` = :GroupID
            LIMIT :ActualPage,:LimitCount
        "
        ,array(
            [":GroupID",$this->GroupID,PDO::PARAM_INT],
            [":RankID",$this->RankID,PDO::PARAM_INT],
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