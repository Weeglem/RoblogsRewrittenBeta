let FollowButton = document.getElementById("FollowThread_Trigger");
const ForumID = document.getElementById("Threadid");

FollowButton.addEventListener("click",function(){
    if(FollowButton.checked == true)
    {
        SendFollowThread(true);
    }else{
        SendFollowThread(false);
    }
})

function SendFollowThread(sub)
{
    let Request = new XMLHttpRequest();
    Request.addEventListener("load",function()
    {
        console.log(Request.response)
        JSON_res = JSON.parse(Request.response) 
        if(JSON_res.success == false)
        {
            alert(JSON_res.message)
            if(sub == true){FollowButton.checked = false}else{FollowButton.checked = true}
            
            return;
        }
    })

    let Form = new FormData();
    Form.append("ID",ForumID.value);

    if(sub == true)
    {
        console.log("Sending follow");
        Request.open("POST","../API/Forum/Follow.php",true);
        Request.send(Form);
    }else{
        //CORRECT FOR FINAL
        console.log("Removing Follow")
        Request.open("POST","../API/Forum/StopFollowing.php",true);
        Request.send(Form);
    }
}

