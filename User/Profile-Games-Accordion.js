let GamesAccordionDiv = document.getElementById("games-accordion");
let GamesAccordion_Games = document.querySelectorAll(".GameAccordion_Div");
let GameAccordion_Dis = false;
//CLEAN CODE

for(let i = 0; i < GamesAccordion_Games.length; i++)
{
    let ActualDiv =GamesAccordion_Games[i];
    if(i != 0)
    {
        ActualDiv.querySelector("h3").classList.add("Accordion-Games-Normal")
        ActualDiv.querySelector("figure").classList.add("Accordion-Game-Display-Hide");
    }else{
        ActualDiv.querySelector("h3").classList.add("Accordion-Games-Normal")
        ActualDiv.querySelector("h3").classList.add("Accordion-Games-Active")
        ActualDiv.querySelector("figure").classList.remove("Accordion-Game-Display-Hide");
    }
}

function HideGamesAccordions()
{
    for(let i = 0; i < GamesAccordion_Games.length; i++)
        {
            let ActualDiv =GamesAccordion_Games[i];
            if(ActualDiv.querySelector("h3").classList.contains("Accordion-Games-Active"))
            {
                ActualDiv.querySelector("figure").classList.add("Accordion-Game-Display-Hide");
                ActualDiv.querySelector("h3").classList.remove("Accordion-Games-Active")  
            }  
        }   
}

GamesAccordionDiv.addEventListener("click",function(ev){
    if(GameAccordion_Dis != false){console.log("Skip");return;}
    if(ev.target.nodeName != "H3"){return;}
    GameAccordion_Dis = true;
    let ActualH3 = ev.target;
    let Parent = ActualH3.parentElement
    HideGamesAccordions()

    Parent.querySelector("figure").classList.remove("Accordion-Game-Display-Hide");
    ActualH3.classList.add("Accordion-Games-Active");
    setTimeout(function(){GameAccordion_Dis = false},300)
})


