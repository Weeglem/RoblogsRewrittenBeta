<?php
exit();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();

    $Database = new Database();
    $Execute = $Database->Prepare_Data_BindValue("SELECT * FROM `forums_threads`");
    //var_dump($Execute);

    foreach($Execute as $Reply)
    {
        var_dump($Reply);

        $ID = $Reply["ID"];
        $Category = $Reply["Category"];

        $Title = $Reply["Name"];
        $Comment = $Reply["Topic"];
        
        $Owner = $Reply["Owner"];
        $Public = $Reply["Public"];
        $Deleted = $Reply["Deleted"];
        $Pinned = $Reply["Pinned"];
        $Date = $Reply["Date"];

        $Execute = $Database->Prepare_Data_BindValue("INSERT INTO `forums_posts`
        (`ID`, `CategoryID`, `Name`, `Topic`, `Owner`, `Pinned`, `Deleted`, `Date`)
        VALUES 
        (:ParentID,:CategoryID,:PostName,:PostTopic,:PostOwner,:PostPinned,:PostDeleted,:PostDate)",
        array(
            [":ParentID",$ID],
            [":CategoryID",$Category],
            [":PostName",$Title],
            [":PostTopic",$Comment],
            [":PostOwner",$Owner],
            [":PostPinned",$Pinned],
            [":PostDeleted",$Deleted],
            [":PostDate",$Date],
        ));
        echo "Finished Task for Reply $ID<br>";
    }


?>
