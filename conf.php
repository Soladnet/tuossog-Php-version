<?php

session_start();
//include_once 'Config.php';
include 'GossoutUser.php';
$user = new GossoutUser(59);
if (isset($_GET['del'])) {
    unset($_SESSION['val']);
    unset($_SESSION['auth']);
} else {
    $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
    $sql = "SELECT * FROM `user_personal_info` WHERE id = 59";
    $result = $mysql->query($sql);
    $rest = $result->fetch_assoc();
    echo $rest['id']==""?"N/A":$rest['id'];
    echo "<br/>";
    echo $user->getCommunityCount();
    $mysql->close();
}
//print_r($_SESSION);
?>
