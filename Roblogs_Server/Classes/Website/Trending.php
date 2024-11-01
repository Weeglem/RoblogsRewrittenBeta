<?php

class WebsiteTrends{
    static function GetTrendingGames($Max = 6)
    {
        $Database = new Database();
        $x = $Database->Prepare_Data_BindValue(
            "SELECT `ID` FROM `games_data` WHERE `Status` = 1 AND `Public` = 1 ORDER BY `Favorites` DESC LIMIT :MAXGames",
        array(
            [":MAXGames",$Max,PDO::PARAM_INT]
        ));

        return $x;
    }

    static function GetTrendingModels($Max = 6)
    {
        $Database = new Database();
        $x = $Database->Prepare_Data_BindValue(
            "SELECT `ID` FROM `models_data` WHERE `Status` = 1 AND `Public` = 1 ORDER BY `Favorites` DESC LIMIT :MAXGames",
        array(
            [":MAXGames",$Max,PDO::PARAM_INT]
        ));

        return $x;
    }

    static function GetTrendingDecals($Max = 6)
    {
        $Database = new Database();
        $x = $Database->Prepare_Data_BindValue(
            "SELECT `ID` FROM `decals_data` WHERE `Status` = 1 AND `Public` = 1 ORDER BY `Favorites` DESC LIMIT :MAXGames",
        array(
            [":MAXGames",$Max,PDO::PARAM_INT]
        ));

        return $x;
    }

    static function GetLastestUsers($Max = 6)
    {
        $Database = new Database();
        $x = $Database->Prepare_Data_BindValue(
            "SELECT `ID` FROM `users_data` ORDER BY `ID` DESC LIMIT :MAXGames",
        array(
            [":MAXGames",$Max,PDO::PARAM_INT]
        ));

        return $x;
    }
    

}


?>