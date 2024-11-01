document.getElementById("NewMessage").addEventListener("click",function(){
    let Message = document.getElementById("MessageBox")
    let FormDat = new FormData(Message);

    let Request = new XMLHttpRequest();
    Request.addEventListener("load",function(){
        try{
            let JSONdata = JSON.parse(Request.response)

            if (JSONdata.success == true)
            {
                document.getElementById("MessageForm_Window").remove();
                document.getElementById("SuccessMessage").style.display = "block";
                return;
            }

            alert(JSONdata.message);


        }catch(err)
        {
            alert("Something went wrong, try refreshing the page");
            console.log(Request.response)
        }
    
    })
    Request.open("POST","../API/Message/Send.php",true);
    Request.send(FormDat)

})