<?php
class Games_Pagination extends Pagination{

    //GO FIGURE THIS SHIT OUT, 
    //IS TOO COMPLICATED, JUST USE A LIKE AND VALIDATE THE CATEGORY

    protected $Search_Name = " ";
    protected $Search_Year = " ";
    protected $Search_Type = "Lastest";

    public function __construct(){ $this->database = new Database(); }

    public function Search_Name($String){ $this->Search_Name = $String; }

    public function Search_Year($String){ $this->Search_Year = $String; }

    public function Search_Type($String){ $this->Search_Type = $String; }


    protected function Get_Results()
    {
        switch($this->Search_Type){
            case "Lastest":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT `ID` 
                FROM `games_data` 
                WHERE `Status` = 1 
                AND `Name` LIKE CONCAT(:GameName,'%')  
                AND `Version` LIKE CONCAT(:GameYear,'%') 
                ORDER BY `ID` DESC
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":GameName",$this->Search_Name,PDO::PARAM_STR],
                    [":GameYear",$this->Search_Year,PDO::PARAM_STR],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
                ));
            break;  
            case "Oldest":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT `ID` 
                FROM `games_data` 
                WHERE `Status` = 1 
                AND `Name` LIKE CONCAT(:GameName,'%')  
                AND `Version` LIKE CONCAT(:GameYear,'%') 
                ORDER BY `ID` ASC
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":GameName",$this->Search_Name,PDO::PARAM_STR],
                    [":GameYear",$this->Search_Year,PDO::PARAM_STR],
                    [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                    [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
                ));
            break;
            case "Favs":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT FavoriteGame AS `ID`,COUNT(FavoriteGame) AS `TotalFavorites` 
                FROM `games_favorites` 
                WHERE FavoriteGame IN
                    (
                    SELECT `ID` FROM `games_data` 
                    WHERE `ID` = FavoriteGame 
                    AND `status` = 1 
                    AND `Public` = 1
                    AND `Name` LIKE CONCAT(:GameName,'%')  
                    AND `Version` LIKE CONCAT(:GameYear,'%') 
                    )
                GROUP BY FavoriteGame
                ORDER BY `TotalFavorites` DESC,`FavoriteGame` DESC
                LIMIT :ActualPage,:LimitCount",
                array(
                    [":GameName",$this->Search_Name,PDO::PARAM_STR],
                    [":GameYear",$this->Search_Year,PDO::PARAM_STR],
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

    protected function Count_Total_Results()
    {
        switch($this->Search_Type){
            case "Lastest":
            case "Oldest":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT COUNT(*) 
                FROM `games_data` 
                WHERE `Status` = 1 
                AND `Name` LIKE CONCAT(:GameName,'%')  
                AND `Version` LIKE CONCAT(:GameYear,'%') 
                ",array(
                    [":GameName",$this->Search_Name,PDO::PARAM_STR],
                    [":GameYear",$this->Search_Year,PDO::PARAM_STR],
                ));
            break;  
            case "Favs":
                $x = $this->database->Prepare_Data_BindValue("
                SELECT `ID`,COUNT(*)
                FROM `games_data` WHERE
                `Status` = 1 
                AND `Name` LIKE CONCAT(:GameName,'%')  
                AND `Version` LIKE CONCAT(:GameYear,'%') 
                 
                AND (
                    SELECT COUNT(*)
                    FROM `games_favorites` 
                    WHERE `games_favorites`.`FavoriteGame` = `ID`) > 0
                
                ",array(
                    [":GameName",$this->Search_Name,PDO::PARAM_STR],
                    [":GameYear",$this->Search_Year,PDO::PARAM_STR],
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


    protected function Count_ActualPage_Results()
    {
        switch($this->Search_Type){
            case "Lastest":
            case "Oldest":
            case "Favs":  
                $x = $this->database->Prepare_Data_BindValue("
                SELECT SQL_CALC_FOUND_ROWS `ID` 
                FROM `games_data` 
                WHERE `Status` = 1 
                AND `Name` LIKE CONCAT(:GameName,'%')  
                AND `Version` LIKE CONCAT(:GameYear,'%') 
                LIMIT :ActualPage,:LimitCount",array(
                    [":GameName",$this->Search_Name,PDO::PARAM_STR],
                    [":GameYear",$this->Search_Year,PDO::PARAM_STR],
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