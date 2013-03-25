<?php
include_once './Config.php';
/**
 * Description of Post
 *
 * @author user
 */
class Post {

    var $uid, $comId;

    public function __construct() {
        
    }

    public function countUserPosts() {
        $arrFetch = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        //$count = 0;
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "SELECT count(`id`) as count FROM `post` WHERE `sender_id` = $this->uid";
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $arrFetch['post_count'] = $row;

                    $arrFetch['status'] = TRUE;
                } else {
                    $arrFetch['status'] = FALSE;
                }
                $result->free();
            } else {
                $arrFetch['status'] = FALSE;
            }
        }
        $mysql->close();
        return $arrFetch;
    }

//    public function countAllUserPosts() {
//        
//    }
    public function getUserId() {
        return $this->uid;
    }

    public function getCommunityId() {
        $this->comId;
    }

    public function setUserId($newUid) {
        $this->uid = $newUid;
    }

    public function setCommunity($newComId) {
        $this->comId = $newComId;
    }

}

?>
