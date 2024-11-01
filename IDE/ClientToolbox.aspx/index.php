<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <link rel="stylesheet" href="./Toolbox/Toolbox.css">
    <title>Client Toolbox</title>
</head>

<main>
    <section class="Search">
        <select id="Categories" style="padding:0; margin:0;">
            <option value="Bricks">Bricks</option>
            <option value="Vehicles">Vehicles</option>
            <option value="Tools">Tools and weapons</option>
            <option value="Furniture">Furniture</option>
            <option value="Cart">Cart Ride</option>
            <option value="Roads">Roads</option>
            <option value="Robots">Robots</option>
            <option value="Skyboxes">Skyboxes</option>
            <option value="Objects">Game objects</option>
            <option value="Models">Free Models</option>
            <option value="Decals">Free Decals</option>
            <option value="MyModels">My Models</option>
            <option value="MyDecals">My Decals</option>
        </select>
    </section>

    <section id="SearchTable" class="Name_Search">
        <table>
            <tr>
            <td>
                <div class="Search_Container">
                    <input type='text' placeholder="Look for..." name='AssetName' id='AssetName'>
                </div>
            </td>
            <td>
                <div class="Search_Button">
                    <button id='SearchOnline'>Search</button>
                </div>
            </td>
            </tr>
        </table>
    </section>
    
    <section class="Toolbox_Body">
        <noscript>Javascript is required for this page</noscript>
        <div id="Showcase" class="Toolbox_Flex"></div>
    </section>
    <section class="Toolbox_Pagination">
        <p id="Back-Page" class="NavLink">< Back</p>
        <p id="Next-Page" class="NavLink">Next ></p>
    </section>
</main>

<script src="./Toolbox/Toolbox.js"></script>
</html>