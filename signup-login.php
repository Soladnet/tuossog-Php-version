<?php
session_start();
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['gender']) && (is_numeric($_POST['dob_day']) && $_POST['dob_day'] <= 31) && (is_numeric($_POST['dob_month']) && $_POST['dob_month'] <= 12) && (is_numeric($_POST['dob_yr']) && $_POST['dob_yr'] > 1959)) {
    if ($_POST['dob_day'] > 0 && $_POST['dob_yr'] > 0) {
        $_SESSION['data'] = $_POST;
    } else {
        $_SESSION['signup_perosnal_error']['message'] = "Month or Year cannot be negative";
        $_SESSION['signup_perosnal_error']['data'] = $_POST;
        header("Location: signup-personal?signup_error=");
    }
} else {
    if (!isset($_GET['signup_login_error'])) {
        $_SESSION['signup_perosnal_error']['message'] = "All fields in this stage are required";
        $_SESSION['signup_perosnal_error']['data'] = $_POST;
        header("Location: signup-personal?signup_error=");
        exit;
    }
}
?>
<!doctype html>
<html>
    <head>
        <?php
        include ("head.php");
        if (isset($_SESSION['signup_login_error']) && isset($_GET['signup_login_error'])) {
            ?>
            <link rel="stylesheet" href="css/jackedup.css">
            <script type="text/javascript" src="scripts/humane.min.js"></script>
            <script>
                humane.log("<?php echo $_SESSION['signup_login_error']['message']; ?>", {timeout: 10000, clickToClose: true, addnCls: 'humane-jackedup-error'});
            </script>
            <?php
        }
        ?>
        <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
        <script src="scripts/jquery-1.8.2.min.js" type="text/javascript">
        </script>
        <script src="scripts/languages/jquery.validationEngine-en.js" type="text/javascript">
        </script>
        <script src="scripts/jquery.validationEngine.js" type="text/javascript">
        </script>
        <script>
            jQuery(document).ready(function() {
                jQuery("#formID").validationEngine();
            });
        </script>

    </head>
    <body>
        <div class="index-page-wrapper">	
            <div class="index-nav">
                <span class="index-login">Already have an account? <a href="login">Login Here!</a></span>
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
                                You're almost there...! 
                            </h1>
                        </div>	
                        <progress max="100" value="50" >2 of 4 completed!</progress>
                        <hr>
                        <form id="formID" class="formular" action="signup-photo.php" method="POST">
                            <ul>
                                <li>
                                    <label for="email">eMail Address</label>
                                    <input  name="email" type="email" spellcheck="false" placeholder="e.g   your.email@example.com" class="validate[required,custom[email],ajax[ajaxUserCallPhp]] text-input input-fields" value="<?php echo isset($_SESSION['signup_login_error']['data']['email']) ? $_SESSION['signup_login_error']['data']['email'] : "" ?>" maxlength="50" /> 
                                </li>
                                <li>
                                    <label for="password">Password</label>
                                    <input  name="password" type="password" placeholder="Minimum of 6 characters" spellcheck="false" class="validate[required] text-input input-fields" value="" min="6" maxlength="255" required id="password"/> 
                                </li>
                                <li>
                                    <label for="cpassword">Confirm Password</label>
                                    <input  name="cpassword" type="password" placeholder="Re-type password" spellcheck="false" class="validate[required,equals[password]] text-input input-fields" value="" min="6" maxlength="255" required /> 
                                </li>
                            </ul>
                            <br>
                            <button class="button-big">Next!</button>
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
<?php
unset($_SESSION['signup_login_error']);
?>