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
        <script type="text/javascript" src="scripts/jquery-1.9.1.min.js"></script>
        <?php
        include ("head.php");
        ?>
        <link rel="stylesheet" href="css/jackedup.css">
        <script type="text/javascript" src="scripts/humane.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
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
                <div class="settings-list">
                    <h1>Settings</h1>
                    <hr>
                    <hr>
                    <div class="individual-setting">
                        <h2>Basic Settings</h2>
                        <p>Name</p>
                        <p>Email</p>
                        <p>Password</p>
                    </div>
                    <div class="individual-setting">
                        <h2>Privacy</h2>
                        <p> <input type="checkbox"> Make my account private</p>
                    </div>
                    <div class="individual-setting">
                        <h2>Notifications</h2>
                        <p> <input type="checkbox"> Receive notifications through e-mail</p>
                    </div>
                    <input type="button" class="button submit" value="Save Changes">	
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