<?php

class User_Data{

    private $UserID;
    private $Database;

    private $Username;
    private $DisplayName;
    private $Banned;
    private $Is_Online;

    public function __construct($ID) {

        $this->Database = new Database();

        $Validate =  $this->Database->FetchColumn("SELECT 1 FROM `users_data` WHERE `ID` = ? ",array($ID));
        if($Validate == false){throw new Exception("Requested User Doesn't exists.");}

        $UserData = $this->Database->Prepare_Data_BindValue("
            SELECT `Username`,`Banned`,
            IFNULL(`Display_Name`, `Username`) AS `Display_Name`
            FROM `users_data` WHERE `ID` = ?
        ",array([1,$ID]));

        $this->UserID = $ID;
        $this->Username = $UserData[0]["Username"];
        $this->DisplayName = $UserData[0]["Display_Name"];
        $this->Banned = $UserData[0]["Banned"] != 0 ? true : false;   
        $this->Is_Online = $this->Is_Online();

        return true;
    }

    public function ID(){ return $this->UserID;}

    public function Username(){return $this->Username;}

    public function DisplayName(){return $this->DisplayName;}

    public function Get_Banned(){return $this->Banned;}

    public function Avatar($Size="Thumbnail"){return "http://$_SERVER[SERVER_NAME]/Assets/Thumbs/User.php?id=".$this->UserID."&size=$Size";}

    //SERVER SIDE FOR THUMBNAIL FILE
    public function Thumbnail_Server(){ return $_SERVER["DOCUMENT_ROOT"]."/Website/avatars/".$this->UserID.".png";}

    public function About(){ return $this->Database->FetchColumn("SELECT `About` FROM `users_data` WHERE `ID` = ?",array($this->UserID)); }

    public function Join_Date(){ return $this->Database->FetchColumn("SELECT `Join_Date` FROM `users_data` WHERE `ID` = ?",array($this->UserID)); }

    public function Check_NoMessages()
    {
        $Res = $this->Database->FetchColumn("SELECT `No_Messages` FROM `users_data` WHERE `ID` = ?",array($this->UserID)); 
        return $Res != 0 ? true : false;
    }

    public function LastSeen($Convert = false)
    {
        $Res = $this->Database->FetchColumn("SELECT `Last_Seen` FROM `users_data` WHERE `ID` = ?",array($this->UserID)); 
        //CONVERT TO FORMATED DATE
        if($Convert == true){ 
            //NOT DEFINED LAST SEEN HANDLER
            if(filter_var($Res,FILTER_VALIDATE_INT) != true){return " Unknown";}
            $Res = date("F j, g:i a",$Res);
        }

        return $Res;
    }
    

    public function Is_Online(){
        //LEGACY CODE
        $x = $this->LastSeen();
        if($x == null) return false;

        $TimeSpan = "+1 Minutes";
        $TimeNow = strtotime(date("F j, g:i a"));
        $WaitTime = strtotime($TimeSpan, $x);

        return $WaitTime > $TimeNow ? true : false;
    }

    public function Draw_Online(){   
        return $this->Is_Online() ? "<span class='UserOnline Online'></span>&nbsp;" : "<span class='UserOnline Offline'></span>&nbsp;"; }



    public function Get_SocialMedia()
    {
        $Res = $this->Database->Prepare_Data_BindValue("
        SELECT * FROM `users_socialmedia` WHERE `UserID` = ?",array(
            [1,$this->ID(),PDO::PARAM_STR]
        )); 
        return $Res;
    }

    public function Settings_AllowsMessages()
    {
        return $this->Database->FetchColumn("SELECT 1 FROM `users_Settings` WHERE `ID` = ? AND `AllowMessages` = 1 LIMIT 1",array($this->UserID)) == 1 ? true : false;
    }

    public function Settings_AllowsFriendRequests()
    {
        return $this->Database->FetchColumn("SELECT 1 FROM `users_Settings` WHERE `ID` = ? AND `FriendRequests` = 1 LIMIT 1",array($this->UserID)) == 1 ? true : false;
    }

    public function Settings_PublicContact()
    {
        return $this->Database->FetchColumn("SELECT 1 FROM `users_Settings` WHERE `ID` = ? AND `PublicContact` = 1 LIMIT 1",array($this->UserID)) == 1 ? true : false;
    }

    public function Settings_CanIMessageYou()
    {
        if($this->Settings_AllowsMessages() == false){
            if($this->Friend_AreWeFriends() == false){ 
                return false;
            }else{ 
                return true; }
        }
        return true;
    }

    public function Friend_AreWeFriends()
    {
        $Database = new Database();
        $x = $Database->Prepare_Data_BindValue("SELECT COUNT(*) FROM `users_friends` 
        WHERE (`UserID` = :ID1 AND `FriendID` = :ID2) OR (`UserID` = :ID2 AND `FriendID` = :ID1)",array(
            [":ID1",Session::Get_ID(),PDO::PARAM_INT],
            [":ID2",$this->UserID,PDO::PARAM_INT]
        ));

        return $x[0][0] != 0 ? true : false;
    }











    public function Count_Games()
    {
        $Res = $this->Database->FetchColumn("SELECT COUNT(*) FROM `games_data` WHERE `Creator` = ?",array($this->ID())); 
        return $Res;
    }

    public function Count_Models()
    {
        $Res = $this->Database->FetchColumn("SELECT COUNT(*) FROM `models_data` WHERE `Creator` = ? AND `Status` = 1",array($this->ID())); 
        return $Res;
    }

    public function Count_Decals()
    {
        $Res = $this->Database->FetchColumn("SELECT COUNT(*) FROM `decals_data` WHERE `Creator` = ?",array($this->ID())); 
        return $Res;
    }

    public function Count_Friends()
    {
        $Res = $this->Database->FetchColumn("SELECT COUNT(*) FROM `users_friends` WHERE `UserID` = ?",array($this->ID())); 
        return $Res;
    }

    public function Count_Badges()
    {
        $Res = $this->Database->FetchColumn("SELECT COUNT(*) FROM `users_badges` WHERE `UserID` = ?",array($this->ID())); 
        return $Res;
    }

    public function Count_Threads()
    {
        $Res = $this->Database->FetchColumn("SELECT COUNT(*) FROM `forums_threads` WHERE `Owner` = ? AND `Deleted` = 0",array($this->Username())); 
        return $Res;
    }

    public function Count_Threads_Replies()
    {
        $Res = $this->Database->FetchColumn("SELECT COUNT(*) FROM `forums_replies` WHERE `Owner` = ?  AND `Deleted` = 0",array($this->Username())); 
        return $Res;
    }

    public function Count_ThreadsTotal(){
        return $this->Count_Threads() + $this->Count_Threads_Replies();
    }

    public function Games_Showcase($limit = 5)
    {
        $Res = $this->Database->Prepare_Data_BindValue("
        SELECT * FROM `games_data` WHERE `Creator` = ? AND `Status` = 1 LIMIT ?",array(
            [1,$this->ID(),PDO::PARAM_STR],
            [2,$limit,PDO::PARAM_INT]
        )); 
        return $Res;
    }

    public function Models_Showcase($limit = 5)
    {
        $Res = $this->Database->Prepare_Data_BindValue("
        SELECT * FROM `models_data` WHERE `Creator` = ? LIMIT ?",array(
            [1,$this->ID(),PDO::PARAM_STR],
            [2,$limit,PDO::PARAM_INT]
        )); 
        return $Res;
    }

    public function Decals_Showcase($limit = 5)
    {
        $Res = $this->Database->Prepare_Data_BindValue("
        SELECT * FROM `decals_data` WHERE `Creator` = ? LIMIT ?",array(
            [1,$this->ID(),PDO::PARAM_STR],
            [2,$limit,PDO::PARAM_INT]
        )); 
        return $Res;
    }

    public function Friends_Showcase($limit = 6)
    {
        $Res = $this->Database->Prepare_Data_BindValue("
        SELECT * FROM `users_friends` WHERE `UserID` = ? LIMIT ?",array(
            [1,$this->ID(),PDO::PARAM_STR],
            [2,$limit,PDO::PARAM_INT]
        )); 
        return $Res;
    }

    public function Badges_Showcase($limit = 6)
    {
        $Res = $this->Database->Prepare_Data_BindValue("
        SELECT * FROM `users_badges` WHERE `UserID` = ? LIMIT ?",array(
            [1,$this->ID(),PDO::PARAM_STR],
            [2,$limit,PDO::PARAM_INT]
        )); 
        return $Res;
    }





    

}

class User_DataController{
    static function GetID($Username)
    {
        $X = new Database();
        $Z = $X->FetchColumn("
            SELECT `ID` 
            FROM `users_data`
            WHERE `Username` = ?
            ",
            array($Username)
        );
        

        if($Z == false) throw new Exception("This User doesnt exists");
        return $Z;
    }

}


?>