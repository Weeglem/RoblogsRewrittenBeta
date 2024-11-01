<?php
    $Model = isset($_GET["id"]) ? $_GET["id"] : exit(json_encode(array("Error" => "Invalid id input")));
    if(filter_var($Model,FILTER_VALIDATE_INT) == false) exit(json_encode(array("Error" => "Invalid id input")));

    $Link = $_SERVER["DOCUMENT_ROOT"]."/IDE/ClientToolbox.aspx/Toolbox/rbxm/".basename($Model).".rbxm";
    if(!file_exists($Link)) exit(json_encode(array("Error" => "Invalid Toolbox Model id")));

    $Data = file_get_contents($Link);
    if(!$Data) exit(json_encode(array("Error" => "Failed to Find Data")));
    
    header('Content-type: application/xml');
    exit($Data);
?>