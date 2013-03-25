<?php
session_start();
$type = 'json'; //$_POST['mimetype'];
$xhr = true;
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']))
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

if ($type == 'xml') {
    header('Content-type: text/xml');
    ?> 
    <address attr1="value1" attr2="value2"> 
        <street attr="value">A &amp; B</street> 
        <city>Palmyra</city> 
    </address> 
    <?php
} else if ($type == 'json') {
    if (isset($_FILES['myfile'])) {
        $data = array();
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $ext = explode(".", $_FILES["myfile"]["name"]);
        $data['extension'] = strtolower(end($ext));
        $data['size'] = $_FILES['myfile']['size'] / 1024;
        if ((($_FILES["myfile"]["type"] == "image/gif") || ($_FILES["myfile"]["type"] == "image/jpeg") || ($_FILES["myfile"]["type"] == "image/png") || ($_FILES["myfile"]["type"] == "image/pjpeg")) && ($data['size'] < 2000 && $data['size'] > 5) && in_array($data['extension'], $allowedExts)) {
            if ($_FILES["myfile"]["error"] > 0) {
                echo "Error: " . $_FILES["myfile"]["error"];
            } else {
                $data['type'] = $_FILES['myfile']['type'];
                $data['name'] = $_FILES['myfile']['name'];
                $newPath = "upload/images/" . time() . $_SESSION['auth']['id'] . ".$data[extension]";
                move_uploaded_file($_FILES["myfile"]["tmp_name"], $newPath);
                include_once './GossoutUser.php';
                $userUploader = new GossoutUser($_SESSION['auth']['id']);
                $response = $userUploader->newPictureUpload($newPath);
                if ($response['status']) {
                    $data['status'] = TRUE;
                } else {
                    unlink($newPath);
                    $data['status'] = FALSE;
                    $data['msg'] = $response['msg'];
                }
            }
        } else {
            $data['status'] = FALSE;
            $data['msg'] = $response['msg'];
        }

        // wrap json in a textarea if the request did not come from xhr 
        if (!$xhr)
            echo '<textarea>';
        if ($data['status']) {
            echo "Upload Successful";
        } else {
            echo "Upload failed " . $data['msg'];
        }

        if (!$xhr)
            echo '</textarea>';
    }
}
else if ($type == 'script') {
    // wrap script in a textarea if the request did not come from xhr 
    if (!$xhr)
        echo '<textarea>';
    ?> 

    for (var i=0; i < 2; i++) 
    alert('Script evaluated!'); 

    <?php
    if (!$xhr)
        echo '</textarea>';
}
else {
    // return text var_dump for the html request 
    echo "VAR DUMP:<p />";
    var_dump($_POST);
    foreach ($_FILES as $file) {
        $n = $file['name'];
        $s = $file['size'];
        if (!$n)
            continue;
        echo "File: $n ($s bytes)";
    }
}
?>