let API_Links = {
    "ChangeAvatar" : "../API/Account/Edit/ProfilePicture.php",
    "ChangePassword" : "../API/Account/Edit/Password.php",
    "ChangeAboutMe" : "../API/Account/Edit/About.php",
    "MyContact" : "../API/Account/Edit/ContactInfo.php",
    "SetPrivacy" : "../API/Account/Edit/Privacy.php",
}

let API_Confirm = {
    "ChangePassword" : "Are you sure you want to change your password?",
    "ChangeAboutMe" : "Are you sure you want to replace your biography?",
    "ChangeAvatar" : "Are you sure you want to change your Avatar",
}
let ErrorsBoxes = document.querySelectorAll("#Error");
let Buttons = document.querySelectorAll("button[type='submit']");
let Target = "";

document.getElementById("MenusShow").addEventListener("click",function(evento){
    let Target = evento.target;
    for(let i = 0; i < ErrorsBoxes.length; i++){ ErrorsBoxes[i].innerText = "";}

    //IF INVALID EXIT
    if(Target.tagName != "BUTTON"){return;}
    
    evento.preventDefault();
    console.log(Target.value);
    if(Target.value == "AddContact" || Target.value == "RemoveContact"){return;} //QUICK PATCH

    let TargetValue = Target.value;
    let FormHTML = document.getElementById(TargetValue);
    let Req = new XMLHttpRequest();
    let FormDa = new FormData(FormHTML);
    let ApiLink = API_Links[TargetValue];

    //IS LINK VALID
    if(API_Links[TargetValue] == undefined){alert("Invalid LINK")}

    Req.addEventListener("load",function(){
        console.log("Sent request to: "+ApiLink);
        console.log(Req.response);

        let JSON_Data = JSON.parse(Req.response);
        if(JSON_Data.success != true){
            //CLEAN
            document.getElementById(TargetValue).querySelector("#Error").innerText = JSON_Data.message;
            return;
        }
            
        alert("done");  
    })

    Req.open("POST",ApiLink,true);
    Req.send(FormDa);
     
})

function SetPage(Exc)
{

    document.getElementById("PrivacySettings").style.display = "none";
    document.getElementById("AccountSettings").style.display = "none";
    document.getElementById("ContactInfo").style.display = "none";
    document.getElementById("ProfileSettings").style.display = "none";

    document.getElementById(Exc).style.display = "block";
        
}

var Temporal =  "";
document.getElementById("Menus").addEventListener("click",function(ev){
    
    switch(ev.target.id)
    {
        case "ShowProfileSettings":
            SetPage("ProfileSettings");
        break;

        case "ShowContactInfo":
            SetPage("ContactInfo");
        break;

        case "ShowAccountSettings":
            SetPage("AccountSettings");
        break;

        case "ShowPrivacySettings":
            SetPage("PrivacySettings");
        break;
    }

    if(Temporal != ""){
        Temporal.classList.remove("Active_ListItem");
    }

    Temporal = ev.target;
    Temporal.classList.add("Active_ListItem");
    console.log("Finished");

})

SetPage("ProfileSettings");


//ROBLOGS SETTING HANDLER
//WEEGLEM