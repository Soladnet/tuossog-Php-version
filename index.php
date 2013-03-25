<?php
if(isset($_COOKIE['user_auth'])){
    if(isset($_GET['var1'])){
        echo $_GET['var1'];
    }
//    include './home.php';
}else{
    include './login.php';
}
?>