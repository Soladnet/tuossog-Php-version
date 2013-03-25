<?php
session_start();
include_once './Config.php';

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cpassword'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
} else {
    $_SESSION['signup_login_error']['message'] = "Invalid Login credentials";
    header("Location: signup-login?signup_login_error=");
    exit();
}

if (isValidEmail($email)) {
    $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
    if ($mysql->connect_errno > 0) {
        $arrayToJs[] = TRUE;
        echo json_encode($arrayToJs);
    } else {
        $sql = "SELECT * FROM `user_personal_info` WHERE email = '" . clean($email) . "'";
        if ($result = $mysql->query($sql)) {
            if ($result->num_rows > 0) {
                if (isset($_COOKIE['user_auth'])) {
                    include_once './GossoutUser.php';
                    $userReg = new GossoutUser(0);
                    $resp['status'] = TRUE;
                    include_once './encryptionClass.php';
                    $encrypt = new Encryption();
                    $id = $encrypt->safe_b64decode($_COOKIE['user_auth']);
                    if (is_numeric($id)) {
                        $resp['id'] = $id;
                        if ($resp['status']) {
                            $userReg->setUserId($resp['id']);
                            $userReg->getProfile();
                        }
                    } else {
                        include_once './LoginClass.php';
                        $login = new Login();
                        $login->logout();
                    }
                } else {
                    $_SESSION['signup_login_error']['message'] = "User already registered";
                    $_SESSION['signup_login_error']['data'] = $_POST;
                    header("Location: signup-login?signup_login_error=");
                    exit();
                }
            } else {
                if ($pass == $cpass) {
                    include_once './GossoutUser.php';
                    $userReg = new GossoutUser(0);
                    if (!isset($_COOKIE['user_auth'])) {
                        $data = $_SESSION['data'];
                        $resp = $userReg->register(clean($data['first_name']), clean($data['last_name']), clean($email), md5($pass), $data['gender'], "$data[dob_yr]-$data[dob_month]-$data[dob_day]");
                    } else {
                        $resp['status'] = TRUE;
                        include_once './encryptionClass.php';
                        $encrypt = new Encryption();
                        $id = $encrypt->safe_b64decode($_COOKIE['user_auth']);
                        if (is_numeric($id)) {
                            $resp['id'] = $id;
                        } else {
                            include_once './LoginClass.php';
                            $login = new Login();
                            $login->logout();
                        }
                    }
                    if ($resp['status']) {
                        $userReg->setUserId($resp['id']);
                        $userReg->getProfile();
                    } else {
                        $_SESSION['signup_login_error']['message'] = $resp['message'];
                        $_SESSION['signup_login_error']['data'] = $_POST;
                        header("Location: signup-login?signup_login_error=");
                        exit();
                    }
                } else {
                    $_SESSION['signup_login_error']['message'] = "Password fields do not match";
                    $_SESSION['signup_login_error']['data'] = $_POST;
                    header("Location: signup-login?signup_login_error=");
                    exit();
                }
            }
        } else {
            $_SESSION['signup_login_error']['message'] = "Something terrible just went wrong...we will fix this as soon as possible";
            $_SESSION['signup_login_error']['data'] = $_POST;
            header("Location: signup-login?signup_login_error=");
            exit();
        }
    }
} else {

    $_SESSION['signup_login_error']['message'] = "Email is invlaid";
    $_SESSION['signup_login_error']['data'] = $_POST;
    header("Location: signup-login?signup_login_error=");
    exit();
}

function isValidEmail($email) {
    //Perform a basic syntax-Check
    //If this check fails, there's no need to continue
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    //extract host
    list($user, $host) = explode("@", $email);
    //check, if host is accessible
    if (!checkdnsrr($host, "MX") && !checkdnsrr($host, "A")) {
        return false;
    }
    return true;
}

function clean($value) {
    // If magic quotes not turned on add slashes.
    if (!get_magic_quotes_gpc()) {
        // Adds the slashes.
        $value = addslashes($value);
    }
    // Strip any tags from the value.
    $value = strip_tags($value);
    // Return the value out of the function.
    return $value;
}
?>
<!doctype html>
<html>
    <head>
        <?php
        include ("head.php");
        ?>
        <style>
            .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
            .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
            .percent { position:absolute; display:inline-block; top:3px; left:48%; }
        </style>
    </head>
    <body>
        <div class="index-page-wrapper">	
            <div class="index-nav">
                <span class="index-login"><?php echo "Welcome " . $userReg->getFullname() ?></span>
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
                                Upload a picture of you!
                            </h1>
                        </div>	
                        <progress max="100" value="75" >3 of 4 completed!</progress>
                        <hr>
                        <form id="uploadForm" method="POST" action="files-raw.php" enctype="multipart/form-data">
                            <ul>
                                <li>
                                    <label>Select an image: </label>
                                    <input type="file" name="myfile" class="input-fields">
                                    <p></p>
                                    <input type="submit" class="button" value="Upload photo">
                                    <hr>
                                    <div class="progress">
                                        <div class="bar"></div >
                                        <div class="percent">0%</div >
                                    </div>
                                    <div id="status"></div>
                                </li>
                            </ul>
                            <br>
                        </form>
                        <div class="button"><a href="signup-photo-edit?skip=">Skip</a></div>
                        <div class="button"><a href="signup-photo-edit">Next!</a></div>
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
        <script src="scripts/jquery-1.9.1.min.js"></script>
        <script src="scripts/jquery.form.js"></script>
        <script>
            (function() {
                var bar = $('.bar');
                var percent = $('.percent');
                var status = $('#status');

                $('#uploadForm').ajaxForm({
                    beforeSend: function() {
                        status.empty();
                        var percentVal = '0%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    complete: function(xhr) {
                        status.html(xhr.responseText);
                    }
                });

            })();
        </script>
    </body>
</html>