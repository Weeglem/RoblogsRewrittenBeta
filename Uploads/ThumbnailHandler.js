document.getElementById("UploadThumbnail_Form").addEventListener("submit",function(ev){
    ev.preventDefault();
    let Req = new XMLHttpRequest();
    let FD = new FormData(document.getElementById("UploadThumbnail_Form"));

    Req.onload = function(){
        console.log(Req.response);
    }

    Req.open("POST","../API/Uploads/New/UserImage.php",true);
    Req.send(FD);
})


document.getElementById("EditThumbnails_Table").addEventListener("submit",function(ev){
    ev.preventDefault();

    let ItemForm = ev.target.parentElement.querySelector("#RemoveThumbnail");
    //console.log(ev);
    let Req = new XMLHttpRequest();
    let FD = new FormData(ItemForm);

    Req.onload = function(){
        console.log(Req.response);
        console.log("hi")
    }

    Req.open("POST","../API/Uploads/Edit/UserImageRemove.php",true);
    Req.send(FD);

    alert("Hi");
})