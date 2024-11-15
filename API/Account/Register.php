<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
/*
if(Session::Validate_Session() == true){ exit("Session already Started");}

if(@$_SERVER["HTTPS"] != "on") exit("This server only accepts HTTPS");
if($_SERVER["REQUEST_METHOD"] != "POST") exit("Invalid Method");
*/
header("Content-Type: application/json");

$Message = array(
    "success" => false,
    "username" => "",
    "password" => "",
    "system" => "",
);

$Post_Username = "FionnaMan";
$Post_Pass = "1234!";
$Post_PassRepeat = "1234!";

$Database = new Database();

function ValidateUsername($Username){
    global $Database,$Message;

    $Save = $Username;

    $Username = str_replace(".","",$Username);
    $Username = str_replace("_","",$Username);

    $Username_Len = strlen($Username);

    if(ctype_space($Username) == true || isset($Username) == false || $Username_Len == 0)
    {
        $Message["username"] = "Username cannot be empty.";
        return false;
    }

    if(preg_match('/[^A-z0-9]/',$Username) != false)
    {
        $Message["username"] = "Username cannot be purely made of non words and numbers...";
        return false;
    }

    if($Username_Len < 4)
    {
        $Message["username"] = "Username cant be less than than 4 characters";
        return false;
    }

    if($Username_Len > 30)
    {
        $Message["username"] = "Username cant be more than 30 characters";
        return false;
    }

    if(preg_match('/[^A-z0-9]/',$Username) > 0)
    {
        $Message["username"] = "Username can only contain Words, Numbers, . and _.";
        return false;
    }

    $VerifyName = $Database->Prepare_Data_BindValue(
    "
    SELECT 1
    FROM `users_data`
    WHERE `Username` = :User",
    array([":User",$Save])
    );

    if(isset($VerifyName[0]))
    { 
        $Message["username"] = "This username is already taken";
        return false;
    }

    return true; 
}

function ValidatePassword($Password,$Pass2){
    global $Message;

    $Password_Len = strlen($Password);

    if(ctype_space($Password) == true || isset($Password) == false || $Password_Len == 0)
    {
        $Message["password"] = "Password cannot be empty";
        return false;
    }

    if($Password != $Pass2)
    {
        $Message["password"] = "Both passwords have to be the same";
        return false;
    }

    if($Password_Len < 6){
        $Message["password"] = "Password can't be less than 6 characters.";
        return false;
    }

    if(preg_match("/[^A-z0-9]/",$Password) == false){
        $Message["password"] = "Pasword has to contain at least one special character";
        return false;
    }

    return true;
}


$Valid_Username = ValidateUsername($Post_Username);
$Valid_Password = ValidatePassword($Post_Pass,$Post_PassRepeat);

if($Valid_Username !== true || $Valid_Password !== true){
    exit(json_encode($Message));
}

$Create = $Database->Execute("
INSERT INTO `users_data` (`Username`, `Password`) 
VALUES (:User,:Pass)",
array(
    [":User",$Post_Username],
    [":Pass",password_hash($Post_Pass,PASSWORD_DEFAULT)],
));

if($Create != true)
{
    $Message["system"] = "Something failed while creating your account";
}

$GetID = $Database->FetchColumn("
SELECT `ID`
FROM `users_data`
WHERE `Username` = ?

",array($Post_Username));

if($GetID == false){
    $Message["system"] = "Something failed while creating your Session"; 
}


Session::Create($Post_Username,$GetID,5555);
$Message["success"] = true;
exit(json_encode($Message));


?>
