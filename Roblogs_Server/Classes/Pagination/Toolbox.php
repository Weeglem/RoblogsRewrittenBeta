<?php
class Toolbox_Pagination extends Pagination{
    protected $Search_Type = "Models";
    protected $Search_Name = "";

    public function __construct(){ $this->database = new Database(); }

    public function Search_Name($String){ $this->Search_Name = $String; }
    
    public function Search_Type($String){$this->Search_Type = $String;}

    public function Get_Results()
    {
        switch($this->Search_Type){
            case "Models":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT `ID`
                FROM `models_data`
                WHERE `Name` LIKE CONCAT( :AssetName,'%')
                LIMIT :ActualPage,:LimitCount
                ",array(
                    [":AssetName",$this->Search_Name,PDO::PARAM_STR],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],  
                    
                ));
            break;
            default:
                return array();
            break;
        }




        $this->Results_Fetch_Result = $x;
        return $x;
    }

    public function Count_Total_Results()
    {   
        switch($this->Search_Type)
        {
            case "Models":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT COUNT(*)
                FROM `models_data`
                WHERE `Name` LIKE CONCAT( :AssetName,'%')
                ",array(
                    [":AssetName",$this->Search_Name,PDO::PARAM_STR],  
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
            case "Models":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT SQL_CALC_FOUND_ROWS `ID`
                FROM `models_data`
                WHERE `Name` LIKE CONCAT( :AssetName,'%')
                LIMIT :ActualPage,:LimitCount
                
                ",array(
                    [":AssetName",$this->Search_Name,PDO::PARAM_STR],
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