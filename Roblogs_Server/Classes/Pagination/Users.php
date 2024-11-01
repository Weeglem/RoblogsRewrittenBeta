<?php
class Users_Pagination extends Pagination{
    protected $User_Name = "";

    public function __construct()
    {
        $this->database = new Database();
    }

    public function Username($String){
        $this->User_Name = $String;
    }

    

    protected function Get_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("SELECT `ID` FROM `users_data` WHERE `Banned` = 0 AND `Username` LIKE CONCAT( :Username,'%') ORDER BY `ID` ASC LIMIT :ActualPage,:LimitCount",
        array(
            [":Username",$this->User_Name,PDO::PARAM_STR],
            [":ActualPage",$this->StarterID,PDO::PARAM_INT],
            [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
        ));

        $this->Results_Fetch_Result = $x;
        return $x;
    }

    protected function Count_Total_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("SELECT COUNT(*) FROM `users_data` WHERE `Banned` = 0 AND `Username` LIKE CONCAT( :Username,'%') ",
        array([":Username",$this->User_Name,PDO::PARAM_STR]));

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    protected function Count_ActualPage_Results()
    {
        //OPTIMIZE PLEASE SQL_CALC_FOUND_ROWS `ID
        $x = $this->database->Prepare_Data_BindValue("SELECT SQL_CALC_FOUND_ROWS `ID` FROM `users_data` WHERE `Banned` = 0 AND `Username` LIKE CONCAT( :Username,'%') LIMIT :ActualPage,:LimitCount",
        array(
        [":Username",$this->User_Name,PDO::PARAM_STR],
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