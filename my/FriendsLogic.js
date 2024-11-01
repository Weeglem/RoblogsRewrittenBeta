let API_Links = {
    "Reject" : "../API/Friends/Reject.php",
    "Unfriend" : "../API/Friends/Remove.php",
    "Accept" : "../API/Friends/Add.php"
}

document.getElementById("FriendsPanel").addEventListener("submit",function(ev){
    ev.preventDefault();
    let Value = ev.submitter.id;
    let UserID = ev.target.querySelector("#id").value;
    let UserName = ev.target.parentElement.querySelector("a").innerText;

    switch(Value)
    {
        case "Accept":
        case "Reject":
            alert("Continue...")
        break;
        case "Unfriend":
            if(!confirm("Are you sure you unfriend "+UserName)){
                return;
            }
        break;
        default: 
            return;
        break;
    }  


    let Request = new XMLHttpRequest();
    let Form = new FormData(ev.target);

    Request.addEventListener("load",function(){
        console.log(this.response)

        let JSON_Data = JSON.parse(this.response);
        if(JSON_Data.success == true){
            //CLEAN
            ev.target.parentElement.remove()
            
            return;
        }else{
            alert(JSON_Data.message);
        }
    })

    console.log(API_Links[Value])
    Request.open("POST",API_Links[Value],true);
    Request.send(Form);
})