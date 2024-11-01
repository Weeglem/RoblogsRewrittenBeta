

<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "Home"; $Page_Title = "Roblogs - Home"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<!---Content Container Start-->
<!--
<div id="Website_MessageBox_Container" class="Website_MessageBox_Container">
    <div id="Website_MessageBox_Window" class="Website_MessageBox_Window border">
        <h3 class="Title">Test Box</h3>
        <hr>
        <p class="Context">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, voluptates vel. Ex nostrum dicta sed quo aliquam expedita recusandae impedit unde eos ratione assumenda quod autem nihil doloremque aperiam aut alias commodi porro esse aspernatur deleniti, distinctio explicabo tempore cumque? Obcaecati nulla, porro quo laborum cumque dolorum? Accusantium neque non laborum debitis itaque, quae fuga optio laudantium consequatur qui illo, nisi facilis iste officia architecto, repudiandae doloribus sequi repellat nesciunt officiis perferendis. Necessitatibus odit beatae modi neque voluptas quasi atque, aut harum dolor laudantium fugit ipsa impedit optio. Minus dolor consequuntur error illum corporis. Reprehenderit aperiam aliquam perspiciatis architecto esse!</p>
        <div class="Website_MessageBox_flex">
            <button type="button" id="Confirm">Proceed</button>
            <button type="button" id="Cancel">Cancel</button>
            <button type="button" id="OK">OK</button>
        </div>
    </div>
</div>

-->
<!---Content Container Close-->
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>

<script>





    function Website_CreateMessage(Title,Message)
    {
        if(document.getElementById("Website_MessageBox_Container") != undefined){ return false; }
        let MessageBox_Container = document.createElement("div")
        MessageBox_Container.classList.add("Website_MessageBox_Container")
        MessageBox_Container.id = "Website_MessageBox_Container"
        
        let MessageBox_Window = document.createElement("div")
        MessageBox_Window.classList.add("Website_MessageBox_Window")
        MessageBox_Window.classList.add("border")

        let MessageBox_Title = document.createElement("h3")
        MessageBox_Title.classList.add("Title")
        MessageBox_Title.innerText = Title == undefined ? "Task Message":Title;
        
        let MessageBox_Context = document.createElement("p")
        MessageBox_Context.classList.add("Context")
        MessageBox_Context.innerText = Message == undefined ? "Unknown Message" : Message;

        let MessageBox_Buttons_DIV = document.createElement("div")
        MessageBox_Buttons_DIV.classList.add("Website_MessageBox_flex")
        MessageBox_Buttons_DIV.id="MessageBox_Buttons_DIV"


        MessageBox_Window.appendChild(MessageBox_Title)
        MessageBox_Window.appendChild(MessageBox_Context)
        MessageBox_Window.appendChild(MessageBox_Buttons_DIV)
        MessageBox_Container.appendChild(MessageBox_Window)
        document.body.appendChild(MessageBox_Container);
        return true;
    }

    function Website_DestroyMessage()
    {
        if(document.getElementById("Website_MessageBox_Container") != undefined){document.getElementById("Website_MessageBox_Container").remove()}
    }

    function Website_Message_SET_ConfirmButtons()
    {
        if(Website_CreateMessage() == true){
            let ConfirmButton = document.createElement("button")
            ConfirmButton.type = "button"
            ConfirmButton.innerText = "Confirm";
            ConfirmButton.value = true

            let CancelButton = document.createElement("button")
            CancelButton.type = "button"
            CancelButton.innerText = "Cancel";
            CancelButton.value = false

            document.getElementById("MessageBox_Buttons_DIV").appendChild(CancelButton)
            document.getElementById("MessageBox_Buttons_DIV").appendChild(ConfirmButton)
           //function ev

            document.getElementById("MessageBox_Buttons_DIV").addEventListener("click",function(Ev){

            if(Ev.target.nodeName == "BUTTON"){
                let ButtonVal = Ev.target.value;

                return ButtonVal == "true" ? true : false;
            }
            })

        }
    
    }

    function Website_Message_Set_SingleButton(BttonMessage)
    {
        let CancelButton = document.createElement("button")
        CancelButton.type = "button"
        CancelButton.innerText = BttonMessage == undefined ? "OK" : BttonMessage;
        CancelButton.onclick = function(){Website_DestroyMessage()};

        document.getElementById("MessageBox_Buttons_DIV").appendChild(CancelButton)
    }
    

    function Website_Message_NewAlertMessage(Head,Message,ConfirmButton)
    {
        Website_CreateMessage(Head,Message);
        Website_Message_Set_SingleButton(ConfirmButton);
    }

    Website_Message_NewAlertMessage("Finished Task","Here you should check my new gaming pagae")

    
    
</script>
</body>
</html>