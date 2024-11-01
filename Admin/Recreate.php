<?php
exit();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();
    $x->User_Data();

    $Database = new Database();
    $z = $Database->FetchColumn("SELECT COUNT(*) FROM `decals_data`");
    var_dump($z);

    for($i=0;$i <= $z; $i++)
    {
        $a= $Database->FetchColumn("SELECT `Owner` from `decals` WHERE `ID` = ?",array($i));
        echo $a;
        var_dump($i);

/*
        $Z = $Database->FetchColumn("SELECT `ID` FROM `users_data` WHERE `Username` = ?",array($x));
        $UserID = $Z == false ? 0 : $Z;
        var_dump($UserID);
*/
        $d= $Database->UpdateData("UPDATE `decals_data` SET `Creator` = :Creator WHERE `ID` = :GAMEID",array(
            [":Creator",$a],
            [":GAMEID",$i],
        ));

        var_dump($d);
        

    }





?>