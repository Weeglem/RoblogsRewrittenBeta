<?php

include("$_SERVER[DOCUMENT_ROOT]/Roblogs_Server/RCC/config.php");
include("$_SERVER[DOCUMENT_ROOT]/$_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");

$Include = new Includes();
$Include->Database();   //PDO Database Set up
$Include->User_Data(); //Roblogs Users Class for getting User apparence array
$Include->Model_Data(); //Roblogs Model Class  ""
$Include->Game_Data(); //Roblogs Games Class Used for grabbing download server file

class RCC_Server extends RCC_Config{
    protected $JobID = 1; //RANDOMIZE THIS ID ALWAYS, UNIQUE IDENTIFIER
    protected $Database;

    //ENGINE
    /** 
        * Change RCC Ip and Port in Config
    */ 
    public function __construct(){ 
        //COW RANDOMIZER
        $this->JobID = random_int(1,99999); 
        $this->Database = new Database();
        echo "Started RCC conection";
        return true; //CREATION HANDLER
    }

    protected function CreateXML(string $Script = 'print("Hello World!")',int $JobID = 0,$Expiration = 1)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns2="http://roblox.com/RCCServiceSoap" xmlns:ns1="http://roblox.com/" xmlns:ns3="http://roblox.com/RCCServiceSoap12">
            <SOAP-ENV:Body>
                <ns1:OpenJob>
                    <ns1:job>
                        <ns1:id>'.$JobID.'</ns1:id>
                        <ns1:expirationInSeconds>'.$Expiration.'</ns1:expirationInSeconds>
                        <ns1:category>1</ns1:category>
                        <ns1:cores>321</ns1:cores>
                    </ns1:job>
                    <ns1:script>
                        <ns1:name>Script</ns1:name>
                        <ns1:script>'.$Script.'</ns1:script>
                    </ns1:script>
                </ns1:OpenJob>
            </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>';

        return $xml;
    }

    /** 
        * Calls RCC with Script Request, 
        * ReturnTrue Returns true if false, or B64 if true 
    */ 
    protected function RequestRCC(bool $ReturnTrue = false,string $Script = '',int $JobID = null, int $Expiration = 1)
    {
        $JobID = $JobID == null ? $this->JobID : $JobID;

        try{
            $ch = curl_init("http://$this->RCC_BaseURL:$this->RCC_Port");
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,4); //TIME BEFORE DEATH
            curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Content-Type: text/xml" ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->CreateXML($Script,$JobID,$Expiration));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $ResultXML = curl_exec($ch);
        }catch(Exception $err){throw new Exception("Failed to Contact Intances Server");}

        if($ReturnTrue != false)
        {
            $result = str_replace(
                [ "<ns1:value>", "</ns1:value>", "</ns1:OpenJobResult>", "<ns1:OpenJobResult>", "<ns1:type>", "</ns1:type>", "<ns1:table>", "</ns1:table>", "</ns1:OpenJobResult>", "</ns1:OpenJobResponse>", "</SOAP-ENV:Body>", "</SOAP-ENV:Envelope>" ],"",
                strstr(str_replace([ "LUA_TSTRING", "LUA_TNUMBER", "LUA_TBOOLEAN", "LUA_TTABLE" ],"",$ResultXML),"<ns1:value>"));
                
            return $result;
        }

        return true;
    }

    protected function SaveToFolder(string $B64,string $Asset_Folder = "./",string $Name = "Render")
    {
        $ImageData = base64_decode($B64);
        file_put_contents($Asset_Folder."$Name.png",$ImageData);
    }

    //USEFUL FOR WORK

    /** 
        * Pings RCC to confirm if actual Game is Live or returns false if crashed or unreachable
    */ 
    
    public function Job_Online(int $JobID = 1){
        return $this->RequestRCC(true,"return true",$JobID) == "true" ? false : true;
    }

    /** 
        * Creates a new Game Instance w/ Random Port, RETURNS JOB ID
    */ 
    public function NewGame(int $GameID = 1)
    {
        $Data = new Game_Data($GameID);
        $URL = $Data->Asset_Link();

        $Port = rand(2888,25565);

        //game:Load("'.$URL.'")

        $Script =  //GAME INSTANCE SCRIPT
        '
            -- declarations
            local port = '.$Port.'
            local sleepTime = 10

            -- establish this peer as the Server
            local ns = game:service("NetworkServer")
            game:Load("'.$URL.'")
            --game:service("Players"):setAbuseReportUrl("http://www.roblox.com/AbuseReport/InGameChatHandler.ashx")

            -- utility
            function waitForChild(parent, childName)
                while true do
                    local child = parent:findFirstChild(childName)
                        if child then
                                return child
                            end
                            parent.ChildAdded:wait()
                        end
                    end

                    -- returns the player object that killed this humanoid
                    -- returns nil if the killer is no longer in the game
                    function getKillerOfHumanoidIfStillInGame(humanoid)

                        -- check for kill tag on humanoid - may be more than one - todo: deal with this
                        local tag = humanoid:findFirstChild("creator")

                        -- find player with name on tag
                        if tag then
                            local killer = tag.Value
                            if killer.Parent then -- killer still in game
                                return killer
                            end
                        end

                        return nil
                    end

                    -- send kill and death stats when a player dies
                    function onDied(victim, humanoid)
                        local killer = getKillerOfHumanoidIfStillInGame(humanoid)

                        local victorId = 0
                        if killer then
                            victorId = killer.userId
                            print("STAT: kill by " .. victorId .. " of " .. victim.userId)
                            --game:httpGet("http://www.roblox.com/Game/Statistics.ashx?TypeID=15&UserID=" .. victorId .. "&AssociatedUserID=" .. victim.userId .. "&AssociatedPlaceID=0")
                        end
                        print("STAT: death of " .. victim.userId .. " by " .. victorId)
                        --game:httpGet("http://www.roblox.com/Game/Statistics.ashx?TypeID=16&UserID=" .. victim.userId .. "&AssociatedUserID=" .. victorId .. "&AssociatedPlaceID=0")
                    end

                    -- listen for the death of a Player
                    function createDeathMonitor(player)
                        -- we dont need to clean up old monitors or connections since the Character will be destroyed soon
                        if player.Character then
                            local humanoid = waitForChild(player.Character, "Humanoid")
                            humanoid.Died:connect(
                                function ()
                                    onDied(player, humanoid)
                                end
                            )
                        end
                    end

                    -- listen to all Players Characters
                    game:service("Players").ChildAdded:connect(
                        function (player)
                            createDeathMonitor(player)
                            player.Changed:connect(
                                function (property)
                                    if property=="Character" then
                                        createDeathMonitor(player)
                                    end
                                end
                            )
                        end
                    )

                    -- This code might move to C++
                    function characterRessurection(player)
                        if player.Character then
                            local humanoid = player.Character.Humanoid
                            humanoid.Died:connect(function() wait(5) player:LoadCharacter() end)
                        end
                    end
                    game:service("Players").PlayerAdded:connect(function(player)
                        print("Player " .. player.userId .. " added")
                        characterRessurection(player)
                        player.Changed:connect(function(name)
                            if name=="Character" then
                                characterRessurection(player)
                            end
                        end)
                    end)

                    if port>0 then
                        -- Now start the connection
                        ns:start(port, sleepTime) 
                    end

                    game:service("RunService"):run()
        ';

        $NewGame = $this->RequestRCC(false,$Script,$this->JobID,$this->Games_SecondsTimer);

        $Execute = $this->Database->Prepare_Data_BindValue(
            "
                INSERT INTO `rccserver_servers`
                (`JobID`,`GameID`,`Creator`,`Private`)
                VALUES
                (:JobID,:GameID,:Creator,:PrivateRoom)
            ",array(
                [":JobID",$this->JobID],
                [":GameID",$GameID],
                [":Creator",4], //CREATED BY USER, USE FOR PRIVATE ROOMS OR IDENTIFIER
                [":PrivateRoom",0], //CAN EVERYONE JOIN??? LOCAL TESTING AND SOLO ROOMS
            ));

        echo "Created new game Instance ID: ".$this->JobID."<br>";
        echo "Game Port: $Port <br>";
        //RETURN JOB ID
        return $this->JobID;
    }

    /** 
        * Kill Game Instance
    */ 
    public function Kill_DBGameJob(int $JobID = 1)
    {
        $Execute = $this->Database->Execute("
        DELETE FROM `rccserver_servers` 
        WHERE `JobID` = :JobID
        ",
        array(
            [":JobID",$JobID])
        );
        return true;
    }

    /** 
        * Ping the database and returns all servers Arrays, Useful for player lists
    */ 
    public function Get_Games_InstancesDB()
    {
        $Array = $this->Database->Prepare_Data_BindValue(
            "
                SELECT `JobID`
                FROM `rccserver_servers`
            ");

        return $Array;
    }

    /** 
        * DEBUG USAGE ONLY /// Kills all jobs that are not online, Debug usage only, Is laggy as it pings RCC each array, preferable use KillGameJob
    */ 
    public function Kill_DBDeadGamesJobs()
    {
        $Array = $this->Get_Games_InstancesDB();
        foreach($Array as $Instance)
        {
            if($this->Job_Online($Instance["JobID"]) != true)
            {
                $this->Kill_GameJob($Instance["JobID"]);
                echo "Removed Instance: ".$Instance["JobID"]."<br>";
            }
        }
    }


    /** 
        * Render a Item, Requieres ID and a link to it, Returns B64 if success
    */ 
    public function New_Render_Model(int $ItemID = 1,bool $SaveToFile = true)
    {
        $Data = new Model_Data($ItemID);
        $URL = $Data->Asset_Link();
        $Script =  //RENDER SCRIPT
        '
            --game.Workspace:InsertContent("http://localhost/Assets/Load/Model.php?id=4")
            game.Workspace:InsertContent("'.$URL.'")
            return(game:GetService("ThumbnailGenerator"):Click("PNG", '.$this->Model_Thumbnail["X"].', '.$this->Model_Thumbnail["Y"].', true))
        ';

        $RCC_string = $this->RequestRCC(true,$Script);
        if($RCC_string == null) throw new Exception("Something went wrong????");

        if($SaveToFile == true){
            $this->SaveToFolder($RCC_string,$this->Model_RenderFolder);
            return true;
        }else{
            return $RCC_string;
        }
    }

    /** 
        * Render a Game, Requieres ID and a link to it, Returns B64 if success
    */ 
    public function New_Render_Game(int $ItemID = 1,bool $SaveToFile = true)
    {
        $Data = new Game_Data($ItemID);
        $URL = $Data->Asset_Link();
        $Script =  //RENDER SCRIPT
        '
            --game:Load("http://localhost/Assets/Load/Game.php?id=4")
            game:Load("'.$URL.'")
            return(game:GetService("ThumbnailGenerator"):Click("PNG", '.$this->Game_Thumbnail["X"].', '.$this->Game_Thumbnail["Y"].', true))
        ';

        $RCC_string = $this->RequestRCC(true,$Script);
        if($RCC_string == null) throw new Exception("Something went wrong????");

        if($SaveToFile == true){
            $this->SaveToFolder($RCC_string,$this->Model_RenderFolder);
            return true;
        }else{
            return $RCC_string;
        }
    }

    



}

$RCC = new RCC_Server();
//$RCC->New_Render_Model(6);
//$Game = $RCC->NewGame(1); //CREATE GAME INSTANCE RETURNS JOB ID
//$RCC->Job_Online(1); //VERIFY IF THE INSTANCE IS LIVE
//$RCC->Kill_GameJob(96354); //KILL DEAD INSTANCES
//$RCC->Kill_DeadGamesJobs(); //KILL ALL DEAD GAMES INSTANCES, PINGS RCC AND CAN BE LAGGY

$RCC->Kill_DBDeadGamesJobs();