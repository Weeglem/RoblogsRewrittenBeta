<?php

    class Group_Data{

        protected $ID,$Database;


        public function __construct($id = 0)
        {
            $x = new Database();
            $Validate = $x->FetchColumn("SELECT `ID` FROM `groups_data` WHERE `ID` = ? ",array($id));
            if($Validate == false) throw new Exception("Invalid Group");
            $this->Database = new Database();
            $this->ID = $id;
            return true;
        }

        public function Name()
        {
            $x = $this->Database->FetchColumn("SELECT `Name` FROM `groups_data` WHERE `ID` = ?",array($this->ID));
            return $x;
        }

        public function Description()
        {
            $x = $this->Database->FetchColumn("SELECT `Description` FROM `groups_data` WHERE `ID` = ?",array($this->ID));
            return $x;
        }

        public function Creator()
        {
            $x = $this->Database->FetchColumn("SELECT `Creator` FROM `groups_data` WHERE `ID` = ?",array($this->ID));
            return $x;
        }

        public function Date()
        {
            $x = $this->Database->FetchColumn("SELECT `Date` FROM `groups_data` WHERE `ID` = ?",array($this->ID));
            return $x;
        }

        public function Ranks_Data()
        {
            $x = $this->Database->Prepare_Data_BindValue("
                SELECT `RankID`,`RankName`,
                    (
                        SELECT COUNT(*) 
                        FROM `groups_members` 
                        WHERE `GroupID` = :GroupID
                        AND `Rank` = `RankID`
                    ) AS `TotalUsers`
                FROM `groups_ranks` 
                WHERE `GroupID` = :GroupID
                ",
                array(
                    [":GroupID",$this->ID]));
            return $x;
        }

        public function Members_Count()
        {
            $x = $this->Database->FetchColumn("
            SELECT COUNT(*)
            FROM `groups_members` 
            WHERE `GroupID` = ?
            ",
            array($this->ID));
        return $x; 
        }






    }

    class Group_Controller{
        static function Join($GroupID)
        {

        }

        static function Leave($GroupID)
        {
            
        }
    }

?>