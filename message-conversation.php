<?php
session_start();
if (isset($_COOKIE['user_auth'])) {
    include_once './encryptionClass.php';
    include_once './GossoutUser.php';
    include_once './Community.php';
    $userCom = new Community();
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
        <title>
            Gossout - Conversation
        </title>
        <link rel="stylesheet" href="css/jackedup.css">
        <script type="text/javascript" src="scripts/jquery-1.9.1.min.js"></script>
        <?php
        include ("head.php");
        ?>
        <!-- <link rel="stylesheet" href="css/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" /> -->
        <script type="text/javascript" src="scripts/jquery.fancybox.pack.js?v=2.1.4"></script>
        <script type="text/javascript" src="scripts/humane.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                sendData("loadNotificationCount", {uid: readCookie("user_auth"), title: document.title});
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

                <div class="all-messages-list">
                    <h2> <a href="#">Ciroma Chukwuma Adekunle <span class="icon-16-chat"></span></a></h2>
                    <hr>
                    <div class="compose-box">
                        <form>
                            <textarea required placeholder="Compose a message"></textarea>
                            <input type="submit" class="submit button float-right" value="Send">
                            <button class="button float-right hint hint--left" data-hint ="Upload Image"><span class="icon-16-camera"></span></button>
                        </form>
                        <div class="clear"></div>
                    </div>

                    <div class="float-right"><span class="icon-16-reply"></span><a href="messages" class="back">Back to messages</a></div>
                    <div class="individual-message-box">
                        <p>
                            <span class="all-messages-time"> 19 hrs </span>
                        </p>
                        <img class= "all-messages-image" src="images/1.jpg">
                        <div class="all-messages-text"> 
                            <a href=""><h3>Chiroma Chukwuma Adekunle </h3></a>
                            <div class="all-messages-message">Lorem</div>
                        </div>    
                    </div>
                    <div class="individual-message-box">
                        <p>
                            <span class="all-messages-time"> 17 hrs </span>
                        </p>
                        <img class= "all-messages-image" src="images/1.jpg">
                        <div class="all-messages-text"> 
                            <a href=""><h3>Chiroma Chukwuma Adekunle </h3></a>
                            <div class="all-messages-message">
                                <span class="icon-16-reply"></span> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor.....</div>
                        </div>   
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