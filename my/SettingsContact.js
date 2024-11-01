
let MyContact = document.getElementById("MyContact");
MyContact.addEventListener("click",function(event){

    Button = event.target;
    if(Button.value == "RemoveContact"){Button.parentElement.remove();}
    if(Button.value == "AddContact"){
    
        let BaseDiv = document.createElement("div")
        BaseDiv.classList.add("Input_Container")

        let InputName = document.createElement("input")
            InputName.name = "SocialMedia[]"
            InputName.type="text"
            InputName.placeholder="Name"

        let InputLink = document.createElement("input")
            InputLink.type="text"
            InputLink.name="SocialMediaLink[]"
            InputLink.placeholder = "https://name"

        let RemoveButton = document.createElement("button")
            RemoveButton.value="RemoveContact"
            RemoveButton.innerText = "Remove"
            RemoveButton.type = "button"    

        BaseDiv.appendChild(InputName);
        BaseDiv.appendChild(InputLink);
        BaseDiv.appendChild(RemoveButton);

        document.getElementById("MyContactBody").appendChild(BaseDiv)
    }
})