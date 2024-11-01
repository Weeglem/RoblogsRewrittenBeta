let FormDiv = document.getElementById("PostSubmit");
let SubButton = document.getElementById("SubmitButton").value;

FormDiv.addEventListener("submit",function(ev){
    ev.preventDefault();

    let FD = new FormData(FormDiv);
    let Req = new XMLHttpRequest();
    Req.addEventListener("load",function(){

        console.log(Req.response);
        JSON_RES = JSON.parse(Req.response)
        if(JSON_RES.success == true)
        {
            if(SubButton == "New"){
                window.location.href = JSON_RES.message;
                return;
            }

            if(SubButton == "Reply")
            {
                history.go(-1);
                return; 
            }

            if(SubButton == "Edit")
            {
                alert("Message Edited Successfuly");
                return;
            }
        }else{
            alert(JSON_RES.message);
        }
    })
    switch(SubButton)
    {
        case "New":
            Req.open("POST","../API/Forum/New.php");
            Req.send(FD);
        break;
        case "Reply":
            Req.open("POST","../API/Forum/Reply.php");
            Req.send(FD);
        break;
        case "Edit":
            Req.open("POST","../API/Forum/Edit.php");
            Req.send(FD);
        break;
    }
    
})