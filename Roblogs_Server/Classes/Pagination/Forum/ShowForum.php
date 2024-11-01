<?php
class ShowForum_Pagination extends Pagination{
    protected $Search_Name = "";
    protected $Category_ID = "";
    private $database;

    public function __construct(){ $this->database = new Database(); }

    public function Search_Name($String){ $this->Search_Name = $String; }
    public function Category_ID($id){$this->Category_ID = $id;}

    public function Get_Results()
    {
        $x = $this->database->Prepare_Data_BindValue(
        "
            SELECT `ID` 
            FROM `forums_threads`
            WHERE `Deleted` = 0
            AND `Category` = :Category
            ORDER BY `ID` DESC
            LIMIT :ActualPage,:LimitCount
        ",
        array(
            [":Category",$this->Category_ID,PDO::PARAM_INT],
            [":ActualPage",$this->StarterID,PDO::PARAM_INT],
            [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
        ));
        $this->Results_Fetch_Result = $x;
        return $x;
    }

    public function Count_Total_Results()
    {   
        $x = $this->database->Prepare_Data_BindValue(
            "
                SELECT COUNT(*) 
                FROM `forums_threads`
                WHERE `Deleted` = 0
                AND `Category` = :Category
            ",
            array(
                [":Category",$this->Category_ID,PDO::PARAM_INT]
            ));

        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {
        $x = $this->database->Prepare_Data_BindValue(
            "
                SELECT SQL_CALC_FOUND_ROWS `ID` 
                FROM `forums_threads`
                WHERE `Deleted` = 0
                AND `Category` = :Category
                LIMIT :ActualPage,:LimitCount
            ",
            array(
                [":Category",$this->Category_ID,PDO::PARAM_INT],
                [":ActualPage",$this->StarterID,PDO::PARAM_INT],
                [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
            ));

        if(count($x) == 0){
            $x = array();
            $x[0][0] = 0;
        }
        
        $this->Results_ThisPage_Count = $x[0][0];
        return $x[0][0];
    }

}

?>