<?php

class RobloxUpload_Handler{

    protected $MaxSize = 10000000; //10 MB

    /** Validate if String is Roblox XML Format, return Roblox XML as GZIP or false 
     * 
     * If Gzip is on then the scripts expects a php://input entry
     * 
     * Return RobloxGZIP  | false
    */
    static function CreateGZip(string $FileRBXL,bool $Is_GZIP = false)
    {
        try{
            function FindPattern($string,$contents){return preg_match($string,$contents) ? true : false;}

            if($Is_GZIP != false){ 
                $FileRBXL = @gzdecode($FileRBXL);
                if($FileRBXL == false) throw new Exception("Invalid GZIP Data, empty case");
            }else{
                $FileRBXL = @file_get_contents($FileRBXL);
                if($FileRBXL == false) throw new Exception("Invalid XML File, empty case");
            }
            
            if($FileRBXL == false){throw new Exception("Invalid XML Location");}

            $Validation_Patterns = array(
                '[<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd" version="4">]',
                '[<External>]',
                '/roblox/',
                '/RBX/',
                '[</External>]',
                '[</roblox>]'
            );

            $ValidXML = simplexml_load_string($FileRBXL);
            if($ValidXML == false){throw new Exception("Invalid XML Format");}

            for($i=1; $i < count($Validation_Patterns); $i++){
                if(FindPattern($Validation_Patterns[$i],$FileRBXL) != true){ throw new Exception("Failed XML Validation ID $i, $Validation_Patterns[$i]"); }
            }

            

            return gzencode($FileRBXL);
        }  
        catch(Exception $err)
        {
            throw new Exception($err->getMessage());
        } 
        
    }

    static function SanitizeXML(string $XMLString)
    {
        
    }

}