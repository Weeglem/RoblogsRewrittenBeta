/** 
document.getElementById("Web-Desktop-NavBar").addEventListener("mouseover",function(Ev){
    console.log(Ev)
    if(Ev.target.nodeName != "A"){return;}

    let x= document.getElementById("Web-Desktop-NavBar").querySelectorAll("#Submenu");
    for(i = 0; i < x.length; i++){x[i].style.display = "None"}

    Ev.target.parentElement.querySelector("#Submenu").style.display = "block"
})
*/