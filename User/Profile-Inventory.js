var Assets_NextPage_UI = document.getElementById("Next-Button-Assets")
var Assets_BackPage_UI = document.getElementById("Back-Button-Assets")
var Assets_Flex_Div_UI = document.getElementById("Assets-Flex-Showcase")
var Assets_Select_UI = document.getElementById("AssetType");

var Assets_ActualPage = 1;
var ProfileID = document.getElementById("UserID").value;

function DrawAssets(JSONdata){
    Assets_Flex_Div_UI.innerText = "";
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
        Assets_NextPage_UI.innerText = "Next >";
    }

    if(Json_BackPage == true)
    {
        Assets_BackPage_UI.innerText = "< Back";
    } 

    Assets_ActualPage = Json_ActualPage

    function Draw(Name,Thumbnail,Link,ItemID)
    {
        let figure = document.createElement("figure")
        let img = document.createElement("img")
        let itemname = document.createElement("p")
        let alink = document.createElement("a")

        alink.href= Link;

        figure.className = "Asset-Item"
        
        Name = Name.length > 15 ? Name.substring(0,15)+"..." : Name;

        itemname.innerText = Name
        itemname.className = "Asset-Name"

        img.src = Thumbnail
        img.alt = Name
        img.className = "AssetThumb_Inventory border"

        
        alink.appendChild(img)
        alink.appendChild(itemname)
        figure.appendChild(alink)
        Assets_Flex_Div_UI.appendChild(figure)
    }

    for(let i = 0; i < Json_Data["Items"].length; i++){

        let Name = Json_Data["Items"][i].Name;
        let Thumbnail = Json_Data["Items"][i].Thumbnail;
        let Link = Json_Data["Items"][i].Link;
        let ItemID = Json_Data["Items"][i].ItemID
        

        Draw(Name,Thumbnail,Link,ItemID)
    }


}

function GetAssets()
{
    Assets_NextPage_UI.innerText = "";
    Assets_BackPage_UI.innerText = "";

    let Request = new XMLHttpRequest();
    let AssetType = Assets_Select_UI.value;
    let UserID = ProfileID;
    let Page = Assets_ActualPage;

    Request.onload = function(){ DrawAssets(Request.response);}
    Request.open("GET","../API/User/Inventory.php?id="+UserID+"&Type="+AssetType+"&page="+Page,true);
    Request.send()
}



Assets_BackPage_UI.addEventListener("click",function(){
    Assets_ActualPage = Assets_ActualPage > 0 ? Assets_ActualPage - 1 : 1
    GetAssets()
})

Assets_NextPage_UI.addEventListener("click",function(){
    Assets_ActualPage++
    GetAssets()
})

Assets_Select_UI.addEventListener("change",function(){
    Assets_ActualPage = 1;
    GetAssets();
})

window.addEventListener("load",function(){
    GetAssets();
})
