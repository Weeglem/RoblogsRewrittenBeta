<?php
exit();
    include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
    $x = new Includes();
    $x->Database();
    $x->User_Data();

    $Database = new Database();
    $z = $Database->Prepare_Data("SELECT `ID` FROM `decals_data`");

    foreach($z as $GameID){
        $ID = $GameID["ID"];

        $X = $Database->FetchColumn("SELECT `Creator` from `decals_data` WHERE `ID` = ?",array($ID));
        $X = $X == false ? 0 : $X;
        
        $GETUSER = $Database->FetchColumn("SELECT `ID` FROM `users_data` WHERE `Username` = ?",array($X));
        $GETUSER = $GETUSER == false ? 0 : $GETUSER;

        $UPDATE = $Database->UpdateData("UPDATE `decals_data` SET `Creator` = :Creator WHERE `ID` = :GameID",
        array(
            [":Creator",$GETUSER,PDO::PARAM_STR],
            [":GameID",$ID,PDO::PARAM_INT],



        ));

        var_dump($UPDATE);


    }
?>