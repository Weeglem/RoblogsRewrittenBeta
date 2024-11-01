<?php
class Group_Allies_Pagination extends Pagination{
    protected $GroupID = 1;
    protected $Enemy = 0;
    protected $database;

    public function __construct(){ $this->database = new Database(); }

    public function GroupID($ID){ $this->GroupID = $ID; }

    public function Enemy($Bool){
        switch($Bool)
        {
            case 1:
            case 0:
                $Bool = $Bool;
            break;
            default:
                $Bool = 0;
            break;
        }

        $this->Enemy = $Bool;
    }

    public function Get_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("
        SELECT `AllyID`
        FROM `groups_allies`
        WHERE `GroupID` = :GroupID
        AND `Enemy` = :Enemy
        LIMIT :ActualPage,:LimitCount
        ",array(
            [":GroupID",$this->GroupID,PDO::PARAM_INT],
            [":Enemy",$this->Enemy,PDO::PARAM_INT],
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
        FROM `groups_allies`
        WHERE `GroupID` = :GroupID
        AND `Enemy` = :Enemy
        ",array(
            [":GroupID",$this->GroupID,PDO::PARAM_INT],
            [":Enemy",$this->Enemy,PDO::PARAM_INT],
        ));

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {

        $x = $this->database->Prepare_Data_BindValue("
        SELECT SQL_CALC_FOUND_ROWS `AllyID`
        FROM `groups_allies`
        WHERE `GroupID` = :GroupID
        AND `Enemy` = :Enemy
        LIMIT :ActualPage,:LimitCount
        ",array(
            [":GroupID",$this->GroupID,PDO::PARAM_INT],
            [":Enemy",$this->Enemy,PDO::PARAM_INT],
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