var SocialCard = document.getElementById("UserSocial_Card");
var SocialCard_Invoke = document.getElementById("UserSocial_Card_Invoke");

SocialCard_Invoke.addEventListener("click",function(){

    if(SocialCard.classList.contains("UserSocial_Off"))
    {
        SocialCard.classList.remove("UserSocial_Off")
        SocialCard_Invoke.querySelector("#Icon").innerText = "-"
    }else{
        SocialCard.classList.add("UserSocial_Off")
        SocialCard_Invoke.querySelector("#Icon").innerText = "+"
    }   
})

