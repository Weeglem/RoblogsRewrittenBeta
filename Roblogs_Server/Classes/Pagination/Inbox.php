<?php
class Inbox_Pagination extends Pagination{
    protected $SessionID = 4;
    protected $Search_Name = "";

    public function __construct($SessionID){ 
        $this->database = new Database();
        $this->SessionID = $SessionID;
     }

    public function Search_Name($String){ $this->Search_Name = $String; }

    public function Get_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("
        SELECT * 
        FROM `users_messages` 
        WHERE `ToID` = :MyID
        ORDER BY `ID` DESC
        LIMIT :ActualPage,:LimitCount
        ",
        array(
            [":MyID",$this->SessionID,PDO::PARAM_INT],
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
        FROM `users_messages` 
        WHERE `ToID` = :MyID
        ",
        array(
            [":MyID",$this->SessionID,PDO::PARAM_INT],
        ));

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("
        SELECT SQL_CALC_FOUND_ROWS `ID` 
        FROM `users_messages` 
        WHERE `ToID` = :MyID
        LIMIT :ActualPage,:LimitCount
        ",
        array(
            [":MyID",$this->SessionID,PDO::PARAM_INT],
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