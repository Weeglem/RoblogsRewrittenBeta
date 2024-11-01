var Allies_Page = 1;
var Enemies_Page = 1;
var Group_ID = document.getElementById("GroupID").value;

var Allie_NextButton_UI = document.getElementById("Next-Button-Ally")
var Allie_BackButton_UI = document.getElementById("Back-Button-Ally")
var Allie_Flex_Div = document.getElementById("AlliesDrawFlex")

var Enemy_NextButton_UI = document.getElementById("Next-Button-Enemy")
var Enemy_BackButton_UI = document.getElementById("Back-Button-Enemy")
var Enemy_Flex_Div = document.getElementById("EnemiesDrawFlex")
var Has_Ally = false;
var Has_Enemy = false;


//WORKS AS A SWITCH
function Draw_Allies(type,GroupName,GroupID){
    Max = 15;
    GroupName = GroupName.length > 15 ? GroupName.substring(0,15)+"..." : GroupName;


    let figure = document.createElement("figure")
    let img = document.createElement("img")
    let itemname = document.createElement("p")

    itemname.innerText = GroupName;
    itemname.className = "ElementTitle"


    img.src = "../Website/IMG/RoblogsCrossroadsThumbnail.png"
    img.alt =" Username"
    img.className = "Group-Icon_Small border"

    figure.appendChild(img)
    figure.appendChild(itemname)

    if(type == 0){Allie_Flex_Div.appendChild(figure)}
    if(type == 1){Enemy_Flex_Div.appendChild(figure)}

}


//BOTH CONVERTERS
function Set_Data_Ally(JSONdata)
{   Allie_BackButton_UI.innerText = "";
    Allie_NextButton_UI.innerText = "";
    Allie_Flex_Div.innerText = "";
    try{
        var Json_Data = JSON.parse(JSONdata);
    }catch(err){
        Allie_Flex_Div.innerText = "Error while fetching Allies"
        return;
    }

    if(Json_Data["Items"].length == 0){
        Allie_Flex_Div.innerText = "This groups has no allies"
        return;
    }

    Has_Ally = true;
    let Json_NextPage = Json_Data["Next"]
    let Json_BackPage = Json_Data["Back"]
    let Json_ActualPage = Json_Data["Page"]

    if(Json_NextPage == true)
    {
        Allie_NextButton_UI.innerText = "Next >"
    }
    
    if(Json_BackPage == true)
    {
        Allie_BackButton_UI.innerText = "< Back"
    }

    Allies_Page = Json_ActualPage

    for(let i = 0; i < Json_Data["Items"].length; i++){
        
        let GroupName = Json_Data["Items"][i].GroupName
        let GroupID = Json_Data["Items"][i].GroupID

        Draw_Allies(0,GroupName,GroupID)
    }

}

function Set_Data_Enemy(JSONdata)
{
    Enemy_BackButton_UI.innerText = ""
    Enemy_NextButton_UI.innerText = "";
    Enemy_Flex_Div.innerText = "";
    try{
        var Json_Data = JSON.parse(JSONdata);
    }catch(err){
        Enemy_Flex_Div.innerText = "Something failed while fetching Enemies";
        return;
    }

    if(Json_Data["Items"].length == 0){
        Enemy_Flex_Div.innerText = "This group has no enemies";
        document.getElementById("EnemiesGroupDiv").style.display = "none"
        return;
    }
       
    Has_Enemy = true;
    document.getElementById("EnemiesGroupDiv").style.display = "block"
    let Json_NextPage = Json_Data["Next"]
    let Json_BackPage = Json_Data["Back"]
    let Json_ActualPage = Json_Data["Page"]

    if(Has_Enemy == true && Has_Ally == true){document.getElementById("Separator").style.display = "block"}


    if(Json_NextPage == true)
    {
        Enemy_NextButton_UI.innerText = "Next >"
    }
    
    if(Json_BackPage == true)
    {
        Enemy_BackButton_UI.innerText = "< Back"
    }

    Enemies_Page = Json_ActualPage

    for(let i = 0; i < Json_Data["Items"].length; i++){
        
        let GroupName = Json_Data["Items"][i].GroupName
        let GroupID = Json_Data["Items"][i].GroupID

        Draw_Allies(1,GroupName,GroupID)
    }

}

//GET DATA FROM THE API   
function GetData(Type){
    let Page = "";
    let Enemy = "";

    switch(Type){
        default:
        case 0: //ALLY
            Page = Allies_Page;
            Enemy = 0;
        break;
        case 1:
            Page = Enemies_Page;
            Enemy = 1;
        break;
    }

    let Request = new XMLHttpRequest();
    Request.onload = function(){ 
        if(Type == 0){Set_Data_Ally(Request.response)}
        if(Type == 1){Set_Data_Enemy(Request.response)}
    }

    Request.open("GET","../API/Groups/GetAllies.php?group="+Group_ID+"&enemy="+Enemy+"&page="+Page,true);
    Request.send();
}

//YES this code sucks, Weeglem.

Allie_BackButton_UI.addEventListener("click",function()
{
    Allies_Page = Allies_Page > 0 ? Allies_Page - 1 : 1
    GetData(0)
})

Allie_NextButton_UI.addEventListener("click",function()
{
   Allies_Page++
   GetData(0) 
})

Enemy_BackButton_UI.addEventListener("click",function()
{
    Enemies_Page = Enemies_Page > 0 ? Enemies_Page - 1 : 1
    GetData(1)
})

Enemy_NextButton_UI.addEventListener("click",function()
{
   Enemies_Page++
   GetData(1) 
})


window.addEventListener("load",function(){
    GetData(0)
    GetData(1)
})