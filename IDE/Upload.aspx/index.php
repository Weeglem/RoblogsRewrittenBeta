<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();

if(Session::Validate_Session() == false){   exit("Login to roblogs to upload your Model");  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="Cache-Control" content="private, no-store" />
    <link rel="stylesheet" href="../../Website/Roblox/RobloxClient.CSS">
    <title>Save</title>
</head>
<body>
    <span id="SystemMessage" class="Hidden">Roblox Javascript is not enabled on this client. Please Enable it to proceed.</span>
    <noscript>This page Requires Javascript</noscript>
    <div class="UploadForm Hidden" id="MainMenu">
        <h1>You are about to Publish this Game on ROBLOGS. Please choose how you would like to save your work:</h1>
        <div class="GotoPart">
            <div class="GoToInside">
                <div class="ButtonGoto-Show"><button id="UpdateItem_Button" class="GoTobutton">Save</button></div>
                <div class="ButtonGoto-Explain">
                    <p><strong>Update an existing game on ROBLOGS.</strong></p>
                    <p>Choose this to make changes to a Model you have previously created. You will have the opportunity toselect which model you wish to update.</p>
                </div>
            </div>

            <div class="GoToInside">
                <div class="ButtonGoto-Show">
                    <button class="GoTobutton" id="ExitWindow">Cancel</button>
                </div>
                <div class="ButtonGoto-Explain">
                    <p><strong>Keep playing and save later.</strong></p>
                    <p></p>
                </div>
            </div>
        </div>
    </div>

    </div>
    <div class="UploadForm Hidden" id="UpdateItem">
        <h2>Select the Item you want to Update. The old version will be saved as a old ver.</h2>
        <div class="UpdateItem-Show">
            <ul id="ItemsShowcase"></ul>
        </div>
        <div class="BottomPagination Margin13">
            <div class="ItemsPagination">
                <p id="Back-Page" class="NavLink">< Back</p>
                <p id="Next-Page" class="NavLink">Next ></p>
            </div>
            <div class="FormButtons-Row TextRight">
                <button type="button" id="BackMainWindow">Back</button>
            </div>
        </div>
    </div>
    <div class="UploadForm Hidden" id="FinalizeMenu">
        <p id="FinalMessage">Something went wrong. Make sure Roblox Javascript Type is properly installed. if this problem continues to appear, Contact Roblogs Support.</p>
        <div class="FormButtons-Row Margin13">
            <button type="button" id="ExitWindow">Close</button>
        </div>
    </div>
    <input type="text" readonly="true" name="type" id="Itemtype" value="Games" style="display:none">
</body>
<script src="./script.js"></script>
<script src="./ItemsLoader.js"></script>
</html>