<?php

    class Comment_Data{

        private $Asset_ID;
        private $Database;

        public function __construct($id = 1)
        {
            $x = new Database();
            $Validate = $x->FetchColumn("SELECT `ID` FROM `assets_comments` WHERE `ID` = ? ",array($id));
            if($Validate == false) throw new Exception("Invalid Comment");
            $this->Database = new Database();
            $this->Asset_ID = $id;
        }

        public function ID(){
            return $this->Asset_ID;
        }

        public function UserID(){
            $x = $this->Database->FetchColumn("SELECT `UserID` FROM `assets_comments` WHERE `ID` = ?",array($this->Asset_ID));
            return $x;
        }

        public function Date(){
            $x = $this->Database->FetchColumn("SELECT `Date` FROM `assets_comments` WHERE `ID` = ?",array($this->Asset_ID));
            return $x;
        }

        public function AssetID(){
            $x = $this->Database->FetchColumn("SELECT `AssetID` FROM `assets_comments` WHERE `ID` = ?",array($this->Asset_ID));
            return $x;
        }

        public function AssetType(){
            $x = $this->Database->FetchColumn("SELECT `Content_Type` FROM `assets_comments` WHERE `ID` = ?",array($this->Asset_ID));
            return $x;
        }

        public function Message(){
            $x = $this->Database->FetchColumn("SELECT `Message` FROM `assets_comments` WHERE `ID` = ?",array($this->Asset_ID));
            return $x;
        }




    }

    class Comment_Creator{
        protected $AssetID = "";
        protected $AssetType = "";
        protected $UserID = "";
        protected $Message = "";
        protected $Database;
        protected $Min = 10;

        public function __construct()
        {
            $this->Database = new Database();
            $this->UserID = Session::Get_ID();
        }

        public function AssetID($ItemID)
        {
            
            $this->AssetID = $ItemID;
        }

        public function AssetType($AssetType)
        {
            $this->AssetType = $AssetType;
        }

        public function Message($Message)
        {
            $this->Message = $Message;
        }

        public function Send()
        {
            $Valid1 = $this->AssetType."_Data";
            if(!class_exists($Valid1)) throw new Exception("Invalid class");
            if(new $Valid1($this->AssetID) != true) throw new Exception("Invalid Item ID");

            if(empty($this->Message)) throw new Exception("Comment cannot be empty");
            if(strlen($this->Message) < $this->Min) throw new Exception("Comment has to contain more than 10 Characters");

            $x = $this->Database->Execute("
            INSERT 
            INTO
            `assets_comments`
            (`UserID`, `AssetID`, `Content_Type`, `Message`) 
            VALUES
            (:UserID,:AssetID,:AssetType,:Message)
            ",array(
                [":UserID",$this->UserID],
                [":AssetID",$this->AssetID],
                [":AssetType",$this->AssetType],
                [":Message",$this->Message]
            ));

            if($x != true) throw new Exception("Failed to create Comment");
        }    
    }
?>