var Members_Page = 1;
var Member_Rank = 0;
var Group_ID = document.getElementById("GroupID").value;

var BackButton_Member_UI = document.getElementById("Back-Button-Member");
var NextButton_Member_UI = document.getElementById("Next-Button-Member");
var Member_Div_Flex_UI = document.getElementById("MembersDrawFlex")
var Rank_Chooser = document.getElementById("Rank")


function DrawMembers(JSONdata){
    Member_Div_Flex_UI.innerText = "";
    try{
        var Json_Data = JSON.parse(JSONdata);
    }catch(err){
        Member_Div_Flex_UI.innerText = "Error while fetching members";
        return;
    }

    

    if(Json_Data["Items"].length == 0){
        Member_Div_Flex_UI.innerText = "No Members Found";
        return;
    }

    let Json_NextPage = Json_Data["Next"]
    let Json_BackPage = Json_Data["Back"]
    let Json_ActualPage = Json_Data["Page"]

    if(Json_NextPage == true)
    {
        NextButton_Member_UI.innerText = "Next >"
    }

    if(Json_BackPage == true)
    {
        BackButton_Member_UI.innerText = "< Back"
    }



    Members_Page = Json_ActualPage

    function DrawMembers(Username,ID,Rank){
        let figure = document.createElement("figure")
        let img = document.createElement("img")
        let itemname = document.createElement("p")
        let itemsub = document.createElement("p")

        itemname.innerText = Username;
        itemname.className = "ElementTitle"


        img.src = "http://localhost/Website/avatars/"+ID+".png"
        img.alt = Username
        img.className = "AvatarsThumbnail_Small"

        itemsub.innerText = Rank
        itemsub.className = "ElementSub"

        figure.appendChild(img)
        figure.appendChild(itemname)
        figure.appendChild(itemsub)
        Member_Div_Flex_UI.appendChild(figure)

    }

    for(let i = 0; i < Json_Data["Items"].length; i++){
        let Username = Json_Data["Items"][i].Username;
        let UserID = Json_Data["Items"][i].UserID;
        let Rank = Json_Data["Items"][i].Rank;


        DrawMembers(Username,UserID,Rank);
    }

}

function GetMembers(){
    let Request = new XMLHttpRequest();
    let Rank = Rank_Chooser.value;

    console.log(Rank)
    Member_Div_Flex_UI.innerText = "";
    NextButton_Member_UI.innerText = "";
    BackButton_Member_UI.innerText = "";
    Request.onload = function(){ 
        DrawMembers(Request.response);
    }

    Request.open("GET","../API/Groups/GetMembers.php?group="+Group_ID+"&rank="+Rank+"&page="+Members_Page,true);
    Request.send();
}

window.addEventListener("load",function(){
    GetMembers()
})

NextButton_Member_UI.addEventListener("click",function(){
    Members_Page++
    GetMembers();

})

BackButton_Member_UI.addEventListener("click",function(){
    Members_Page = Members_Page > 0 ? Members_Page - 1 : 1
    GetMembers();
})

Rank_Chooser.addEventListener("change",function(){
    Members_Page = 1
    GetMembers();

})