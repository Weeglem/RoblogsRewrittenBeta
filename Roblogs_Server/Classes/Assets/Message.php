<?php

class Message_Data{

    private $ID;
    private $Database;

    public function __construct($id = 0)
    {
        $this->Database = new Database();
        $x = $this->Database->Prepare_Data("SELECT 1 FROM `users_messages` WHERE `ID` = ?",array($id));
        if($x == false) throw new Exception("Invalid Message");
        $this->ID = $id;
        return true;
    }

    public function ID()
    {
        $x = $this->Database->FetchColumn("SELECT `ID` FROM `users_messages` WHERE `ID` = ?",array($this->ID));
        return $x;
    }

    public function Subject()
    {
        $x = $this->Database->FetchColumn("SELECT `Subject` FROM `users_messages` WHERE `ID` = ?",array($this->ID));
        return $x;
    }

    public function Message()
    {
        $x = $this->Database->FetchColumn("SELECT `Content` FROM `users_messages` WHERE `ID` = ?",array($this->ID));
        return $x;
    }

    public function Date()
    {
        $x = $this->Database->FetchColumn("SELECT `Date` FROM `users_messages` WHERE `ID` = ?",array($this->ID));
        $Date = new DateTimeImmutable($x);
        return $Date->format("D M d H:i:s");
    }

    public function From()
    {
        $x = $this->Database->FetchColumn("SELECT `FromID` FROM `users_messages` WHERE `ID` = ?",array($this->ID));
        return $x;
    }

    public function From_Username()
    {
        $User = new User_Data($this->From());
        return $User->Username();
    }

    public function To()
    {
        $x = $this->Database->FetchColumn("SELECT `ToID` FROM `users_messages` WHERE `ID` = ?",array($this->ID));
        return $x; 
    }

    public function To_Username()
    {
        $User = new User_Data($this->To()());
        return $User->Username();
    }
}

class Message_Controller{
    static function Delete($ID){
        
        $MessageData = new Message_Data($ID);

        $To = $MessageData->To();
        if($To != Session::Get_ID()) throw new Exception("You dont own this message");

        $X = new Database();
        $X->Execute("
        DELETE FROM `users_messages`
        WHERE `ID` = :MessageID
        ",array([":MessageID",$ID,PDO::PARAM_INT]));

        return true;
    }
}

?>