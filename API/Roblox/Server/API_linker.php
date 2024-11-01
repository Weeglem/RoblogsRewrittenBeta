<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header("Content-Type: text/plain");
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Database();
$JobID = isset($_GET["id"]) ? $_GET["id"] : 0;
$Database = new Database();

$ValidateJob = $Database->FetchColumn("SELECT 1 FROM `rccserver_games` WHERE `JobID` = ? AND `Started` = 0 ",array($JobID));
if($ValidateJob == false){exit(http_response_code(404));}
$SecurityKey = $Database->FetchColumn("SELECT `SecurityKey` FROM `rccserver_games` WHERE `JobID` = ? AND `Started` = 0",array($JobID));
if($SecurityKey == false){exit(http_response_code(404));}

//SCRIPT
?>
local Players = game:GetService("Players");
local Server = Game:GetService("NetworkServer");
local MaxTime = 50; --INTERNAL CLOCK LOOP
local ActualPing = 0; --AVOID GET CACHING
local JobID = <?=$JobID?>;
local Hash = "<?=$SecurityKey?>";

KillServer = coroutine.create(function()
    while wait() do   
        if Server:GetClientCount() == 0 then 
            for i = MaxTime,0, -1 do
                print("Internal Server Clock: "..i); -- Internal Player Checker
                if Server:GetClientCount() == 0 then
                    if i == 0 then
                        print("Killing game with JobID"..JobID);
                        game:HttpGet("http://localhost/API/Roblox/Server/KillServer.php?id="..JobID.."&sk="..Hash) --KILL SERVER PING
                        game:Shutdown() 
                        return;                 
                    end
                    wait(1) -- Wait There are Players
                else
                    wait(1) -- Game is Running with players
                end
            end
        else
            wait(1)
        end
    end
end)

--SEND ONLINE USERS TO WEBSITE
PingUpdatePlayers = coroutine.create(function()
    while wait() do
        local TotalPlayers = Server:GetClientCount();
        local GamePort = Server.Port
        ActualPing = ActualPing + 1
        x = ActualPing
        game:HttpGet("http://localhost/API/Roblox/Server/UpdatePlayers.php?JobID="..JobID.."&Hash="..Hash.."&Players="..TotalPlayers.."&sk="..Hash)
        print("Updating Players count...")
        wait(15)
    end
end)

print("ROBLOGS server Script Launched");
game:HttpGet("http://localhost/API/Roblox/Server/FinalizeSetup.php?id="..JobID.."&sk="..Hash) --KILL SERVER PING
coroutine.resume(KillServer);
coroutine.resume(PingUpdatePlayers)


