//ROBLOX GAME LAUNCHER
if(document.getElementById("CommentsType").value == "Game"){
    if(window.external.IsRobloxAppIDE != undefined){
        document.getElementById("OpenRobloxStudio").style.display = "Block"
        document.getElementById("OpenRobloxStudio").addEventListener("click",function(){
            if(confirm("Make sure to save all your current progress in case the Studio crashes, also make sure to have installed the RobloxLib before launching, else it wont work."))
            {
                let GameID = document.getElementById("CommentsID").value
                let Script = "game:Load('http://localhost/Assets/Load/Game.php?id=+"+GameID+"')"
                window.external.GetApp().CreateGame("44340105256").ExecScript(Script)
            }     
        })
    }
}