game:service("RunService"):run() 
function waitForChild(parent, childName) 
while true do 
local child = parent:findFirstChild(childName) 
if child then 
return child 
end 

parent.ChildAdded:wait()
end 
end 

function getKillerOfHumanoidIfStillInGame(humanoid) 
local tag = humanoid:findFirstChild("creator") 
if tag then 
local killer = tag.Value 
if killer.Parent then 
return killer 
end 
end 
return nil 
end 

function onDied(victim, humanoid) 
local killer = getKillerOfHumanoidIfStillInGame(humanoid) 
local victorId = 0 

if killer then 
victorId = killer.userId 
end 
end 

function createDeathMonitor(plr) 
if plr.Character then 
local humanoid = waitForChild(plr.Character, "Humanoid") 
humanoid.Died:connect( function () onDied(plr, humanoid) end ) 
end 
end 
game:service("Players").ChildAdded:connect( function (plr) createDeathMonitor(plr) plr.Changed:connect( function (property) if property=="Character" then createDeathMonitor(plr) end end ) end ) function characterRessurection(plr) if plr.Character then local humanoid = plr.Character.Humanoid humanoid.Died:connect(function() wait(5) plr:LoadCharacter() end) end end game:service("Players").PlayerAdded:connect(function(plr) characterRessurection(plr) plr.Changed:connect(function(name) if name=="Character" then characterRessurection(plr) end end) end) game:GetService("Visit") plr = game:getService("Players"):CreateLocalPlayer(0) plr:SetSuperSafeChat(false); game:GetService("Visit") plr:LoadCharacter()