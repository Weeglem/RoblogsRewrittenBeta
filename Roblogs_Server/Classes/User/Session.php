<?php

class Session{

    public static function Validate_Session()
    {
        if(empty($_SESSION["Usuario"]) == true || empty($_SESSION["ID"]) == true)
        {
            return false;
        }

        return true;
    }

    public static function Validate_Session_Exception()
    {
        if(empty($_SESSION["Usuario"]) == true || empty($_SESSION["ID"]) == true)
        {
            throw new Exception("Not Logged To ROBLOGS");
        }

        return true;
    }

    public static function Get_AccountToken(){return $_SESSION["Account_Token"];}

    public static function Get_Username(){ return $_SESSION["Usuario"];}

    public static function Get_ID(){return isset($_SESSION["ID"]) ? $_SESSION["ID"] : null;}

    public static function Get_AdminLevel(){
        if(empty($_SESSION["Admin"]) == true) return false;
        return 1; //TOP RANGE
    }

    public static function Avatar($Size = "Thumbnail")
    {
        $x = Session::Get_ID();
        if($x == null) $x = 0;
        return "http://localhost/Assets/Thumbs/User.php?id=".$x."&size=$Size";
    }

    public static function Change_Password($OldPassword,$NewPassword)
    {
        $Database = new Database();
        $UserID = Session::Get_ID();

        $Validate =  $Database->FetchColumn("
        SELECT `Password` 
        FROM `users_data` 
        WHERE `ID` = ?",array($UserID));

        if(password_verify($OldPassword,$Validate) != true) throw new Exception("Original Password is invalid.");
        
        $Execute = $Database->Execute("
        UPDATE `users_data`
        SET `Password` = :NewPassword
        WHERE `ID` = :UserID
        ",
        array(
            [":NewPassword",password_hash($NewPassword,PASSWORD_DEFAULT)],
            [":UserID",$UserID]
        ));

        return true;
    }


    //SETTINGS

    public static function Settings_AllowsMessages()
    {
        $Database = new Database();
        return $Database->FetchColumn("SELECT 1 FROM `users_Settings` WHERE `ID` = ? AND `AllowMessages` = 1 LIMIT 1",array(Session::Get_ID())) == 1 ? true : false;
    }

    public static function Settings_AllowsFriendRequests()
    {
        $Database = new Database();
        return $Database->FetchColumn("SELECT 1 FROM `users_Settings` WHERE `ID` = ? AND `FriendRequests` = 1 LIMIT 1",array(Session::Get_ID())) == 1 ? true : false;
    }

    public static function Settings_PublicContact()
    {
        $Database = new Database();
        return $Database->FetchColumn("SELECT 1 FROM `users_Settings` WHERE `ID` = ? AND `PublicContact` = 1 LIMIT 1",array(Session::Get_ID())) == 1 ? true : false;
    }

    public static function Settings_FilterText()
    {
        $Database = new Database();
        return $Database->FetchColumn("SELECT 1 FROM `users_Settings` WHERE `ID` = ? AND `CensorText` = 1 LIMIT 1",array(Session::Get_ID())) == 1 ? true : false;
    }

    public static function Get_SocialMedia()
    {
        $Database = new Database();
        $Res = $Database->Prepare_Data_BindValue("
        SELECT * FROM `users_socialmedia` WHERE `UserID` = ?",array(
            [1,Session::Get_ID(),PDO::PARAM_STR]
        )); 
        return $Res;
    }

    public static function Get_About(){ $Database = new Database(); return $Database->FetchColumn("SELECT `About` FROM `users_data` WHERE `ID` = ?",array(Session::Get_ID())); }


















    //DEBUG

    public static function Destroy()
    {
        session_destroy(); 
        session_unset();   
        return true;
    }

    public static function Create($Usuario,$ID,$Token = 1)
    {
        $_SESSION["Usuario"] = $Usuario;
        $_SESSION["ID"] = $ID;
        $_SESSION["Account_Token"] = $Token;
        return true;
    }

    protected function Add_Value($Name,$Value)
    {
        $_SESSION[$Name] = $Value;
        return true;
    }

    protected function Unset_Value($Name)
    {
        if(isset($_SESSION[$Name])){unset($_SESSION[$Name]); return true;}else{return false;}
    }

    public static function Get_Session_Data()
    {
        return $_SESSION;
    }


    static function UpdateLastSeen(){
        if(Session::Validate_Session() != true){return false;}
        
        $x = Session::Get_ID();
        $Database = new Database();
        $TimeNow = strtotime(date("F j, g:i a"));

        $Run = $Database->Execute('UPDATE `users_data` SET `Last_Seen` = :Tn WHERE `ID` = :usID ',
        
        array([":Tn",$TimeNow],[":usID",$x]));

        return true;
    }

    static function GetMailCount()
    {
        $Database = new Database();

        $Mail = $Database->FetchColumn("SELECT COUNT(*) FROM `users_messages` WHERE `ToID` = ?",array(Session::Get_ID()));

        return $Mail;

    }

    static function CheckBan()
    {
        $Database = new Database();

        $Execute = $Database->FetchColumn("SELECT 1 FROM `users_data`  WHERE `ID` = ? AND `Banned` = 1",array(Session::Get_ID()));
        return $Execute == 1 ? true : false;
    }

    static function FollowingThread($ID = 0)
    {
        if(Session::Validate_Session() == false){return false;}
        $Database = new Database();
        $Execute = $Database->FetchColumn("
        SELECT 1 
        FROM `forums_following`
        WHERE `UserID` = ?
        AND `PostID` = ?"
        ,array(Session::Get_ID(),$ID));
        return $Execute == 1 ? true : false;
    }

   
}


class Session_BanHandler extends Session
{
    protected $Reason = "";
    protected $Until = "";
    protected $Until_str = "";
    protected $Issued = "";

    protected $Warning = false;
    protected $Permanent = false;

    public function __construct()
    {
        $Database = new Database();

        $GetData = $Database->Prepare_Data_BindValue(
            "
            SELECT 
                `Permanent`,
                `Until`,
                `Until_str`,
                `Warning`,
                `Date` AS `Issued`,
                `Reason`
                

                FROM `users_banned`
                WHERE `UserID` = :UserID
                AND `Active` = 1
                
                LIMIT 1
            ",
            array([":UserID",Session::Get_ID()])
        );

        $this->Permanent = $GetData[0]["Permanent"] == 1 ? true : false;;
        $this->Warning = $GetData[0]["Warning"] == 1 ? true : false;;
        $this->Reason = $GetData[0]["Reason"];
        $this->Until = $GetData[0]["Until"];
        $this->Until_str = $GetData[0]["Until_str"];
        $this->Issued = $GetData[0]["Issued"];
    }

    public function Get_Reason(){return $this->Reason;}
    public function Get_Until($Formated = true){
        if($this->Permanent == true){return "Permanent";}
        $Until = $this->Until;
        return $Formated == true ? date("F j Y, g:i a",$Until) : $Until;
    }
    public function Get_Warning(){return $this->Warning;}
    public function Get_Until_str(){return $this->Until_str;}
    public function Get_Permanent(){return $this->Permanent;}
    public function Get_IssuedDate(){return $this->Issued;}

    public function Draw_Window()
    {
        $Until = $this->Get_Until();
        $Date = $this->Get_IssuedDate();
        $Reason = $this->Get_Reason();
        $Until_str = $this->Get_Until_str();

        if($this->Warning == true){
            $Title = "Warning";
            $Final = "Portate bien bien";
            $Form = '<form id="AppealorLogOut" action="#">
                        <input type="checkbox" name="Appeal" id="AppealWarning">
                        <span><label for="Appeal"> I Agree</label></span>
                        <br><button>Reactivate My Account</button>
                        <br>
                        <br>
                    </form>';
        }else{
            $Form = "";
            if($this->Permanent == true)
            {
                $Title = "Account Terminated";
                $Final = "Your account has been terminated from roblogs";
            }else{
                $Title = "Banned for $Until_str";
                $Final = "Your account will be reactivated on $Until";
            }
        }

        echo '
            <div class="Ban-Container border">
                <h1>'.$Title.'</h1>
                <p>Roblogs Moderators have determinated that your behavior on Roblogs has been in violation of our Terms or Service. Your account will be terminated if you do not abride by the <a href="#" class="Link">Roblogs Community Guidelines</a></p>
                <p>Reviewed: <strong>'.$Date.'</strong></p>
                <p class="BanNote">Moderator Note: <strong>'.$Reason.'</strong></p>
                <p class="BanFinal">'.$Final.'</p>
                <div class="Ban-Buttons">
                    '.$Form.'
                    <a href="'.WebsiteLinks::LogOut_API().'" class="Button">Logout</a>
                </div>
            </div>
            
        ';
    }

}

?>