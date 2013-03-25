<?php
if(isset($_GET['view'])){
    echo $_GET['view'];
}  else {
    include 'index.php';
}
?>