<?php
class Page_Pagination extends Pagination{
    protected $Search_Name = "";
    private $database;

    public function __construct(){ $this->database = new Database(); }

    public function Search_Name($String){ $this->Search_Name = $String; }

    public function Get_Results()
    {
        $x = $this->database->Prepare_Data_BindValue(
        "

        ",
        array(
            [":ActualPage",$this->StarterID,PDO::PARAM_INT],
            [":LimitCount",$this->Max_ItemsPerPage,PDO::PARAM_INT],
        ));
        $this->Results_Fetch_Result = $x;
        return $x;
    }

    public function Count_Total_Results()
    {   
        
        $this->Results_Total_Count = $x[0][0];
        return $x[0][0];
    }

    public function Count_ActualPage_Results()
    {

        if(count($x) == 0){
            $x = array();
            $x[0][0] = 0;
        }
        
        $this->Results_ThisPage_Count = $x[0][0];
        return $x[0][0];
    }

}

?>