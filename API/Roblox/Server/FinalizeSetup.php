<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header("Content-Type: text/plain");
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$Database = new Database();
$JobID = isset($_GET["id"]) ? $_GET["id"] : 0;
$SK = isset($_GET["sk"]) ? $_GET["sk"] : 0;

$Validate = $Database->FetchColumn("SELECT 1 FROM `rccserver_games` WHERE `JobID` = ? AND `SecurityKey` = ? ",array($JobID,$SK));
if($Validate == false){exit(http_response_code(404));}

$Execute = $Database->Execute("UPDATE `rccserver_games` SET `Started` = 1 WHERE `JobID` = :JobID",
array([":JobID",$JobID]));
exit();
?>