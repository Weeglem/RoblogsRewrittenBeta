<header class="header">
    <h1 class="banner" id="Top">
        <!--<a class='SessionBannerLoggedOut' href='http://<?=$_SERVER["SERVER_NAME"]?>/index.php'>ROBLOGS.net</a>-->
        <span class="Banner_LoggedInfo Desktop">
            <?php
                if(Session::Validate_Session() == true)
                {
                    echo '
                        <span class="Banner_UserInfo Blue">
                            <span>Logged as, <a href="'.WebsiteLinks::Home_Page().'">'.Session::Get_Username().'</a></span>
                            <span>&nbsp;|&nbsp;</span>
                            <span><a href="'.WebsiteLinks::LogOut_API().'">Log Out</a></span>
                        </span>

                        <span class="Banner_UserContainer">
                            <span><a class="UserContainerlink" href="http://'.$_SERVER["SERVER_NAME"]."/Inbox".'">Inbox ('.Session::GetMailCount().')</a></span>
                            <span>&nbsp;|&nbsp;</span>
                            <span>Friends Request (0)</span>
                            <span>&nbsp;|&nbsp;</span>
                            <span><a class="UserContainerlink" href='.WebsiteLinks::MyUploads_Page().'>My Uploads</a></span>
                        </span>
                    
                    ';
                }else{
                    echo '
                        <span class="Banner_UserInfo Blue">
                            <span>Login</span>
                        </span> 
                    ';
                } 
            ?>
        </span>
    </h1>
    <nav class="navbar Blue" id="Web-Desktop-NavBar">
        <!--
        <div class="Desktop Web-Desktop-NavBar">
            <ul>
                <li>
                    <a href="#">Home</a>
                    <div class="NavBar-SubMenu" id="Submenu">
                        <a href="#">My Profile</a>
                        <a href="#">My Uploads</a>
                        <a href="#">Inbox</a>
                    </div>
                </li>
                <li>
                    <a href="#">Workshop</a>
                    <div class="NavBar-SubMenu" id="Submenu">
                        <a href="#">Maps</a>
                        <a href="#">Models</a>
                        <a href="#"></a>
                    </div>
                </li>
                <li>
                    <a href="#">Community</a>
                    <div class="NavBar-SubMenu" id="Submenu">
                        <a href="#">Forums</a>
                        <a href="#">Groups</a>
                    </div>
                </li>
            </ul>
            -->





            <span><a href="http://<?=$_SERVER["SERVER_NAME"]?>">Home</a></span>
            <span>&nbsp;|&nbsp;</span>
            <span><a href="http://<?=$_SERVER["SERVER_NAME"]?>/Workshop.php">Workshop</a></span>
            <span>&nbsp;|&nbsp;</span>
            <span><a href="http://<?=$_SERVER["SERVER_NAME"]?>/Uploads/New.php">Upload</a></span>
            <span>&nbsp;|&nbsp;</span>
            <span><a href="http://<?=$_SERVER["SERVER_NAME"]?>/Forums/">Forums</a></span>
            <span>&nbsp;|&nbsp;</span>
            <span><a target="_blank" href="http://<?=$_SERVER["SERVER_NAME"]?>/Blog/">Blog</a></span>
        </div>
        <div class="Mobile">
            <span><img id="Menu-Phone-Display" src="http://<?=$_SERVER["SERVER_NAME"]?>/Website/IMG/menu-burger.png" width="26px;" style="margin-top:5px;" alt=""></span>
            <ul id="Menu-Phone-Menu" class="Mobile-Navbar">
                <li><a href="http://<?=$_SERVER["SERVER_NAME"]?>">Home</a></li>
                <li><a href="http://<?=$_SERVER["SERVER_NAME"]?>/Workshop.php">Workshop</a></li>
                <li><a target="_blank" href="http://<?=$_SERVER["SERVER_NAME"]?>/Blog/">Blog</a></li>
            </ul>
        </div>
    </nav>
    <noscript>
        <div class="Javascript_Alert">
                <strong>JavaScript is disabled on this device. </strong>Pages that rely on Javascript won't work properly.
        </div>
    </noscript>
    <!--<div style="background: #ffb355;" class="navbar NavbarNotification"> <span>'.$Splash.'</span> </div>-->
    <?php if(Session::Validate_Session() == true){Session::UpdateLastSeen();}?>
    <?php 
        if(Session::Validate_Session() == true){
            if(Session::CheckBan() == true) 
            {
                $BanDraw = new Session_BanHandler();
                $BanDraw->Draw_Window();
                exit();
            }
        }
        ?>
</header>