<?php

class Post_Data{
    protected $ID;
    protected $Database;

    protected $Name;
    protected $Owner;
    protected $GroupCategory;
    protected $ParentID;

    public function __construct($id = 0)
    {
        $this->Database = new Database();
        $Validate = $this->Database->FetchColumn("
        SELECT 1 FROM 
        `forums_posts` 
        WHERE `ID` = ?
        AND `Deleted` = 0
        ",
        array($id));

        if($Validate != 1){throw new Exception("Invalid Thread");}

        $GET = $this->Database->Prepare_Data_BindValue("
        SELECT * FROM 
        `forums_posts` 
        WHERE `ID` = :PostID
        AND `Deleted` = 0
        ",
        array([":PostID",$id]));
        
        $this->ID = $id;
        $this->Name = $GET[0]["Name"];
        $this->Owner = $GET[0]["Owner"];
        $this->GroupCategory = $GET[0]["CategoryID"];
        $this->ParentID = $GET[0]["ParentID"];

        return true;
    }

    public function Is_Open()
    {
        $Post = $this->ParentID == null ? $this->ID : $this->ParentID;
        $Execute = $this->Database->FetchColumn("
        SELECT 1
        FROM `forums_posts`
        WHERE `ID` = ?
        AND `Public` = 1 LIMIT 1",
        array($Post));
        if($Execute != 1) throw new Exception("TThe requested Post is no longer open for Answers");
        return true;
    }

    public function Replies()
    {
        $Execute = $this->Database->FetchColumn("
        SELECT COUNT(*) 
        FROM `forums_posts` 
        WHERE `ParentID` = ?
        AND `Deleted` = 0
        ",
        array($this->ID));
        return $Execute;
    }

    public function Name()
    {
        $x = $this->Database->Prepare_Data_BindValue("
        
        SELECT
            COALESCE(fp.Name, CONCAT('Re: ',(SELECT fp2.Name FROM forums_posts fp2 WHERE fp2.ID = fp.ParentID))) AS Name
        FROM 
            forums_posts fp
        WHERE 
        fp.ID = :PostID;
        
        ",array([":PostID",$this->ID]));
        return $x[0][0];
    }

    public function Owner()
    {
        $x = $this->Database->FetchColumn("SELECT `Owner` FROM `forums_posts` WHERE `ID` = ?",array($this->ID));
        return $x;
    }

    public function Can_Edit()
    {
        if($this->Owner() != Session::Get_Username()) throw new Exception("You don't own this Post");
        return true;
    }


    public function LastReply()
    {
        $x = $this->Database->Prepare_Data("
        SELECT `Owner`,`Date`
        FROM `forums_posts` 
        WHERE `ParentID` = ? 
        AND `Name` IS NOT NULL 
        AND `Deleted` = 0 
        ORDER BY `ID` DESC LIMIT 1",array($this->ID));
        if(empty($x[0])){
            $x = array();
            $x[0] = array(
                "Date" => $this->Date(false),
                "Owner" => $this->Owner(),
            );
        }

        $Date = date("D @ H:i A",$x[0]["Date"]);

        $Z = array(
            "Owner" => $x[0]["Owner"],
            "Date" => $Date,
        );


        return $Z;
    }

    public function Date($Formated = true)
    {
        $x = $this->Database->FetchColumn("SELECT `Date` FROM `forums_posts` WHERE `ID` = ?",array($this->ID));
        
        if($Formated == true)
        {
            return date("j M Y g:i A",$x);
        }
        
        return $x;
    }

    public function Body()
    {
        $x = $this->Database->FetchColumn("SELECT `Topic` FROM `forums_posts` WHERE `ID` = ?",array($this->ID));
        return $x;
    }

    public function Can_Reply()
    {
        return ForumGroup_Data::IsPublic($this->GroupCategory) == true? true : false;
    }



}
