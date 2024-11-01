let AllAccordions = document.querySelectorAll("#Accordion");

for(let i = 0; i < AllAccordions.length; i++)
{
    let ActualAccordion = AllAccordions[i]
    ActualAccordion.querySelector("#AccordionToggle").addEventListener("click",function(ev){

        let Item = ev.target;
        let NextItem = ev.target.nextElementSibling;

        if(NextItem.classList.contains("Card-Display-Hide"))
        {
            Item.querySelector("#Icon").innerText = "(-)";
            NextItem.classList.remove("Card-Display-Hide")
        }else{
            Item.querySelector("#Icon").innerText = "(+)";
            NextItem.classList.add("Card-Display-Hide")
        }
    })
}