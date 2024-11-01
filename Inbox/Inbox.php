<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
$x->Pagination();
$x->User_Data();
$x->Message_Data();


$Page = isset($_GET["page"]) == true ? $_GET["page"] : 1;
$Get_Name = isset($_GET["Name"]) ? $_GET["Name"] : "";

$Inbox_Pagination = new Inbox_Pagination(Session::Get_ID());
$Inbox_Pagination->Max_Items_Value(20);
$Inbox_Pagination->Set_Page($Page);
$Inbox_Pagination->Execute();

$TotalCount = $Inbox_Pagination->Get_Total_Count();
$Messages_Array = $Inbox_Pagination->Get_Fetch();


function Draw_Messages($Array = array())
{
    foreach($Array as $Message)
    {
        $Message = new Message_Data($Message["ID"]);
        $Message_Sender = $Message->From();
        $Message_SenderName = $Message->From_Username();
        $Message_Subject = $Message->Subject();
        $Message_Date = $Message->Date();
        $Message_ID = $Message->ID();

        echo '
            <div class="Message_Row">
                <div class="Button_Col"><input type="checkbox" name="check_list[]" value="'.$Message_ID.'"></div>
                <div class="Subject_Col"><a href="./Message.php?id='.$Message_ID.'" class="Link">'.$Message_Subject.'</a></div>
                <div class="Sender_Col"><a href="#" class="Link">'.$Message_SenderName.'</a></div>
                <div class="Date_Col"><!--Sun Aug 4 20:58:55-->'.$Message_Date.'</div>
            </div>
        ';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Message_Inbox"; $Page_Title = "My Inbox"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>

<div class="Inbox_Container border">
    <div class="Inbox_Options">
        <h1>My Inbox ( 0 )</h1>
        <hr>
        <ul>
            <li><a class="Search_ListItem" href="">Recived Messages</a></li>
            <li><a class="Search_ListItem" href="">Sent Messages</a></li>
            <li><a class="Search_ListItem" href="NewPrivate.php">New Message</a></li>
            <li><p class="Search_ListItem">Delete cheked Messages</p></li>
        </ul>
    </div>
    <section class="Inbox_Box">    
        <div class="Header_Row BrightOldBlue">
            <div class="Button_Col"><input type="checkbox" onclick="toggle(this)" name="" id=""></div>
            <div class="Subject_Col">Subject</div>
            <div class="Sender_Col">From</div>
            <div class="Date_Col">Date</div>
        </div>  
        <form class="Messages_Row" method="POST" id="InboxBody"><?=$Inbox_Pagination->Count_ActualPage_Results() > 0 ? Draw_Messages($Messages_Array) : "You haven't recived any Messages."?></form>
        <div class="Pagination"><?=$Inbox_Pagination->Draw_Pagination()?></div>
        <button type="button" onclick="DeleteMessages_Inbox()" id="DeleteSelected">Delete Messages</button>
    </section>
    
</div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="../Website/JS/SelectAll.js"></script>
<script src="./Scripts/Inbox_DeleteMessage.js"></script>

    
</script>
</body>
</html>