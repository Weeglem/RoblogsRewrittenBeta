<?php
exit();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();

    $Database = new Database();
    $Execute = $Database->Prepare_Data_BindValue("SELECT * FROM `forums_replies`");
    //var_dump($Execute);

    foreach($Execute as $Reply)
    {
        $ParentID = $Reply["ThreadID"];
        $Owner = $Reply["Owner"];
        $Deleted = $Reply["Deleted"];
        $Date = $Reply["Date"];
        $Category = $Reply["ForumCategory"];
        $Comment = $Reply["Comment"];
        $ID = $Reply["ID"];



        $Execute = $Database->Prepare_Data_BindValue("INSERT INTO `forums_posts`
        (`ParentID`, `CategoryID`, `Topic`, `Owner`, `Pinned`, `Deleted`, `Date`) 
        VALUES 
        (:ParentID,:CategoryID,:PostTopic,:PostOwner,:PostPinned,:PostDeleted,:PostDate)",
        array(
            [":ParentID",$ParentID],
            [":CategoryID",$Category],
            [":PostTopic",$Comment],
            [":PostOwner",$Owner],
            [":PostPinned",0],
            [":PostDeleted",$Deleted],
            [":PostDate",$Date],
        ));
        echo "Finished Task for Reply $ID<br>";
    }


?>
