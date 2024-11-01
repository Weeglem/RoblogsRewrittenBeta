function KeepAlive(){
    console.log("hi");
    alert("Keep Alive test");
}

let KeepAlivePinger = setInterval(KeepAlive(),1000);
//clearInterval(KeepAlivePinger);
