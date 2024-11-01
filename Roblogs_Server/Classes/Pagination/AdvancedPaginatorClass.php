<?php

class Advanced_Pagination extends Pagination{

    protected $Results_TotalArray = array();
    protected $Debug = false;

    protected $SelectedDatabase = "";
    protected $SelectArray = array();
    protected $Count = false;
    protected $EqualsArray = array();
    protected $LikeArray = array();
    protected $NotNullArray = array();
    protected $IsNullArray = array();
    protected $OrderSQL = "ORDER BY `ID` DESC";

    protected $BuildQuery = "";
    protected $SelectQuery = "";
    protected $LikeQuery = "";
    protected $FindQuery = "";
    protected $NotNull_Query = "";
    protected $IsNull_Query = "";
    protected $ActualBind = 1;

    protected $Message = "";
    protected $Error = false;
    protected $DebugMessage = "";

    protected $Database;

    protected $ResultsArray = array();

    function Debug()
    {
        $this->Debug = true;
    }

    function __construct()
    {
        try{
            $this->Database = new PDO("mysql:host=localhost;dbname=newroblogs", "root", "");
        }catch(Exception)
        {
            throw new Exception("Invalid Database In Advanced Paginator");
        }
        
    }

    public function Select($Array = array()){
        $this->SelectArray = $Array;
        return true;
    }

    public function Like($Array = array())
    {
        $this->LikeArray = $Array;
        return true; 
    }

    public function Equals($Array = array())
    {
        $this->EqualsArray = $Array;
        return true;
    }

    public function NotNull($Array = array())
    {
        $this->NotNullArray = $Array;
        return true;
    }

    public function IsNull($Array = array())
    {
        $this->IsNullArray = $Array;
        return true;
    }

    public function Order($OrderType)
    {
        switch($OrderType){
            case "Newest":
                $this->OrderSQL = " ORDER BY `ID` DESC";
            break;
            case "Oldest":
                $this->OrderSQL = " ORDER BY `ID` ASC";
            break;
            case "MostFavorites":
                $this->OrderSQL = " ORDER BY `Favorites` DESC,`ID` DESC";
            break;
            case "LessFavorites":
                $this->OrderSQL = " ORDER BY `Favorites` ASC,`ID` ASC";
            break;
        }
    }

    public function Database($DatabaseString)
    {
        $this->SelectedDatabase = "`$DatabaseString`";
    }

    //GET

    public function Get_ResultsArray()
    {
        return $this->Results_TotalArray;
    }

    //ENGINE

    protected function BuildAarrays()
    {
        try{
            $this->BuildEqualArray();
            $this->BuildSelectArray();
            $this->BuildLikeArray();
            $this->BuildNotNULLArray();
            $this->BuildIsNULLArray();
        }catch(Exception){
            throw new Exception("fAILED BUILD ARRAYS");
        }
    }

    protected function BuildSelectArray()
    {
        if($this->Count == true){
            $this->SelectQuery .= " COUNT(*) ";
        }else{

            if(count($this->SelectArray) > 0)
            {
                for($i = 0; $i < count($this->SelectArray); $i++)
                {
                    $X = "`".$this->SelectArray[$i]."`";
                    if($i == 0)
                    {
                        $this->SelectQuery .= $X;
                    }else{
                        $this->SelectQuery .= ", $X";
                    }  
                }
            }else{
                $this->SelectQuery .= " * ";
            }
        }
    }

    protected function BuildEqualArray()
    {
        if(count($this->EqualsArray) > 0){
            for($i = 0; $i < count($this->EqualsArray); $i++)
            {
                //echo "Actual numbr: ".$i;
                //echo "Ocurrence 1<br>";
                if($this->isset_FilterSearch($this->EqualsArray[$i][1]) == true){     
                    //echo "Passed for ".$this->EqualsArray[$i][1]."<br>";

                $X = "`".$this->EqualsArray[$i][0]."`";

                if($i === 0)
                {
                    //echo "1 reeach<br>";
                    $this->BuildQuery .= " WHERE ".$X." = :V$this->ActualBind ";  
                    $this->ResultsArray += [":V$this->ActualBind" => $this->EqualsArray[$i][1]];     
                }else{   
                    //echo "2 reach<br>";
                    $this->BuildQuery .= " AND ".$X." = :V$this->ActualBind ";
                    $this->ResultsArray += [":V$this->ActualBind" => $this->EqualsArray[$i][1]];     
                }  

                //echo "Finished Reach<br>";
                $this->ActualBind++;
                }else{
                    //echo "Skipped<br>";
                }
            }  
        }
    }

    protected function BuildNotNULLArray()
    {
        if(count($this->NotNullArray) > 0)
        {
            for($i = 0; $i < count($this->NotNullArray); $i++)
            {
                $X = "`".$this->NotNullArray[$i][0]."`";
                $this->NotNull_Query .= " AND ".$X." IS NOT NULL ";
            }
        }
    }

    protected function BuildIsNULLArray()
    {
        if(count($this->IsNullArray) > 0)
        {
            for($i = 0; $i < count($this->IsNullArray); $i++)
            {
                $X = "`".$this->IsNullArray[$i][0]."`";
                $this->NotNull_Query .= " AND ".$X." IS NULL ";
            }
        }
    }

    protected function isset_FilterSearch($Var)
    {
        if($Var == "") return false;
        if(is_null($Var)) return false;
        if(ctype_space($Var) == true) return false;
        return true;
    }

    protected function BuildLikeArray()
    {
        if(count($this->LikeArray) > 0)
        {
            if(count($this->EqualsArray) > 0)
            {
                for($i = 0; $i < count($this->LikeArray); $i++)
                {   
                    if($this->isset_FilterSearch($this->LikeArray[$i][1]) == true){
                        $X = "`".$this->LikeArray[$i][0]."`";
                        $this->LikeQuery .= "AND $X LIKE CONCAT(:V$this->ActualBind,'%') ";
                        $this->ResultsArray += [":V$this->ActualBind" => $this->LikeArray[$i][1]];
                        $this->ActualBind++;
                    }
                }
                
            }else{
                for($i = 0; $i < count($this->LikeArray); $i++)
                {
                    if($this->isset_FilterSearch($this->LikeArray[$i][1]) == true){

                        $X = "`".$this->LikeArray[$i][0]."`";
                        if($i == 0){
                            $this->LikeQuery .= " WHERE $X LIKE CONCAT(:V$this->ActualBind,'%') ";
                            $this->ResultsArray += [":V$this->ActualBind" => $this->LikeArray[$i][1]];
                        }else{
                            $this->LikeQuery .= " AND $X LIKE CONCAT:V$this->ActualBind,'%') ";
                            $this->ResultsArray += [":V$this->ActualBind" => $this->LikeArray[$i][1]];
                        }
                        $this->ActualBind++;
                    }
                }
            }
            
        }
    }

    protected function Get_Results()
    {
        try{

            if(empty($this->SelectedDatabase)) throw new Exception("Missing Database FROM");

            $SQL = "SELECT $this->SelectQuery FROM $this->SelectedDatabase $this->BuildQuery $this->IsNull_Query $this->NotNull_Query $this->LikeQuery $this->OrderSQL LIMIT $this->StarterID,$this->Max_ItemsPerPage";
            $X = $this->Database->prepare($SQL);

            if($this->Debug == true)
            {
                var_dump($this->Debug);
                var_dump($SQL);
                var_dump($this->ResultsArray);
            }
            

            if($X->execute($this->ResultsArray)){
                $temp = array();
                while($z = $X->fetch()){ $temp[] = $z;}

                $this->Results_Fetch_Result = $temp;
                return $temp;
            }else{
                echo "Not launched Results";
            }

        }
        catch(Exception $Err)
        {
            $this->Error = true;
            $this->DebugMessage = $Err->getMessage();
            $this->Message = "FAILED SEARCH: No Results Found";
        }
    }

    protected function Count_Total_Results()
    {
        try{
            if(empty($this->SelectedDatabase)) throw new Exception("Missing Database FROM");

            $SQL = "SELECT COUNT(*) FROM $this->SelectedDatabase $this->BuildQuery $this->IsNull_Query $this->NotNull_Query $this->LikeQuery $this->OrderSQL";
            $X = $this->Database->prepare($SQL);

            if($this->Debug == true)
            {
                var_dump($this->Debug);
                var_dump($SQL);
                var_dump($this->ResultsArray);
            }

            if($X->execute($this->ResultsArray)){
                $temp = array();

                while($z = $X->fetch()){ $temp[] = $z;}

                $Count = isset($temp[0][0]) ? $temp[0][0] : 0;

                $this->Results_Total_Count = $Count;
                return $Count;
            }

        }
        catch(Exception $Err)
        {
            $this->Error = true;
            $this->DebugMessage = $Err->getMessage();
            $this->Message = "FAILED SEARCH: No Count Results Found";
        }  
    }

    protected function Count_ActualPage_Results()
    {
        try{

            if(empty($this->SelectedDatabase)) throw new Exception("Missing Database FROM");

            $SQL = "SELECT SQL_CALC_FOUND_ROWS `ID` FROM $this->SelectedDatabase $this->BuildQuery $this->IsNull_Query $this->NotNull_Query $this->LikeQuery $this->OrderSQL LIMIT $this->StarterID,$this->Max_ItemsPerPage";
            $X = $this->Database->prepare($SQL);

            if($X->execute($this->ResultsArray)){
                $temp = array();
                while($z = $X->fetch()){
                    $temp[] = $z;
                }

                $Count = isset($temp[0][0]) ? $temp[0][0] : 0;

                $this->Results_ThisPage_Count = $Count;
                return $Count;
            }

        }
        catch(Exception $Err)
        {
            $this->Error = true;
            $this->DebugMessage = $Err->getMessage();
            $this->Message = "FAILED SEARCH: No Count Results Found";
        }  
    }

    public function Execute_Ex()
    {
        try{
            $this->BuildAarrays();

            if($this->Count_Total_Results() > 0 && $this->Count_ActualPage_Results() > 0){ 
                $this->Get_Results(); 
            }

            $this->Calculate_Pages();
        }catch(Exception)
        {
            echo "ERROR EXECUTION";
        }
    }


    
    
}

/*
class Advanced_Pagination_Executer extends Advanced_Pagination{

//Default Values

protected $Max_ItemsPerPage = 10;
protected $Actual_Page = 1;
protected $StarterID = 1;

//Results

protected $Results_Total_Count = 0;
protected $Results_Total_Pages = 0;
protected $Results_Fetch_Result = array();
protected $Results_ThisPage_Count = 0;
protected $Results_NextPage = false;
protected $Results_BackPage = false;


public function Set_Page($Page = 1)
    {
        $Page = filter_var($Page,FILTER_VALIDATE_INT) == true ? $Page : 1;
        $Page = abs($Page);
        $Page = floor($Page);
        $this->Actual_Page = $Page; 
        $this->StarterID = $Page > 1 ? ($Page - 1) * $this->Max_ItemsPerPage : $this->StarterID - 1; 
    }

    public function Max_Items_Value($Items){ $this->Max_ItemsPerPage = $Items; }

    public function Get_Total_Count(){return $this->Results_Total_Count;}

    public function Get_Fetch(){return $this->Results_Fetch_Result;}

    public function Get_Total_Pages(){return $this->Results_Total_Pages;}

    public function Get_Actual_Page(){return $this->Actual_Page;}

    public function Get_ThisPage_Count(){return $this->Results_ThisPage_Count;}

    public function Get_NextPage(){return $this->Results_NextPage;}

    public function Get_BackPage(){return $this->Results_BackPage;}

    protected function Calculate_Pages(){ 
        $this->Results_Total_Pages = ceil($this->Results_Total_Count/$this->Max_ItemsPerPage);
        
        $this->Results_NextPage = $this->Actual_Page >= $this->Results_Total_Pages ? false : true;
        $this->Results_BackPage = $this->Actual_Page > 1 ? true : false;
    }

    protected function addToURL( $key, $value, $url) {
        $info = parse_url( $url );
        $query2 = isset($info['query']) == true ? $info['query'] : "";

        parse_str( $query2, $query );
        return $info['scheme'] . '://' . $info['host'] . $info['path'] . '?' . http_build_query( $query ? array_merge( $query, array($key => $value ) ) : array( $key => $value ) );
        
    }

    public function Execute()
    {
        try{
            $this->BuildAarrays();

            if($this->Count_Total_Results() > 0 && $this->Count_ActualPage_Results() > 0){ 
                $this->Get_Results(); 
            }

            $this->Calculate_Pages();
        }catch(Exception)
        {
            echo "ERROR EXECUTION";
        }
    }

    public function Draw_Pagination()
    {
        $Max = 5;
        $ActualPage = $this->Actual_Page;
        $NumberPages = $this->Results_Total_Pages;

        $ActualWeb = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $Next = $ActualPage >= $NumberPages ? $NumberPages : $ActualPage+1;
        $Back = $ActualPage < 0 ? 1 : $ActualPage-1;
        $Back = $ActualPage > $NumberPages ? $NumberPages : $Back;

        if($ActualPage > 1){
            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$Back,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>< Back</a></span>";
        }

        if($ActualPage > $Max)
        {
            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",1,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>1</a></span>";
            echo "<span> ... </span>";
        }


        for($i = $ActualPage-$Max; $i < $ActualPage; $i++){
            echo $i < 1 ? "" : "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$i,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>$i</a></span>";  
        }

        if($this->Count_Total_Results() > 0){
            echo "<span class='ActualPage'> [ $ActualPage ] </span>";
        }

        

        for($i = $ActualPage+1; $i < $ActualPage + $Max; $i++){

            echo $i >= $NumberPages ? "" : "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$i,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>$i</a></span>";
            

        }

        if($ActualPage < $NumberPages){
            echo "...";
            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$NumberPages,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>$NumberPages</a></span>";

            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$Next,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>Next ></a></span>";
        }
    }





}

*/
?>