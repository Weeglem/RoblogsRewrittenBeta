<?php

    class User_Wall{
        static function Get($Max = 6)
        {
            $Database = new Database();
            $Execute = $Database->Prepare_Data_BindValue("

            SELECT 
            `users_friends`.`FriendID` as `UserID`,
            `users_wall`.`ID` AS `MessageID`,
            `users_wall`.`Message` AS `Message`,
            `users_wall`.`Date` AS `Date`
            FROM `users_friends`

            INNER JOIN `users_wall`
            ON `users_wall`.`UserID` = `users_friends`.`FriendID`

            WHERE `users_friends`.`UserID` = :SessionID
            OR `users_wall`.`UserID` = :SessionID
            OR `users_wall`.`UserID` = 1
            ORDER BY `users_wall`.`ID` DESC
            LIMIT :LimitMax

            ",array(
                [":SessionID",Session::Get_ID(),PDO::PARAM_INT],
                [":LimitMax",$Max,PDO::PARAM_INT])
            );

            return $Execute;


        }
    }


?>