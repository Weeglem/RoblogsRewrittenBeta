<?php
class Inventory_Pagination extends Pagination{
    protected $Search_Type = "Models";
    protected $User_ID = 0;
    protected $Search_Name = "";

    public function __construct($ID){ 
        $this->User_ID = $ID;
        $this->database = new Database(); 
    }

    public function Search_Name($String){ $this->Search_Name = $String;}
    
    public function Search_Type($String){$this->Search_Type = $String;}

    public function Get_Results()
    {
        switch($this->Search_Type)
        {
            case "Games":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT `ID` 
                FROM  `games_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
                ));
            break;
            case "Models":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT `ID` 
                FROM `models_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
                ));
            break;
            case "Decals":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT `ID` 
                FROM `decals_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
                ));
            break;    
            default:
                $x = array();
            break;
        }
        $this->Results_Fetch_Result = $x;
        return $x;
    }

    public function Count_Total_Results()
    {   
        switch($this->Search_Type)
        {
            case "Games":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT COUNT(*) 
                FROM `games_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                ",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                ));
            break;
            case "Models":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT COUNT(*)  
                FROM `models_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                ",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                ));
            break;
            case "Decals":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT COUNT(*) 
                FROM `decals_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                ",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                ));
            break;    
            default:
                $x = array();
                $x[0][0] = 0;
            break;
        }
        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        switch($this->Search_Type)
        {
            case "Games":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT SQL_CALC_FOUND_ROWS `ID` 
                FROM `games_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
                ));
            break;
            case "Models":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT SQL_CALC_FOUND_ROWS `ID` 
                FROM `models_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
                ));
            break;
            case "Decals":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT SQL_CALC_FOUND_ROWS `ID` 
                FROM `decals_data` 
                WHERE `Creator` = :CreatorID
                AND `Status` != 2
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":CreatorID",$this->User_ID,PDO::PARAM_INT],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
                ));
            break;    
            default:
                $x = array();
                $x[0][0] = 0;
            break;
        }

        if(count($x) == 0){
            $x = array();
            $x[0][0] = 0;
        }
        
        $this->Results_ThisPage_Count = $x[0][0];
        return $x[0][0];
    }

}

?>