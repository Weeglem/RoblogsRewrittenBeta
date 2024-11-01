function DeleteMessagesMes(ID)
{

    let FormDat = new FormData()
    FormDat.append("check_list[]", ID)
    let Request = new XMLHttpRequest();
    Request.addEventListener("load",function(){
        history.go(-1);
    })
    Request.open("POST","../API/Message/Delete.php",true);
    Request.send(FormDat)

}