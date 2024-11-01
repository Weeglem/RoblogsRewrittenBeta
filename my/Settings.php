<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Includes.php");
$x = new Includes();
$x->Session();
$x->Database();

function ConvertToCheck($SessionGet){ return $SessionGet == true ? "checked" : "";}

try{
    Session::Validate_Session();
    $Bio = Session::Get_About();
    $AllowFC = ConvertToCheck(Session::Settings_AllowsFriendRequests());
    $AllowMessage = ConvertToCheck(Session::Settings_AllowsMessages());
    $FilterText = ConvertToCheck(Session::Settings_FilterText());
    $PublicContact = ConvertToCheck(Session::Settings_PublicContact());
}catch(Exception $err)
{
    exit($err->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<?php $Page_CSS = "My_Settings"; $Page_Title = "My Settings"?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Top.php");?>
<!---Content Container Start-->

<div class="SettingsContainer  border">
    <div class="Left_Panel" id="Menus">
        <ul>
            <li><h2>Settings</h2></li>
            <li><a href="#" id="ShowProfileSettings" class="Search_ListItem">My Profile</a></li>
            <li><a href="#" id="ShowPrivacySettings" class="Search_ListItem">Privacy</a></li>
            <li><a href="#" id="ShowContactInfo" class="Search_ListItem">Social Media</a></li>
            <li><a href="#" id="ShowAccountSettings" class="Search_ListItem">Account</a></li>
        </ul>
    </div>
    <div class="Right_Panel" id="MenusShow">
        <!--Profile Settings-->
        <div id="ProfileSettings"> 
            <form id="ChangeAvatar">
                <div class="Input_Container">
                    <h3>My ROBLOGS</h3>
                    <label for="Avatar">New Icon: </label>
                    <div class=""><input type="file" name="Avatar" title="Avatar" id="Avatar"></div>
                    <button type="submit" value="ChangeAvatar">Change Avatar</button>
                    <p class="Error" id="Error"></p>
                </div>        
            </form>

            <hr>

            <form id="ChangeAboutMe">
                <div class="TextAreaBox">
                    <label for="About">My Description:</label>
                    <textarea name="About" id="About" cols="48" rows="10"><?=$Bio?></textarea>
                </div>
                <button type="submit" value="ChangeAboutMe">Change About</button>
                <p class="Error" id="Error"></p>
            </form>


            <hr>
        </div>
         <!--Contact Settings-->
        <div id="ContactInfo" style="display:none">
            <h3>Contact info</h3>
            <form id="MyContact">
                <div id="MyContactBody">
                    <?php

                    $ContactWays = Session::Get_SocialMedia();

                    foreach($ContactWays as $Form)
                    {
                        $Site = Website::EncodeString($Form["Site"]);
                        $Link = Website::EncodeString($Form["Link"]);

                        echo '
                            <div class="Input_Container">
                                <input placeholder="Site Name" type="text" value="'.$Site.'" name="SocialMedia[]">
                                <input placeholder="URL" type="text" value="'.$Link.'" name="SocialMediaLink[]">
                                <button type="button" value="RemoveContact">Remove</button>
                            </div>
                        ';
                    }

                    ?>
                    </div>
                <button type="button" value="AddContact">Add</button>
                <button type="submit" value="MyContact">Change Contact Link</button>
                <p class="Error" id="Error"></p>
            </form>
        </div>

        <!--Profile Settings-->
        
        <div id="AccountSettings" style="display:none">
            <!--New Username-->
            <h3>My Account</h3>
            <form id="ChangeUsername">
                <div class="Input_Container">
                    <label for="Username">New Username:</label>
                    <input type="text" name="Username" id="Username">
                </div>
                <button type="submit" value="ChangeUsername">New Username:</button>
                <p class="Error" id="Error"></p>
            </form>
            <hr>
            <!--New Password-->
            <form id="ChangePassword">
                <div class="Input_Container">
                    <label for="OldPassword">Old Password:</label>
                    <input type="password" name="OldPassword" id="OldPassword">
                </div>
                <div class="Input_Container">
                    <label for="NewPassword">New Password:</label>
                    <input type="password" name="NewPassword" id="NewPassword">
                </div>
                <div class="Input_Container">
                    <label for="NewPassword">Repeat Password:</label>
                    <input type="password" name="NewPassword2" id="NewPassword2">
                </div>
                <button type="submit" value="ChangePassword">Change Password</button>
                <p class="Error" id="Error"></p>
            </form>

            
        </div>

        <!--Privacy Settings-->
        
        <div id="PrivacySettings" style="display:none">
            <h3>Privacy Settings</h3>
            <form action="" id="SetPrivacy">
                
                <div class="Input_Container">
                    <label for="FriendRequest">Allow Friend Requests</label>
                    <input type="checkbox" name="FriendRequest" id="FriendRequest" <?=$AllowFC?>>
                </div>

                <div class="Input_Container">
                    <label for="AllowMessages">Allow Public Messages</label>
                    <input type="checkbox" name="AllowMessages" id="AllowMessages" <?=$AllowMessage?>>
                </div>

                <div class="Input_Container">
                    <label for="AllowMessages">Filter and Censor Text</label>
                    <input type="checkbox" name="FilterText" id="FilterText" <?=$FilterText;?>>
                </div>

                <div class="Input_Container">
                    <label for="AllowMessages">Public Contact Links</label>
                    <input type="checkbox" name="PublicContact" id="PublicContact" <?=$PublicContact?>>
                </div>

                <button type="submit" value="SetPrivacy">Submit</button>
                <p class="Error" id="Error"></p>
            </form>
        </div>

         

    </div>
</div>

<!---Content Container Close-->
<?php include($_SERVER["DOCUMENT_ROOT"]."/Roblogs_Server/Templates/Footer.php"); ?>
<script src="./Settings.js"></script>
<script src="./SettingsContact.js"></script>
</body>
</html>