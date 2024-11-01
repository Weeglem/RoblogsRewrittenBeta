var MainForm = document.getElementById("ItemUploaderForm");
MainForm.addEventListener("submit",function(Ev){
    Ev.preventDefault();

    let FormCollect = new FormData(MainForm);
    let UploadLink = MainForm.action;
    let Request = new XMLHttpRequest();
    Request.addEventListener("load",function()
    {
        console.log(Request.response)
        console.log(Request.status);
        Form_EventHandler(Request.response);
    })

    Request.open("POST",UploadLink,true);
    Request.send(FormCollect);

})

//ERRORS Containers
function SetErrorMessage(JsonError,HTMLid){
    console.log(HTMLid);
    console.log(JsonError);
    if(JsonError != undefined)
        {
            if(document.getElementById(HTMLid) != null){
            document.getElementById(HTMLid).innerText = JsonError;
            }
        }
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
    
//LEAVE BUTTON
document.getElementById("LeaveWindow").addEventListener("click",function(){
    if(confirm("Are you sure you want to Undo Changes?"))
    {
        history.go(-1);
    }
})

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