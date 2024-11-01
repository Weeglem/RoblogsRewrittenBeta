<?php 
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$x->Session();
$x->User_Data();
$x->Game_Data();
$x->Decal_Data();
$x->Model_Data();
$x->Pagination();
$x->WebsiteCategories();

try{
    $Get_Name = Website::Get("Name");
    $Get_Creator = Website::Get("Creator",1);
    $Get_Category = Website::Get("Category");
    $Get_Roblox = Website::Get("Roblox");
    $Get_Page = Website::Get("page",1);
    $Get_Order = Website::Get("order","Newest");
    $Get_Search = Website::Get("type","Games");
    $Get_Status = Website::Get("status","Approved");

    //PLACEHOLDERS
    $Item_BarDisplay = "Items";
    $Pending_BarDisplay = "";
    $Rate_BarDisplay = "All ";
    $Roblox_BarDisplay = "";
    $Category_BarDisplay = "";

    $Get_CreatorValue = "";
    if($Get_Creator != "")
        {
            try{
                $x = User_DataController::GetID($Get_Creator);
                $Get_CreatorValue = $x;
            }catch(Exception $err)
            {
                $Get_CreatorValue = null;
            }
        }else{
            $Get_CreatorValue = null;
        }

        switch($Get_Search)
        {
            case "Games":
                $DatabaseFilter = "games_data";
                $FilterClass = "Game";
            break;
            case "Models":
                $DatabaseFilter = "models_data";
                $FilterClass = "Model";
            break;
            case "Decals":
                $DatabaseFilter = "decals_data";
                $FilterClass = "Decal";
            break;
            default;
                $DatabaseFilter = "";
            break;

        }

        switch($Get_Status)
        {
            default:
            case "Approved":
                $Get_Status_Var = 1;
            break;
            case "Pending":
                $Get_Status_Var = 0;
            break;
    }
    
    $Pagination = new Advanced_Pagination();
    $Pagination->Max_Items_Value(24);
    $Pagination->Order($Get_Order);
    $Pagination->Set_Page($Get_Page);

    $Pagination->Database($DatabaseFilter);
    $Pagination->Select(array("ID"));

    $Pagination->Equals(array(
        ["Status",$Get_Status_Var],
        ["category",$Get_Category],
        ["category_roblox",$Get_Roblox],
        ["Public",1]));
    $Pagination->Like(array(["Name",$Get_Name]));
    $Pagination->Execute_Ex();

    $TotalCount = $Pagination->Get_Total_Count();
    $TotalArray = $Pagination->Get_Fetch();

}catch(Exception $err)
{
    $Message = $err->getMessage();
    var_dump($Message);
}

function DrawCategories($phone = false)
{
    global $Get_Search,$Item_BarDisplay;
    $Get_Value = $Get_Search;
    $Active = "";
    $Categories = array(["Games","Games"],["Models","Models"],["Decals","Decals"],["Datas Pack","DataPack"]);

    if($phone == true)
    {
        echo "<select name='type' class='Mobile'>";
        foreach($Categories as $Category)
        {
            $Active = $Category[1] == $Get_Value ? "selected" : "";
            echo '<option value="'.$Category[1].'" '.$Active.'>'.$Category[0].'</option>';
        }
        echo "</select>";
        return;
    }

    foreach($Categories as $Category)
    {
        if($Category[1] == $Get_Value)
        {
            $Active = "Active_ListItem";
            $Item_BarDisplay = $Category[0];
        }else{
            $Active = "";
        }
        
        echo '<li class="Desktop"><a href="'.WebsiteLinks::Create_Link("type",$Category[1]).'" class="Search_ListItem '.$Active.'">'.$Category[0].'</a></li>';
    }
}

function DrawFilter($phone = false)
{
    global $Get_Order,$Rate_BarDisplay;
    $Get_Value = $Get_Order;
    $Categories = array(["Newest","Newest"],["Oldest","Oldest"],["Most favorites","MostFavorites"],["Least favorites","LessFavorites"]);
    $Active = "";

    if($phone == true)
    {
        echo "<select name='order' class='Mobile'>";
        foreach($Categories as $Category)
        {
            $Active = $Category[1] == $Get_Value ? "selected" : "";
            echo '<option value="'.$Category[1].'" '.$Active.'>'.$Category[0].'</option>';
        }
        echo "</select>";
        return;
    }

    foreach($Categories as $Category)
    {
        if($Category[1] == $Get_Value)
        {
            $Active = "Active_ListItem";
            $Rate_BarDisplay = $Category[0];
        }else{
            $Active = "";
        }
        
        echo '<li class="Desktop"><a href="'.WebsiteLinks::Create_Link("order",$Category[1]).'" class="Search_ListItem '.$Active.'">'.$Category[0].'</a></li>';
    }
}

function DrawStatus($phone = false)
{
    global $Get_Status,$Pending_BarDisplay;
    $Get_Value = $Get_Status;
    $Categories = array(["Approved","Approved"],["Pending","Pending"]);

    if($phone == true)
    {
        echo "<select name='status' class='Mobile'>";
        foreach($Categories as $Category)
        {
            $Active = $Category[1] == $Get_Value ? "selected" : "";
            echo '<option value="'.$Category[1].'" '.$Active.'>'.$Category[0].'</option>';
        }
        echo "</select>";
        return;
    }

    foreach($Categories as $Category)
    {
        if($Category[1] == $Get_Value)
        {
            $Active = "Active_ListItem";
            //CRAPPY TRICK
            if($Category[1] != "Approved"){ $Pending_BarDisplay = $Category[0]; }
            
        }else{
            $Active = "";
        }

        $Active = $Category[1] == $Get_Value ? "Active_ListItem" : "";
        
        echo '<li class="Desktop"><a href="'.WebsiteLinks::Create_Link("status",$Category[1]).'" class="Search_ListItem '.$Active.'">'.$Category[0].'</a></li>';
    }
}

$Preload_ROBLOXTags = WebsiteCategories::GetRobloxVersions();
$Preload_CategoriesTAGS = WebsiteCategories::GetCategories();

function DrawCategories_ROBLOX($phone=false)
{
    global $Preload_ROBLOXTags,$Get_Roblox,$Roblox_BarDisplay;
    $Get_Value = $Get_Roblox;
    $Categories = $Preload_ROBLOXTags;

    if($phone == true)
    {
        echo "<select name='Roblox' class='Mobile'>";
        foreach($Categories as $Category)
        {
            $Active = "";

            if($Category[0] == $Get_Value)
            {   //Sucks but works
                $Active = "selected" ;
                $Roblox_BarDisplay = $Category[1] == "All" ? "" : $Category[1];
            }

            echo '<option value="'.$Category[0].'" '.$Active.'>'.$Category[1].'</option>';
        }
        echo "</select>";
        return;
    }

    foreach($Categories as $Category)
    {
        $Active = $Category[0] == $Get_Value ? "Active_ListItem" : "";
        echo '<li class="Desktop"><a href="'.WebsiteLinks::Create_Link("Roblox",$Category[0]).'" class="Search_ListItem '.$Active.'">'.$Category[1].'</a></li>';
    }
    return;
}

function DrawCategories_Categories($phone = false)
{
    global $Preload_CategoriesTAGS,$Get_Category,$Category_BarDisplay;
    $Get_Value = $Get_Category;
    $Categories = $Preload_CategoriesTAGS;

    if($phone == true)
    {
        echo "<select name='Category' class='Mobile'>";
        foreach($Categories as $Category)
        {
            $Active = "";

            if($Category[0] == $Get_Value)
            {   //Sucks but works
                $Active = "selected" ;
                $Category_BarDisplay = $Category[1] == "All" ? "" : $Category[1];
            }

            echo '<option value="'.$Category[0].'" '.$Active.'>'.$Category[1].'</option>';
        }
        echo "</select>";
        return;
    }

    foreach($Categories as $Category)
    {
        $Active = $Category[0] == $Get_Value ? "Active_ListItem" : "";
        echo '<li class="Desktop"><a href="'.WebsiteLinks::Create_Link("Category",$Category[0]).'" class="Search_ListItem '.$Active.'">'.$Category[1].'</a></li>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Games_Explore"; $Page_Title = "Featured Games"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>

<form method="GET">
<div class="Games_Container">
    <section class="Games_Explore_Div">
        <h1>Workshop</h1>
        <div class="">
            <ul>
                <li><a class="Link" href="./Uploads/New.php">Submit New Asset</a></li>
                <li><p class="FakeLabel">Asset Type: </p></li>
                <?=DrawCategories();?>
                <?=DrawCategories(true);?>
                <br>
                <li><p class="FakeLabel">Filter By: </p></li>
                <?=DrawFilter()?>
                <?=DrawFilter(true)?>
                <br>
                <li><p class="FakeLabel">Category: </p></li>
                <?=DrawCategories_Categories();?>
                <?=DrawCategories_Categories(true);?>
                <br>
                <li><p class="FakeLabel">Roblox: </p></li>
                <?=DrawCategories_ROBLOX();?>
                <?=DrawCategories_ROBLOX(true);?>
                <br>
                <li><p class="FakeLabel">Status: </p></li>
                <?=DrawStatus()?>
                <?=DrawStatus(true)?>
            </ul>
        </div>
    </section>

    <section class="Games_Search_Results_Div ">
        <div class="Game_Search_Details">
            <h3> <?=$Rate_BarDisplay." ".$Pending_BarDisplay." ".$Roblox_BarDisplay." ".$Category_BarDisplay." ".Website::EncodeString($Item_BarDisplay)?></h3>
            <div class="pages">
                <label for="Name" class="NameSearch" style="">Search Name: </label>
                <input type="search" class="SameSize" value="<?=Website::EncodeString($Get_Name)?>" name="Name" id="Name">
                <button class="SameSizeB">Search</button>
            </div>
        </div>
        <section class="Games_Results_Display">
            
            <?php

                function DrawItems($array = array())
                {
                    global $FilterClass;

                    if(count($array) < 0){return "No Items Found";}

                    foreach($array as $Item)
                    {
                        $ID = $Item["ID"];
                        //Game_DataController::UpdateFavorites($ItemID); //DEBUG LINE

                        $x = $FilterClass."_data";
                        $ItemData = new $x($ID);

                        $Name = $ItemData->Name();
                        $Name = strlen($Name) > 17 ? substr($Name,0,17)."..." : $Name;
                        $Thumbnail = $ItemData->Thumbnail();
                        $CreatorID = $ItemData->Creator();
                        $Type = $ItemData->Content_Type();
                        $Status = $ItemData->Status();

                        try{
                            $CreatorName = $ItemData->Creator_Username();
                        }catch(Exception){
                            $CreatorName = "[Unknown]";
                        }
                        
                        $Favorites = $ItemData->Favorites_Count();

                        echo '
                        <figure class="Game_Result_Div">
                            <a class="Workshop_Thumbnail_Preview" href="'.WebsiteLinks::Asset_Page($ID,$Type).'">
                                <img src="'.$Thumbnail.'" class="WorkshopThumbnail_Normal border" alt="'.$Name.'">
                                <p class="Game_Title">'.$Name.'</p>
                            </a>
                            <p class="Game_Info">Owner: <a href="'.WebsiteLinks::Profile_Page($CreatorID).'" class="Link">'.$CreatorName.'</a></p>
                            
                            <p class="Game_Info Favorites">Favorites: '.$Favorites.'</p>
                        </figure>';


                    }
                }

                echo $Pagination->Get_ThisPage_Count() > 0 ? DrawItems($TotalArray) : "No Results Found";

            ?>
        </section>
        <div class="Pagination"><?=$Pagination->Draw_Pagination()?></div>
    </section>
</form> <!-- eat this-->
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>