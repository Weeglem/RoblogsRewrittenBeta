function Userlogin()
{
    let Error = document.getElementById("LoginError");
    let RequestLogin = new FormData(LoginForm);
    let Request = new XMLHttpRequest();
    Error.innerText = "";
    Request.addEventListener("load",function(){
        try{
            console.log(Request.response)
            let JsonData = JSON.parse(Request.response);

            if(JsonData.success != false)
            { 
                window.location.reload();
                return;
            }

            Error.innerText = JsonData.message;
        }catch(err){
            Error.innerText = "Something went wrong"
        }
    })
    Request.open("POST","http://localhost/API/Account/Login.php",true);
    Request.send(RequestLogin);
}

var LoginForm = document.getElementById("RoblogsLogin_Form");

LoginForm.addEventListener("submit",function(e){
    e.preventDefault();
    Userlogin();
})
