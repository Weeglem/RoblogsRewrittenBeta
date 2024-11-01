var CommentForm = document.getElementById("CommentForm")
var CommentForm_Submit = document.getElementById("CommentForm_Submit")
var AssetID = document.getElementById("CommentsID")
var AssetType = document.getElementById("CommentsType")

if(CommentForm != null){
    CommentForm.addEventListener("submit",function(e){
        e.preventDefault();
        SubmitForm();  
    })
}

function SubmitForm()
{
    let FormDat = new FormData(CommentForm);
    FormDat.append("id",AssetID.value);
    FormDat.append("Type",AssetType.value);

    let Request = new XMLHttpRequest();
    Request.addEventListener("load",function(){
        console.log(Request.response);
        
        try{
            let JSONdata = JSON.parse(Request.response)

            if (JSONdata.success == true)
            {
                LoadComments();
                return;
            }
            alert(JSONdata.message);
        }catch(err)
        {
            alert("Something went wrong, try refreshing the page");
            console.log(Request.response)
        }

        //LINKED WITH WEBSITE/JS/COMMENTS.JS
    })

    Request.open("POST","../API/Comments/New.php")
    Request.send(FormDat);
}

