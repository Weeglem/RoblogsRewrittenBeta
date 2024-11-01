<?php
class ThreadReplies_Pagination extends Pagination{
    protected $ThreadID;
    private $database;

    public function __construct($id){ 
        $Database = new Database();
        $Validate = $Database->FetchColumn("SELECT 1 FROM `forums_posts` WHERE `ID` = ?",array($id));
        if($Validate != 1){throw new Exception("Invalid Thread");}
        
        $this->database = new Database(); 
        $this->ThreadID = $id;
    }

    public function Get_Results()
    {

        $x = $this->database->Prepare_Data_BindValue("
            SELECT `ID`
            FROM `forums_posts`
            WHERE `ParentID` = :ThreadID
            AND `Deleted` = 0
            LIMIT :ActualPage,:LimitCount

        ",array(
            [":ThreadID",$this->ThreadID,PDO::PARAM_INT],
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
            FROM `forums_posts`
            WHERE `ParentID` = :ThreadID
            AND `Deleted` = 0
        ",array(
            [":ThreadID",$this->ThreadID,PDO::PARAM_INT],
        ));

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("
            SELECT SQL_CALC_FOUND_ROWS `ID`
            FROM `forums_posts`
            WHERE `ParentID` = :ThreadID
            LIMIT :ActualPage,:LimitCount
        ",array(
            [":ThreadID",$this->ThreadID,PDO::PARAM_INT],
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