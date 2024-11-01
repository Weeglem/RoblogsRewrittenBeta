<?php
class Pagination{
    protected $Database;

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

    protected $Result_Message = "";


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

    public function Get_Message(){return $this->Result_Message;}

    public function Set_Message($Message){$this->Result_Message = $Message;}

    
    protected function Calculate_Pages(){ 
        $this->Results_Total_Pages = ceil($this->Results_Total_Count/$this->Max_ItemsPerPage);
        
        $this->Results_NextPage = $this->Actual_Page >= $this->Results_Total_Pages ? false : true;
        $this->Results_BackPage = $this->Actual_Page > 1 ? true : false;
    }
   
    public function Execute()
    {/*
        echo "Started";

        var_dump($this->Count_Total_Results());
        var_dump($this->Count_ActualPage_Results());
        var_dump($this->Get_Results());
*/
        if($this->Count_Total_Results() > 0 && $this->Count_ActualPage_Results() > 0){ 
            $this->Get_Results(); 
        }else{
            $this->Set_Message("No Results Found");
        }
        $this->Calculate_Pages();
        return true;
    }

    protected function addToURL( $key, $value, $url) {
        $info = parse_url( $url );
        $query2 = isset($info['query']) == true ? $info['query'] : "";

        parse_str( $query2, $query );
        return $info['scheme'] . '://' . $info['host'] . $info['path'] . '?' . http_build_query( $query ? array_merge( $query, array($key => $value ) ) : array( $key => $value ) );
        
    }


    public function Draw_Pagination_OLD()
    {
         #https://stackoverflow.com/questions/5809774/manipulate-a-url-string-by-adding-get-parameters

        

        $ActualPage = $this->Actual_Page;
        $NumberPages = $this->Results_Total_Pages;

        $ActualWeb = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $Next = $ActualPage >= $NumberPages ? $NumberPages : $ActualPage+1;
        $Back = $ActualPage < 0 ? 1 : $ActualPage-1;
        $Back = $ActualPage > $NumberPages ? $NumberPages : $Back;

        if($ActualPage > 1){
            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",1,$ActualWeb),ENT_QUOTES, 'UTF-8')."'><< </a></span>";
            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$Back,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>Prev </a></span>";
        }else{
            echo "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
        }

        if($ActualPage < $NumberPages){
            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$Next,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>Next</a></span>";
            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$NumberPages,$ActualWeb),ENT_QUOTES, 'UTF-8')."'> >></a></span>";
        }else{
            echo "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
        }  
    }

    public function Draw_ForumPost_Pagination()
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
            echo "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",1,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>1, </a></span>";
            echo "<span> ... </span>";
        }


        for($i = $ActualPage-$Max; $i < $ActualPage; $i++){
            echo $i < 1 ? "" : "<span><a class='Paginatior' href='".htmlspecialchars($this->addToURL("page",$i,$ActualWeb),ENT_QUOTES, 'UTF-8')."'>$i,</a></span>";  
        }

        if($this->Count_Total_Results() > 0){
            echo "<span class='ActualPage'>  [$ActualPage]  </span>";
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
?>