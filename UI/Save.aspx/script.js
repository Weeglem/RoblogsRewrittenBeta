var SystemMessage = document.getElementById("SystemMessage");
var FinalMessage = document.getElementById("FinalMessage");

//MENUS
var MainMenu = document.getElementById("MainMenu");
var NewItem = document.getElementById("NewItem");
var UpdateItem = document.getElementById("UpdateItem");
var FinalMenu = document.getElementById("FinalizeMenu");

//CHANGE PAGE BUTTONS
var NewItem_Button = document.getElementById("NewItem_Button")
var UpdateItem_Button = document.getElementById("UpdateItem_Button");

//CHANGE PAGE HANDLER
function ChangePage(pagename)
{
    MainMenu.style.display = "none";
    UpdateItem.style.display = "none";
    NewItem.style.display = "none";
    FinalMenu.style.display = "none";
    pagename.style.display = "block";
}

function DestroyPage(pagename){pagename.remove();}

NewItem_Button.addEventListener("click",function(){ChangePage(NewItem)})
UpdateItem_Button.addEventListener("click",function(){ChangePage(UpdateItem)})

//CLOSE WINDOW HANDLER
var CloseWindowButton = document.querySelectorAll("#ExitWindow");
for(let i = 0; i < CloseWindowButton.length; i++){CloseWindowButton[i].addEventListener("click",function(){window.close()});}

//BACK WINDOW HANDLER
var BackMainButton = document.querySelectorAll("#BackMainWindow");
for(let i = 0; i < BackMainButton.length; i++){BackMainButton[i].addEventListener("click",function(){ChangePage(MainMenu)});}


//UPDATE MODEL HANDLER
var CloseWindowButton = document.querySelectorAll("#UpdateItemButton");
for(let i = 0; i < CloseWindowButton.length; i++){CloseWindowButton[i].addEventListener("click",function(ev){alert(CloseWindowButton[i].value)});}

function UpdateItemButton(itemID)
{
    if(confirm("Are you sure you want to update this Model?"))
    {
        try{
            let RoblogsModel_UpdateURL = "http://localhost/API/Roblox/Studio/Model/Edit.php?id="+itemID;
            ChangePage(FinalMenu);
            window.external.WriteSelection().Upload(RoblogsModel_UpdateURL);
            FinalMessage.innerText = "Item updated Successfuly."
            ChangePage(FinalMenu);
            return;
        }catch(ex)
        {
            ChangePage(FinalMenu)
            alert(ex.message);
        }
    }
}

//NEW MODEL HANDLER

var NewModel_Button = document.getElementById("NewItemForm");
NewModel_Button.addEventListener("submit",function(e){
    try{
        e.preventDefault();
        let RoblogsModelURL = "http://localhost/API/Roblox/Studio/Model/New.php";
        let Name = encodeURIComponent(document.getElementById("Name").value);
        let Description = encodeURIComponent(document.getElementById("Description").value);
        let Private = encodeURIComponent(document.getElementById("Private").value);
        let query = "?name="+Name+"&desc="+Description+"&priv="+Private;

        ChangePage(FinalMenu);
        window.external.WriteSelection().Upload(RoblogsModelURL+query);
        FinalMessage.innerText = "Item Uploaded Successfully to ROBLOGS, make sure it appeared in your inventory."
    }catch(ex)
    {
        ChangePage(FinalMenu)
        alert(ex.message);
    }
});

document.addEventListener("DOMContentLoaded",function(){ChangePage(MainMenu)})

//REQUEST USER ITEMS






