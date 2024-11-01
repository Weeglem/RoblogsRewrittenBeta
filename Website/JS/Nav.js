let Burger_Trigger = document.getElementById("Menu-Phone-Display")
let Burger_Nav = document.getElementById("Menu-Phone-Menu");
let Burger_Triggered = false;

Burger_Trigger.addEventListener("click",function(){
    if(Burger_Triggered != false){
        Burger_Nav.style.display = "block"
        Burger_Triggered = false;
    }else{
        Burger_Nav.style.display = "none"
        Burger_Triggered = true;   
    }
})