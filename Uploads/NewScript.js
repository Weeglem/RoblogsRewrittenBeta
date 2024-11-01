const API_Links = {
    "Game" : "http://localhost/API/Uploads/New/Game.php",
    "Decal" : "http://localhost/API/Uploads/New/Decal.php",
    "Model" : "http://localhost/API/Uploads/New/Model.php",
    "AssetPack" : "http://localhost/API/Uploads/New/AssetPack.php",
}

function Disable_ID_Div(ID,Hide)
{
    let Div = document.getElementById(ID);
    Div.style.display = Hide == true ? "none" : "block";
    let Children = Div.children;
    for(i = 0; i < Children.length; i++)
    {
        Children[i].disabled = Hide == true ? true : false;
    }
}

function HideButton(ID,Hide)
{
    let Div = document.getElementById(ID);
    Div.style.display = Hide == true ? "none" : "inline-block";
    Div.disabled = Hide == true ? true : false;
}


var UploadLink = null;
var MainForm = document.getElementById("ItemUploaderForm");
var MainSwitch =  document.getElementById("SelectedUploadType");

//ERRORS Containers
function SetErrorMessage(JsonError,HTMLid){if(JsonError != undefined){document.getElementById(HTMLid).innerText = JsonError;}}
    
//LEAVE BUTTON
document.getElementById("LeaveWindow").addEventListener("click",function(){
    if(confirm("Are you sure you want to cancel the Asset Upload?"))
    {
        history.go(-1);
    }
})


//THIS JUST HIDES UNNESARY INPUTS FOR THE REQUIERED ITEM
MainSwitch.addEventListener("change",function(){
    switch(MainSwitch.value)
    {
        case "Game":
            console.log("Selected: Game");
            Disable_ID_Div("NameDiv",false);
            Disable_ID_Div("AboutDiv",false);
            Disable_ID_Div("RobloxDiv",false);
            Disable_ID_Div("CategoryDiv",false);
            Disable_ID_Div("ZipFile_Div",false);
            Disable_ID_Div("ThumbnailFile_Div",false);
            Disable_ID_Div("DecalFile_Div",true);
            
            Disable_ID_Div("BasicInformation_Fieldset",false);
            Disable_ID_Div("RequiredFiles_Fieldset",false);
            Disable_ID_Div("ItemOptions_Fieldset",false);
            HideButton("SubmitButton",false);

        break;
    
        case "Model":

            console.log("Selected: Model");
            UploadLink = API_Links["Model"];
            Disable_ID_Div("NameDiv",false);
            Disable_ID_Div("AboutDiv",false);
            Disable_ID_Div("RobloxDiv",false);
            Disable_ID_Div("CategoryDiv",false);
            Disable_ID_Div("ZipFile_Div",false);
            Disable_ID_Div("ThumbnailFile_Div",false);
            Disable_ID_Div("DecalFile_Div",true);
            Disable_ID_Div("BasicInformation_Fieldset",false);
            Disable_ID_Div("RequiredFiles_Fieldset",false);
            Disable_ID_Div("ItemOptions_Fieldset",false);
            HideButton("SubmitButton",false);

        break;
    
        case "Decal":
            console.log("Selected: Decal");
            UploadLink = API_Links["Decal"];
            Disable_ID_Div("NameDiv",false);
            Disable_ID_Div("AboutDiv",false);
            Disable_ID_Div("RobloxDiv",true);
            Disable_ID_Div("CategoryDiv",true);
            Disable_ID_Div("ZipFile_Div",true);
            Disable_ID_Div("ThumbnailFile_Div",true);
            Disable_ID_Div("DecalFile_Div",false);
            Disable_ID_Div("BasicInformation_Fieldset",false);
            Disable_ID_Div("RequiredFiles_Fieldset",false);
            Disable_ID_Div("ItemOptions_Fieldset",false);
            HideButton("SubmitButton",false);
        break;
    
        case "AssetPack":
            console.log("Selected: AssetPack");
            UploadLink = API_Links["AssetPack"];
            Disable_ID_Div("NameDiv",false);
            Disable_ID_Div("AboutDiv",false);
            Disable_ID_Div("RobloxDiv",false);
            Disable_ID_Div("CategoryDiv",false);
            Disable_ID_Div("ZipFile_Div",false);
            Disable_ID_Div("ThumbnailFile_Div",true);
            Disable_ID_Div("DecalFile_Div",true);
            Disable_ID_Div("BasicInformation_Fieldset",false);
            Disable_ID_Div("RequiredFiles_Fieldset",false);
            Disable_ID_Div("ItemOptions_Fieldset",false);
            HideButton("SubmitButton",false);
        break;
    
        default:
            UploadLink = null;
            Disable_ID_Div("NameDiv",true);
            Disable_ID_Div("AboutDiv",true);
            Disable_ID_Div("RobloxDiv",true);
            Disable_ID_Div("CategoryDiv",true);
            Disable_ID_Div("ZipFile_Div",true);
            Disable_ID_Div("ThumbnailFile_Div",true);
            Disable_ID_Div("DecalFile_Div",true);
            Disable_ID_Div("BasicInformation_Fieldset",true);
            Disable_ID_Div("RequiredFiles_Fieldset",true);
            Disable_ID_Div("ItemOptions_Fieldset",true);
            HideButton("SubmitButton",true);
        break;  
    }
})

MainForm.addEventListener("submit",function(ev){
    ev.preventDefault();
    if(API_Links[MainSwitch.value] == undefined){return false};

    let UploadLink = API_Links[MainSwitch.value];
    let FormCollect = new FormData(MainForm);

    let Request = new XMLHttpRequest();
    Request.addEventListener("load",function()
    {
        console.log(Request.response)
        console.log(Request.status);
        Form_EventHandler(Request.response);
    })

    Request.open("POST",UploadLink,true);
    Request.send(FormCollect);

},true)

function Form_EventHandler(JsonGet)
{
    let JSON_data;
    SetErrorMessage("","NameError")
    SetErrorMessage("","RobloxError");
    SetErrorMessage("","CategoryError");
    SetErrorMessage("","DecalFileError")
    SetErrorMessage("","AudioFileError")
    SetErrorMessage("","ThumbFileError")
    SetErrorMessage("","ZipFileError");
    try{
        JSON_data = JSON.parse(JsonGet)   
    }catch(err){
        alert("Unknown Error: "+err.message);
    }

    if(JSON_data.success == true){Disable_ID_Div("FinishedTask",false); document.getElementById("ItemUpload_Div").remove(); return; }
    SetErrorMessage(JSON_data.Name,"NameError")
    SetErrorMessage(JSON_data.Roblox,"RobloxError");
    SetErrorMessage(JSON_data.Category,"CategoryError");
    SetErrorMessage(JSON_data.Decal,"DecalFileError")
    SetErrorMessage(JSON_data.Audio,"AudioFileError")
    SetErrorMessage(JSON_data.Thumbnail,"ThumbFileError")
    SetErrorMessage(JSON_data.Zip,"ZipFileError");
    


    console.log(JSON_data);
}