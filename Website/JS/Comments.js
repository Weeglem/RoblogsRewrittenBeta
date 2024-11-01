var NextPage_UI = document.getElementById("Next-Button")
var BackPage_UI = document.getElementById("Back-Button")
var Comment_Box = document.getElementById("CommentList")
var ActualPage = 1;
    
function DrawComment(JSONdata){
    Comment_Box.innerText = "";
    try{
        var Json_Data = JSON.parse(JSONdata);
    }catch(err){
        Comment_Box.innerText = "Failed to get the Comments for this item.";
        return;
    }

    if(Json_Data["Items"].length == 0)
    {
        Comment_Box.innerText = "No Comments found";
        return; 
    }
        
    let Json_NextPage = Json_Data["Next"]
    let Json_BackPage = Json_Data["Back"]
    let Json_ActualPage = Json_Data["Page"]

    if(Json_NextPage == true)
    {
        NextDisabled = false;
        NextPage_UI.innerText = "Next >";
    }

        if(Json_BackPage == true){
            BackDisabled = false;
            BackPage_UI.innerText = "< Back";
        }   

        ActualPage = Json_ActualPage


        function Draw(userid,username,message,date){


            //DRAW
            let li = document.createElement("li");

            let article = document.createElement("article")
            article.className = "Comment"


            let avatarimg = document.createElement("img")
            avatarimg.className = "AvatarsThumbnail_Small CommentAvatar"
            avatarimg.src = "http://localhost/Assets/Thumbs/User.php?id="+userid+""

            let divCI = document.createElement("div")
            divCI.className = "CommentInfo"

            let ulCommentData = document.createElement("ul")

            let liCommentTitle = document.createElement("li")
            let pCommentTitle = document.createElement("p")
            pCommentTitle.className = "Comment-Title"
            pCommentTitle.innerText = username+" "+date;


            let liCommentText = document.createElement("li")
            let pCommentText = document.createElement("p")
            pCommentText.className = "Comment-Text"
            pCommentText.innerText = message


            //add P
            liCommentText.appendChild(pCommentText);
            liCommentTitle.appendChild(pCommentTitle);

            ulCommentData.appendChild(liCommentTitle)
            ulCommentData.appendChild(liCommentText)
            divCI.appendChild(ulCommentData)



            article.appendChild(avatarimg)
            article.appendChild(divCI)
            li.appendChild(article)

            Comment_Box.appendChild(li)
        }

        for(let i = 0; i < Json_Data["Items"].length; i++){

            let Username = Json_Data["Items"][i].Username;
            let UserID = Json_Data["Items"][i].UserID;
            let Comment = Json_Data["Items"][i].Comment;
            let Date = Json_Data["Items"][i].Date;

            Draw(UserID,Username,Comment,Date)
        }
    }

    function LoadComments(){
        BackDisabled = true;
        NextDisabled = true;
        BackPage_UI.innerText = "";
        NextPage_UI.innerText = "";


        let Request = new XMLHttpRequest();
        let ItemID = document.getElementById("CommentsID").value
        let ItemType = document.getElementById("CommentsType").value;
        let Page = ActualPage;

        Request.onload = function(){ DrawComment(Request.response);}
        Request.open("GET","../API/Comments/GET.php?id="+ItemID+"&Type="+ItemType+"&page="+Page,true);
        Request.send()
    }

    NextPage_UI.addEventListener("click",function(){
        if(NextDisabled == true){return;}
        ActualPage++
        LoadComments();
        NextDisabled = true;

    })

    BackPage_UI.addEventListener("click",function(){
        if(BackDisabled == true){return;}
        ActualPage = ActualPage > 0 ? ActualPage - 1 : 1
        LoadComments();
        BackDisabled = true;
    })

    
    window.addEventListener("load",function(){
        LoadComments();
    })