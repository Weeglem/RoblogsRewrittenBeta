var FavoriteButton = document.getElementById("FavoriteHandler");
var FavoritesNumber = document.getElementById("FavoritesNumber");
var AssetID = document.getElementById("CommentsID")
var AssetType = document.getElementById("CommentsType")

if(FavoriteButton != null){
    FavoriteButton.addEventListener("click",function(){
        if(FavoriteButton.value == "AddFavorite"){FavoriteHandler("Add"); return;}
        if(FavoriteButton.value == "RemoveFavorite"){FavoriteHandler("Remove"); return;}
    })
}

function FavoriteHandler(Action)
{
    FavoriteButton.disabled = true;
    let FormDat = new FormData();
    FormDat.append("id",AssetID.value);
    FormDat.append("Type",AssetType.value);

    let Request = new XMLHttpRequest();
    Request.addEventListener("load",function(){
        try{
            let JSONdata = JSON.parse(Request.response)
            if (JSONdata.success == true){ 

                if(Action == "Add"){
                    FavoriteButton.value = "RemoveFavorite";
                    FavoriteButton.innerText = "Remove From Favorites";
                    FavoritesNumber.innerText = parseInt(FavoritesNumber.innerText) + 1
                }

                if(Action == "Remove"){
                    FavoriteButton.value = "AddFavorite";
                    FavoriteButton.innerText = "Add To Favorites";
                    FavoritesNumber.innerText = parseInt(FavoritesNumber.innerText) - 1
                }  

                FavoriteButton.disabled = false;
                return;

            }

            alert(JSONdata.message);

            FavoriteButton.disabled = false;
            return;

        }catch(err)
        {
            alert("Something went wrong, try refreshing the page");
            console.log(Request.response)
            FavoriteButton.disabled = false;
        }
    })

    if(Action == "Remove"){ Request.open("POST","../API/Favorites/Remove.php");}
    if(Action == "Add"){ Request.open("POST","../API/Favorites/Add.php");}
    
    Request.send(FormDat);

}

//FAVORITE HANDLER, BETA 1