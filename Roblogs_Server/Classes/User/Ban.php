<?php

    class UserBan
    {
        static function BanUser($UserID,$Permament = false,$Days = "1 Days")
        {
            if(Session::Validate_Session() != true){throw new Exception("Invalid User Session");}
            if(Session::Get_AdminLevel() == false){throw new Exception("Invalid User");}

            //+1 Days
            //+1 Weeks
            //+1 Years
            $Database = new Database();
            $TimeNow = strtotime(date("F j, g:i a"));
            $BanDays = "+$Days";
            $Convert = strtotime($BanDays,$TimeNow);
            if($Convert == false){throw new Exception("Invalid Date Format, Examples: 1 Days, 5 Weeks, 30 Years");}
            $Permament = $Permament == false ? 0 : 1;
            $BanTime = $Convert;

            $RunPrev1 = $Database->Execute(
                "
                UPDATE `users_data` 
                SET `Banned`= 1

                WHERE `ID` = :UserID
                ",
                array(
                    [":UserID",$UserID,PDO::PARAM_INT], 
                )
            );

            $RunPrev = $Database->Execute(
                "
                UPDATE `users_banned` 
                SET `Active`= 0

                WHERE `UserID` = :UserID 
                AND `Active`= 1
                ",
                array(
                    [":UserID",$UserID,PDO::PARAM_INT], 
                )
            );

            $Execute = $Database->Execute(
            "
                INSERT INTO `users_banned`
                (`UserID`,`Permanent`,`Until`,`Until_str`)
                VALUES
                (:UserID,:PermBan,:UntilDate,:UntilStr)
                ",array(
                    [":UserID",$UserID,PDO::PARAM_INT],
                    [":PermBan",$Permament],
                    [":UntilDate",$Convert],
                    [":UntilStr",$Days],
                ));

            echo "Banned User";
        }

        static function UnbanUser($UserID)
        {
            //if(Session::Validate_Session() != true){throw new Exception("Invalid User Session");}
            //if(Session::Get_AdminLevel() == false){throw new Exception("Invalid User");}

            $Database = new Database();
            $RunPrev = $Database->Execute(
                "
                UPDATE `users_data` 
                SET `Banned`= 0

                WHERE `ID` = :UserID 
                ",
                array(
                    [":UserID",$UserID,PDO::PARAM_INT], 
                )
            );

            $RunPrev2 = $Database->Execute(
                "
                UPDATE `users_banned` 
                SET `Active`= 0

                WHERE `UserID` = :UserID 
                AND `Active`= 1
                ",
                array(
                    [":UserID",$UserID,PDO::PARAM_INT], 
                )
            );

            echo "UnBanned User";
        }

        static function WarnUser($UserID)
        {
            if(Session::Validate_Session() != true){throw new Exception("Invalid User Session");}
            if(Session::Get_AdminLevel() == false){throw new Exception("Invalid User");}
            $Database = new Database();

            $RunPrev1 = $Database->Execute(
                "
                UPDATE `users_data` 
                SET `Banned`= 1

                WHERE `ID` = :UserID
                ",
                array(
                    [":UserID",$UserID,PDO::PARAM_INT], 
                )
            );

            $RunPrev2 = $Database->Execute(
                "
                UPDATE `users_banned` 
                SET `Active`= 0

                WHERE `UserID` = :UserID 
                AND `Active`= 1
                ",
                array(
                    [":UserID",$UserID,PDO::PARAM_INT], 
                )
            );

            $Execute = $Database->Execute(
                "
                    INSERT INTO `users_banned`
                    (`UserID`,`Warning`)
                    VALUES
                    (:UserID,:Warning)
                ",array(
                    [":UserID",$UserID,PDO::PARAM_INT],
                    [":Warning",1,PDO::PARAM_INT]
                ));
    
            echo "Warned Used";
        }
    }


?>