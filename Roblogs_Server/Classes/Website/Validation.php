<?php

class Website_Validation{
    public static function Valid_Password(String $Password,$Pass2)
    {
        $Password_Len = strlen($Password);

        if(ctype_space($Password) == true || isset($Password) == false || $Password_Len == 0)
        {
            throw new Exception("Password cannot be empty");
        }
    
        if($Password != $Pass2)
        {
            throw new Exception("Both passwords have to be the same");
        }
    
        if($Password_Len < 6){
            throw new Exception("Password can't be less than 6 characters.");
        }
    
        if(preg_match("/[^A-z0-9]/",$Password) == false){
            throw new Exception("Pasword has to contain at least one special character");
        }

        return true;
    }

    public static function Valid_Username(String $Username)
    {
        $Save = $Username;
        $Username = str_replace(".","",$Username);
        $Username = str_replace("_","",$Username);

        $Username_Len = strlen($Username);

        if(ctype_space($Username) == true || isset($Username) == false || $Username_Len == 0)
        {
            throw new Exception("Username cannot be empty.");
        }

        if(preg_match('/[^A-z0-9]/',$Username) != false)
        {
            throw new Exception("Username cannot be purely made of non words and numbers...");
        }

        if($Username_Len < 4)
        {
            throw new Exception("Username cant be less than than 4 characters");
        }

        if($Username_Len > 30)
        {
            throw new Exception("Username cant be more than 30 characters");
        }

        if(preg_match('/[^A-z0-9]/',$Username) > 0)
        {
            throw new Exception("Username can only contain Words, Numbers, . and _.");
        }

        $Database = new Database();
        $VerifyName = $Database->FetchColumn(
        "
        SELECT 1
        FROM `users_data`
        WHERE `Username` = ?",
        array($Save)
        );

        if($VerifyName == 1) throw new Exception("This username is already taken");

        return true;
    }
}