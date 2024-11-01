document.getElementById("DeleteSelected").addEventListener("click",function(){
    let Inboxbody = document.getElementById("InboxBody");
    let FormDat = new FormData(Inboxbody);

    let Request = new XMLHttpRequest();
    Request.addEventListener("load",function(){
        //console.log(Request.response)
        window.location.reload();
    })
    Request.open("POST","../API/Message/Delete.php",true);
    Request.send(FormDat)
})

