<?php
//session_start();
if (isset($_COOKIE['user_auth'])) {
    include_once './encryptionClass.php';
    include_once './GossoutUser.php';
    $encrypt = new Encryption();
    $uid = $encrypt->safe_b64decode($_COOKIE['user_auth']);
    if (is_numeric($uid)) {
        $user = new GossoutUser($uid);
        $userProfile = $user->getProfile();
    }
} else {
    header("Location: login");
}
?>

<!doctype html>
<html>
    <head>
        <title>Gossout - Communities</title>
        <script type="text/javascript" src="scripts/jquery-1.9.1.min.js"></script>
        <?php
        include ("head.php");
        ?>
        <link rel="stylesheet" href="css/jackedup.css">
        <script type="text/javascript" src="scripts/humane.min.js"></script>
        <script type="text/javascript">
            $(function() {
                sendData("loadCommunity", {target: ".community-box", uid: readCookie('user_auth'),loadImage:true});
                sendData("loadNotificationCount",{uid: readCookie("user_auth"),title:document.title});
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
                <div class="communities-list">
                    <h1 id="pageTitle">Communities</h1>

                    <div class="community-search-box">
                        <input name="" class="community-search-field " placeholder="Search Communities" type="text" value="" required="">
                        <input type="submit" class="button" value="Search">
                    </div>
                    <div class="clear"></div>


                    <div class="community-box">

                        <!--                        <div class="community-box-wrapper">
                                                    <div class="community-image">
                                                        <img src="images/1.jpg">
                                                    </div>
                                                    <div class="community-text">
                                                        <div class="community-name"><a href="sample-community">Eko Radio Party</a> </div>
                                                        <hr>
                                                        <div class="details">ERP, a radio programme like no other... 
                                                            with sole objective of making serious issues light. We educate and entertain.
                        
                                                        </div>
                                                        <div class="members">200 Members</div>
                                                        <div class="members">200 Posts</div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>-->
                    </div>
                </div>

                <?php
                include("aside.php");
                ?>	
            </div>
            <?php
            include("footer.php");
            ?>
        </div>

    </body>
</html>