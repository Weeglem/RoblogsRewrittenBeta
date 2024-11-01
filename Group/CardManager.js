var MemberCard_Button = document.getElementById("MemberCard_Button")
var AlliesCard_Button = document.getElementById("AlliesCard_Button")

MemberCard_Button.addEventListener("click",function(){
    document.getElementById("Members_Tag").style.display = "block"
    document.getElementById("Allies_Tag").style.display = "none"
    MemberCard_Button.classList.add("CardBody-Selected")
    AlliesCard_Button.classList.remove("CardBody-Selected")
})

AlliesCard_Button.addEventListener("click",function(){
    document.getElementById("Allies_Tag").style.display = "block"
    document.getElementById("Members_Tag").style.display = "none"
    AlliesCard_Button.classList.add("CardBody-Selected")
    MemberCard_Button.classList.remove("CardBody-Selected")
})