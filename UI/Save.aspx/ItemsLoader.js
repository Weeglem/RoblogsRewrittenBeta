var Items_Showcase = document.getElementById("ItemsShowcase");
var NextPage_UI = document.getElementById("Next-Page");
var BackPage_UI = document.getElementById("Back-Page");
var ActualPage = 1;

function DrawItems_Choose(ItemID,ItemName)
{
    let Li = document.createElement("li");
    
    let Button = document.createElement("button");
    Button.value = ItemID;
    Button.id = "UpdateItemButton"
    Button.innerText = "Update"
    Button.setAttribute("onclick","UpdateItemButton(this.value)")

    let P = document.createElement("p")
    P.innerText= ItemName

    P.appendChild(Button)
    Li.appendChild(P);
    Items_Showcase.appendChild(Li)
}

function Assets_Parse(JSONdata)
{
    Items_Showcase.innerText = "";
    console.log(JSONdata);

    try{
        var Json_Data = JSON.parse(JSONdata);
    }catch(err){
        console.log("Error Parse");
        Assets_Flex_Div_UI.innerText = "Failed to get items.";
        return;
    }

    if(Json_Data["Items"].length == 0)
    {
        Assets_Flex_Div_UI.innerText = "No Items of this class found";
        return; 
    }

    let Json_NextPage = Json_Data["Next"]
    let Json_BackPage = Json_Data["Back"]
    let Json_ActualPage = Json_Data["Page"]

    if(Json_NextPage == true)
    {
            NextPage_UI.innerText = "Next >";
    }
    
    if(Json_BackPage == true)
    {
        BackPage_UI.innerText = "< Back";
    } 
    
    ActualPage = Json_ActualPage

    for(let i = 0; i < Json_Data["Items"].length; i++){

        let Name = Json_Data["Items"][i].Name;
        let ItemID = Json_Data["Items"][i].ItemID
        DrawItems_Choose(ItemID,Name)
    }
}

function GetAssets()
{
    NextPage_UI.innerText = "";
    BackPage_UI.innerText = "";

    let Request = new XMLHttpRequest();
    let Type = document.getElementById("Itemtype").value;
    let Page = ActualPage;

    Request.onload = function(){ Assets_Parse(Request.response);}
    Request.open("GET","http://localhost/API/Roblox/Studio/GetInventory.php?Type="+Type+"&page="+Page,true);
    Request.send()
}


BackPage_UI.addEventListener("click",function(){
    ActualPage = ActualPage > 0 ? ActualPage - 1 : 1
    GetAssets()
})

NextPage_UI.addEventListener("click",function(){
    ActualPage++
    GetAssets()
})

window.addEventListener("load",function(){
    GetAssets();
})