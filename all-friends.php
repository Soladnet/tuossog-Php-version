<?php
session_start();
if (isset($_COOKIE['user_auth'])) {
    include_once './encryptionClass.php';
    include_once './GossoutUser.php';
    include_once './Community.php';
    include_once './Post.php';
    $encrypt = new Encryption();
    $uid = $encrypt->safe_b64decode($_COOKIE['user_auth']);
    $check = FALSE;
    if (is_numeric($uid)) {
        $user = new GossoutUser($uid);
        $userCom = new Community();
        $post = new Post();
        $post->setUserId($uid);
        $userCom->setUser($uid);
        $userProfile = $user->getProfile();
        if ($userProfile['status']) {
            $check = TRUE;
        }
    }
} else {
    header("Location: login");
}
?>
<!doctype html>
<html>
    <head>
        <title>Gossout</title>
        <link rel="stylesheet" href="css/jackedup.css">
        <script type="text/javascript" src="scripts/jquery-1.9.1.min.js"></script>
        <?php
        include ("head.php");
        ?>
        <script type="text/javascript" src="scripts/humane.min.js"></script>
        <script type="text/javascript" src="scripts/jquery.fancybox.pack.js?v=2.1.4"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                sendData("loadNotificationCount",{uid: readCookie("user_auth"),title:document.title});
                $(".fancybox").fancybox({
                    openEffect: 'none',
                    closeEffect: 'none'

                });
            });
        </script>
    </head>
    <body>
        
        <div class="page-wrapper">
            <?php
            include ("nav.php");
            include ("nav-user.php");
            ?>
            <div class="logo"><img src="images/gossout-logo-text-svg.svg" alt=""></div>

            <div class="content">			
                <div class="all-friends-list">
                    <h1>All Friends</h1>

                    <div class="friend-search-box">
                        <input name="" class="friend-search-field " placeholder="Search Friends" type="text" value="" required="">
                        <input type="submit" class="button" value="Search">
                    </div>
                    <div class="clear"></div>

                    <div class="individual-friend-box">
                        <a class= "fancybox " id="inline" href="#kori">
                            <div class="friend-image">
                                <img src="images/2.jpg">
                            </div>
                            <div class="friend-text">
                                <div class="friend-name">Muhammad Abdullahi Kori</div>
                                <div class="friend-location">Abuja, Federal Capital Territory, Nigeria</div>
                            </div>
                            <div style="display:none">
                                <div id="kori">
                                    <div class="aside-wrapper">
                                        <img class="profile-pic" src="images/2.jpg">
                                        <table>
                                            <tr><td></td><td><h3>Kori Muhammad Abdullahi</h3></td></tr>
                                            <tr><td><span class="icon-16-map"></span></td><td class="profile-meta"> Abuja, Federal Capital Territory, Nigeria</td></tr>
                                            <tr><td><span class="icon-16-female"></span></td><td class="profile-meta"> Female</td></tr>
                                            <tr><td><span class="icon-16-male"></span></td><td class="profile-meta"> Male</td></tr>
                                            <tr><td><span class="icon-16-dot"></span></td><td class="profile-meta"><a href="">See Profile</a> </td></tr>
                                        </table>					
                                        <div class="clear"></div>
                                        <button class="profile-meta-functions button"><span class="icon-16-eye"></span> Wink</button>
                                        <button class="profile-meta-functions button"><span class="icon-16-mail"></span> Send Message</button>
                                        <button class="profile-meta-functions button"><span class="icon-16-checkmark"></span> Accept Friendship</button>

                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="individual-friend-box">
                        <a class= "fancybox" id="inline" href="#data9">
                            <div class="friend-image">
                                <img src="images/1.jpg">
                            </div>
                            <div class="friend-text">
                                <div class="friend-name">Al-Asaad Bin Muhammad Al-Menk Daud Suleiman</div>
                                <div class="friend-location">Abuja, Federal Capital Territory, Nigeria</div>
                            </div>
                            <div style="display:none">
                                <div id="data9">
                                    <div class="aside-wrapper">
                                        <img class="profile-pic" src="images/1.jpg">
                                        <table>
                                            <tr><td></td><td><h3>Ciroma Chukwuma Adekunle</h3></td></tr>
                                            <tr><td><span class="icon-16-map"></span></td><td class="profile-meta"> Abuja, Federal Capital Territory, Nigeria</td></tr>
                                            <tr><td><span class="icon-16-female"></span></td><td class="profile-meta"> Female</td></tr>
                                            <tr><td><span class="icon-16-male"></span></td><td class="profile-meta"> Male</td></tr>
                                            <tr><td><span class="icon-16-dot"></span></td><td class="profile-meta"><a href="">See Profile</a> </td></tr>
                                        </table>					
                                        <div class="clear"></div>

                                        <button class="profile-meta-functions button"><span class="icon-16-eye"></span> Wink</button>
                                        <button class="profile-meta-functions button"><span class="icon-16-mail"></span> Send Message</button>

                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="clear"></div>
                </div>

                <?php
                include("aside.php");
                ?>
                <div class="clear"></div>		
            </div>
            <?php
            include("footer.php");
            ?>
        </div>

    </body>
</html>