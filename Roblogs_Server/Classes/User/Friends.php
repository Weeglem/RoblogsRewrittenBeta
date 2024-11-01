<?php

class User_Friend{

    protected $FriendID;

    public function __construct($UserID) {
        $this->FriendID = $UserID;
    }

    protected function AreWeFriends($UserID)
    {
        $Database = new Database();
        $x = $Database->Prepare_Data_BindValue("SELECT COUNT(*) FROM `users_friends` 
        WHERE (`UserID` = :ID1 AND `FriendID` = :ID2) OR (`UserID` = :ID2 AND `FriendID` = :ID1)",array(
            [":ID1",Session::Get_ID(),PDO::PARAM_INT],
            [":ID2",$UserID,PDO::PARAM_INT]
        ));

        return $x[0][0] != 0 ? true : false;
    }

    protected function FriendRequest_Type($User1,$User2)
    {
        if(Session::Validate_Session() == false){return false;}
        $Database = new Database();
        $x = $Database->Prepare_Data_BindValue("SELECT COUNT(*) FROM `users_pending_friends` 
        WHERE `UserID` = :ID1 AND `RequestID` = :ID2",array(
            [":ID1",$User1,PDO::PARAM_INT],
            [":ID2",$User2,PDO::PARAM_INT]
        ));

        return $x[0][0] != 0 ? true : false;
    }

    public function Sent_FriendRequest($User)
    {
        return $this->FriendRequest_Type(Session::Get_ID(),$User);
    }

    public function Got_FriendRequest($User)
    {
        return $this->FriendRequest_Type($User,Session::Get_ID());
    }

    public function Get_FriendBool(){
        return $this->AreWeFriends($this->FriendID);
    }

    public function Get_Friend_Status(){

        if(Session::Validate_Session() == false){return false;}

        if($this->AreWeFriends($this->FriendID))
        {
            return "Friends";
        }

        if($this->Sent_FriendRequest($this->FriendID))
        {
            return "Pending";
        }

        if($this->Got_FriendRequest($this->FriendID))
        {
            return "Got";
    
        }
        return "Not_Friends";
    }
}

class User_FriendController{

    static function Add($UserID)
    {
        if(Session::Validate_Session() == false){ throw new Exception("You are not logged to Roblogs");}

        if($UserID == Session::Get_ID()){ throw new Exception("You cant be friend yourself");}

        if(new User_Data($UserID) != true){ throw new Exception("Invalid User");}

        $FC = new User_Friend($UserID);
        if($FC->Get_FriendBool() == true){ throw new Exception("You are already friends with this user"); }

        $X = new Database();

        $z = $X->Execute("
        SELECT 1
        FROM `users_pending_friends`
        WHERE `UserID` = :Us1 
        AND `RequestID` = :Us2
        ",array(
            [":Us1",Session::Get_ID()],
            [":Us2",$UserID]
        ));

        if($z == false) throw new Exception("Invalid Friend Request");

        $X->Execute("
        INSERT INTO `users_friends`
        (UserID,FriendID)
        VALUES
        (:Us1,:Us2),
        (:Us2,:Us1)
        ",array(
            [":Us1",Session::Get_ID()],
            ["Us2",$UserID]
        ));

        $Res = $X->Execute("
            DELETE 
            FROM `users_pending_friends`
            WHERE `UserID` = :Us1 
            AND `RequestID` = :Us2
        ",array(
            [":Us1",Session::Get_ID()],
            [":Us2",$UserID]
        ));

        //ADD IF PENDING FRIEND REQUEST VALIDATION


        

        return true;
    }

    static function Remove($UserID)
    {
        function Delete($a,$b)
        {
            $X = new Database();
            $Res = $X->Execute("
            DELETE FROM `users_friends` WHERE
            UserID = :Us1 AND FriendID = :Us2
            ",array(
                [":Us1",$a],
                [":Us2",$b]
            ));
            return $Res;
        }

        if(Session::Validate_Session() == false){ throw new Exception("You are not logged to Roblogs");}

        $FC = new User_Friend($UserID);
        if($FC->Get_FriendBool() == false){ throw new Exception("You are not friends with this user"); }
        Delete(Session::Get_ID(),$UserID);
        Delete($UserID,Session::Get_ID());

        return true;
    }

    static function SendRequest($UserID)
    {

        if(Session::Validate_Session() == false){ throw new Exception("You are not logged to Roblogs");}
        
        if($UserID == Session::Get_ID()){ throw new Exception("You cannot friend yourself.");}

        if(new User_Data($UserID) != true){ throw new Exception("Invalid User");}


        $FC = new User_Friend($UserID);
        if($FC->Get_FriendBool() == true){ throw new Exception("You are already friends with this user."); }
        if($FC->Get_Friend_Status() != "Not_Friends"){ throw new Exception("There is already a pending request ongoing."); }

        $X = new Database();
        $Res = $X->Execute("
            INSERT INTO `users_pending_friends`
            (UserID,RequestID)
            VALUES
            (:Us1,:Us2)
        ",array(
            [":Us2",Session::Get_ID()],
            ["Us1",$UserID]
        ));

        return true;
    }

    static function RejectRequest($UserID)
    {

        if(Session::Validate_Session() == false){ throw new Exception("You are not logged to Roblogs");}

        $X = new Database();
            
        $z = $X->Execute("
        SELECT 1
        FROM `users_pending_friends`
        WHERE `UserID` = :Us1 
        AND `RequestID` = :Us2
        ",array(
            [":Us1",Session::Get_ID()],
            [":Us2",$UserID]
        ));

        if($z == false) throw new Exception("Invalid Friend Request");

        $FC = new User_Friend($UserID);

        if($FC->Get_Friend_Status() != "Pending"){ throw new Exception("Invalid Permissions."); }
            
        $Res = $X->Execute("
            DELETE 
            FROM `users_pending_friends`
            WHERE `UserID` = :Us1 
            AND `RequestID` = :Us2
        ",array(
            [":Us1",Session::Get_ID()],
            [":Us2",$UserID]
        ));

        return true;
    }
}


?>