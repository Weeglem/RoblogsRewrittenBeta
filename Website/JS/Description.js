let Description = document.getElementById("Description");
let Description_Button = document.getElementById("Description_See");
var Description_Val = 0;

if(Description.innerText.length > 153)
{
    Description.style.height = "48px";
    Description.style.overflow = "hidden";
}else{
    Description_Button.style.display = "none";
}


Description_Button.addEventListener("click",function(){HideDescription(Description_Val)})


function HideDescription(value)
{
    switch(value)
    {
        case 1:
            Description_Val = 0;
            Description_Button.innerText = "See More"
            Description.style.height = "48px";
            Description.style.overflow = "hidden";
        break;
        default:
            Description_Val = 1;
            Description_Button.innerText = "See Less"
            Description.style.height = "fit-content";
            Description.style.overflow = "visible";
        break;
    }
}