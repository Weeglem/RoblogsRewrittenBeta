<?php

class User_Message{

    protected $Subject,$Message = "";
    protected $To_ID = 0;
    protected $From_ID = 1;
    protected $Error = "";
    protected $Database;
    protected $Skip_NoMessages = false;
    protected $Min = 6;

    public function __construct()
    {
        $this->Database = new Database();
    }

    public function Subject($Subject){$this->Subject = $Subject;}
    public function Message($Message){$this->Message = $Message;}
    public function To_ID($ToID){$this->To_ID = $ToID;}
    public function From_ID($FromID){$this->From_ID = $FromID;}
    public function Get_Error(){return $this->Error;}
    public function System_SkipNoMessages(){$this->Skip_NoMessages = true;}

    public function Send_Message(){
        try{
            $Validate_To = $this->Database->FetchColumn("SELECT COUNT(*) FROM `users_data` WHERE `ID` = ?",array($this->To_ID));
            if($Validate_To == 0) throw new Exception("This User doesn't exists.");

            $User = new User_Data($this->To_ID);
            $Username = $User->Username();
            $Banned = $User->Get_Banned();
            $No_Message = $User->Check_NoMessages();
            
            if($Banned == true) throw new Exception("$Username Account is banned.");
            if($No_Message == true) throw new Exception("$Username Inbox is closed.");


            $Message = $this->Database->Execute("
            INSERT INTO `users_messages`
            (`ToID`, `FromID`, `Subject`, `Content`) 
            VALUES 
            (:ToID,:FromID,:Subject,:Message)",
            array(
                [":ToID",$this->To_ID],
                [":FromID",$this->From_ID],
                [":Subject",$this->Subject],
                [":Message",$this->Message]
            ));

            if($Message != true) throw new Exception("Failed to send Message");

            return true;
        }catch(Exception $e){
            $this->Error = $e->getMessage();
        }
    }
}
