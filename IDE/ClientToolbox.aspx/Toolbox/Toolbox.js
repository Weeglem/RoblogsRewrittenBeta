var Categories_UI = document.getElementById("Categories");
    var SearchButton_UI = document.getElementById("SearchOnline");
    var SearchBar_UI = document.getElementById("AssetName");
    var NextPage_UI = document.getElementById("Next-Page");
    var BackPage_UI = document.getElementById("Back-Page");
    var SearchTable_UI = document.getElementById("SearchTable");

    var NextDisabled = false;
    var BackDisabled = false;

    var ActualPage = 1;
    var AssetName = "";
    var AssetType = "Model";

    function Decide(){
        let value = Categories_UI.value;

        switch(value){
            default: Load_LocalToolbox(value); break;
            case "Models": case "Decals": Load_OnlineToolbox(value); break;
        }
    }

    function DrawItem(JSONData){

        document.getElementById("Showcase").innerText = "";
        BackPage_UI.innerText = "";
        NextPage_UI.innerText = "";
        BackDisabled = true;
        NextDisabled = true;

        var Models_Data = "";
        try{
            Models_Data = JSON.parse(JSONData);
        }catch(er){
            document.getElementById("Showcase").innerText = "Something went wrong.";
            return;
        }
        
        if(Models_Data["Items"].length == 0){
            document.getElementById("Showcase").innerText = "No results found";
            return;
        }

        let JSON_nextPage = Models_Data["Next"];
        let JSON_prevPage = Models_Data["Back"];
        let JSON_actualPage = Models_Data["Page"];

        if(JSON_prevPage == true){
            BackPage_UI.innerText = "< Back";
            BackDisabled = false;
        }

        if(JSON_nextPage == true){
            NextPage_UI.innerText = "Next >";
            NextDisabled = false;
        }

        ActualPage = JSON_actualPage;

        for(let i = 0; i < Models_Data["Items"].length; i++)
        {
            let Model_Name = Models_Data["Items"][i].Name;
            let Model_ID = Models_Data["Items"][i].ID;
            let Model_Thumbnail = Models_Data["Items"][i].Thumbnail;
            let Model_Link = Models_Data["Items"][i].Link;

            //TOOLBOX ITEM
            let Container = document.createElement("a");
            Container.className = "Item"
            Container.title = Model_Name
            Container.ondragstart = "javascript:DragContent('"+Model_Link+"')";
            Container.href = "javascript:InsertContent('"+Model_Link+"')"
            Container.style.backgroundImage = "url('"+Model_Thumbnail+"')"
            Container.draggable = "true";
            
            document.getElementById("Showcase").appendChild(Container)
        }   
    }

    function InsertContent(Link){try{window.external.Insert(Link);}catch(ex){alert(ex.message);}}

    function DragContent(Link){try{event.dataTransfer.setData("Text", "'"+Link+"'");}catch(ex){alert(ex.message);}}

    function Load_LocalToolbox(){
        BackPage_UI.innerText = "";
        NextPage_UI.innerText = "";
        BackDisabled = true;
        NextDisabled = true;

        let Item = Categories_UI.value;
        let Request = new XMLHttpRequest();
        Request.onload = function(){ 
            let Models = Request.response;
            DrawItem(Models);
        }
        Request.open("GET","./Toolbox/LocalModels.php?type="+Item,true);
        Request.send();
    }

    function Load_OnlineToolbox(){
        SearchTable_UI.style.display = "block";
        let Request = new XMLHttpRequest();
        Request.onload = function(){ 
            let Models = Request.response;
            DrawItem(Models);
        }

        let Where = Categories_UI.value
        let Name = SearchBar_UI.value

        Request.open("GET","./Toolbox/OnlineModels.php?Type="+Where+"&name="+Name+"&page="+ActualPage,true);
        Request.send();
    }

    Categories_UI.addEventListener("change",function(){
        ActualPage = 1;
        SearchBar_UI.value = "";
        Decide(Categories_UI.value)
    })

    SearchButton_UI.addEventListener("click",function(){
        Load_OnlineToolbox()
    })

    NextPage_UI.addEventListener("click",function(){
        if(NextDisabled == true){return;}
        ActualPage++
        Load_OnlineToolbox()
        NextDisabled == true
    })

    BackPage_UI.addEventListener("click",function(){
        if(BackDisabled == true){return;}
        ActualPage = ActualPage > 0 ? ActualPage - 1 : 1
        Load_OnlineToolbox()
        BackDisabled == false
    })

    window.addEventListener('load', function() {
        Decide(Categories_UI.value)
    });

    SearchBar_UI.addEventListener("keyup", function(event){
        if(event.key == "Enter"){
            Load_OnlineToolbox();
        }
    })