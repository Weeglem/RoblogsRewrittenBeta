<?php
class Friends_Pagination extends Pagination{
    protected $User_ID = 4;
    protected $Search_Name = "";

    public function __construct($ID){ 
        $this->User_ID = $ID;
        $this->database = new Database(); 
    }

    public function Search_Name($String){ $this->Search_Name = $String; }
    

    public function Get_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("SELECT `FriendID` FROM `users_friends` WHERE `UserID` = :UserID LIMIT :ActualPage,:LimitCount",
        array(
            [":UserID",$this->User_ID,PDO::PARAM_STR],
            [":ActualPage",$this->StarterID,PDO::PARAM_INT],
            [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
        ));

        $this->Results_Fetch_Result = $x;
        return $x;
    }

    public function Count_Total_Results()
    {   
        $x = $this->database->Prepare_Data_BindValue("SELECT COUNT(*) FROM `users_friends` WHERE `UserID` = :UserID",
        array(
            [":UserID",$this->User_ID,PDO::PARAM_STR],
        ));

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("SELECT SQL_CALC_FOUND_ROWS `FriendID` FROM `users_friends` WHERE `UserID` = :UserID LIMIT :ActualPage,:LimitCount",
        array(
            [":UserID",$this->User_ID,PDO::PARAM_STR],
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

<?php
class PendingFriends_Pagination extends Pagination{
    protected $User_ID = 4;


    public function __construct($ID){ 
        $this->User_ID = $ID;
        $this->database = new Database(); 
    }

    public function Search_Name($String){ $this->Search_Name = $String; }
    

    public function Get_Results()
    {//FRIEND ID OUTPUT, QUICK PATCH, LAZY TO FIGURE ANOTHER WAY
        $x = $this->database->Prepare_Data_BindValue("SELECT `RequestID` AS `FriendID` FROM `users_pending_friends` WHERE `UserID` = :UserID LIMIT :ActualPage,:LimitCount",
        array(
            [":UserID",$this->User_ID,PDO::PARAM_STR],
            [":ActualPage",$this->StarterID,PDO::PARAM_INT],
            [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
        ));

        $this->Results_Fetch_Result = $x;
        return $x;
    }

    public function Count_Total_Results()
    {   
        $x = $this->database->Prepare_Data_BindValue("SELECT COUNT(*) FROM `users_pending_friends` WHERE `UserID` = :UserID",
        array(
            [":UserID",$this->User_ID,PDO::PARAM_STR],
        ));

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        $x = $this->database->Prepare_Data_BindValue("SELECT SQL_CALC_FOUND_ROWS `UserID` FROM `users_pending_friends` WHERE `UserID` = :UserID LIMIT :ActualPage,:LimitCount",
        array(
            [":UserID",$this->User_ID,PDO::PARAM_STR],
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