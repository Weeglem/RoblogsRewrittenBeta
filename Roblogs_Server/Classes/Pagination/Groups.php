<?php
class Groups_Pagination extends Pagination{
    protected $Search_Name = "";

    public function __construct(){ $this->database = new Database(); }

    public function Search_Name($String){ $this->Search_Name = $String; }

    public function Get_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("
        SELECT `ID`
        FROM `groups_data` 
        WHERE `Name` LIKE CONCAT( :Name,'%')
        ORDER BY `ID` DESC
        LIMIT :ActualPage,:LimitCount
        ",
        array(
            [":Name",$this->Search_Name,PDO::PARAM_STR],
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
        FROM `groups_data` 
        WHERE `Name` LIKE CONCAT( :Name,'%')
        ",
        array(
            [":Name",$this->Search_Name,PDO::PARAM_STR],
        ));


        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("
        SELECT SQL_CALC_FOUND_ROWS `ID`
        FROM `groups_data` 
        WHERE `Name` LIKE CONCAT( :Name,'%')
        ORDER BY `ID` DESC
        LIMIT :ActualPage,:LimitCount
        ",
        array(
            [":Name",$this->Search_Name,PDO::PARAM_STR],
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