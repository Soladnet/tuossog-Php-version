<?php
session_start();
if (isset($_COOKIE['user_auth'])) {
    include_once './encryptionClass.php';
    include_once './GossoutUser.php';
    $encrypt = new Encryption();
    $user = new GossoutUser(0);
    $id = $encrypt->safe_b64decode($_COOKIE['user_auth']);
    if (is_numeric($id)) {
        $user->setUserId($id);
        $user->getProfile();
    } else {
        include_once './LoginClass.php';
        $login = new Login();
        $login->logout();
    }
} else {
    include_once './LoginClass.php';
    $login = new Login();
    $login->logout();
}
?>
<!doctype html>
<html>
    <head>
        <?php
        include ("head.php");
        ?>
    </head>
    <body>
        <div class="index-page-wrapper">	
            <div class="index-nav">
                <span class="index-login"><?php echo "Welcome " . $user->getFullname() ?></span>
                <div class="clear"></div>
            </div>
            <div class="index-banner">
                <div class="index-logo">
                    <img src="images/gossout-logo-text-and-image-svg.svg" alt="logo" >
                </div>
            </div>
            <div class="index-intro">		
                <div class="index-intro-2">
                    <div class="registration">
                        <div class="index-intro-1">
                            <h1>
                                Please read carefully! 
                            </h1>
                        </div>
                        <progress max="100" value="95" >95% done!</progress>
                        <hr>
                        <form>
                            <ul>
                                <li>
                                    <p class="info">
                                        By clicking <strong>Finish</strong>, you agree to our 
                                        <a href="">Terms of Service!</a>
                                    </p>
                                    <p class="info">
                                        We use <a href="http://en.wikipedia.org/wiki/HTTP_cookie">cookies</a>  to ensure that we give 
                                        you the best experience on our website. <!-- We also use cookies 
                                        to ensure we show you advertising that is relevant to you. --> 
                                        If you continue, we'll assume that you 
                                        are happy to receive all <a href="http://en.wikipedia.org/wiki/HTTP_cookie">cookies</a> on this website. 

                                    </p>
                                </li>
                            </ul>
                            <br>
                            <div class="button"><a href="home">Finish!</a></div>
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="index-shadow-bottom"></div>
            <div class="index-content-wrapper">
                <?php
                include("footer.php");
                ?>
            </div>

        </div>
    </body>
</html>