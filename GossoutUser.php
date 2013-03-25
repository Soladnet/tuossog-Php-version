<?php

require_once 'Config.php';

class GossoutUser {

    var $id, $fname, $lname, $fullname, $location, $gender, $url, $tel, $email, $screenName, $dob;

    /**
     * @author Soladnet Software
     * This class defined a Gossout user with the current supported properties and behaviour. All methods defined in this class that requires server connection implements their connection script
     * @param int $id
     */
    public function GossoutUser($id) {
        $this->id = $id;
    }

    /**
     * @return int The id of $this user is returned
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return String The first name of $this user is returned
     */
    public function getFirstname() {
        return $this->fname;
    }

    /**
     * @return String The last name of $this user is returned
     */
    public function getLastname() {
        return $this->lname;
    }

    /**
     * @return String The fullname of $this user is returned by calling getLastName() . " " . getFirstname(). " "
     */
    public function getFullname() {
        return $this->fname . " " . $this->lname . " ";
    }

    /**
     * @return String The location of $this user is returned
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * @return String The gender of $this user is returned
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * @return String The url of $this user is returned
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @return String The Phone number of $this user is returned
     */
    public function getTel() {
        return $this->tel;
    }

    /**
     * @return String The email of $this user is returned
     */
    public function getEmail() {
        return $this->email;
    }

    public function getScreenName() {
        return $this->screenName;
    }

    /**
     * @return String The date of birth of $this user is returned
     */
    public function getDOB() {
        return $this->dateToString($this->dob);
    }

    public function setUserId($newUid) {
        $this->id = $newUid;
    }

    /**
     * Get the profile of the current user if a valid user id was specified
     * @return Array An array containing $this user's profile information would be returned
     * @throws Exception is thrown when the connection to the server fails
     */
    function getProfile() {
        $arr = array();
        $response = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            // Make the variable a sql statement if the visitor is a registered and logged in user else make the variable hold the vlaue geust
            $sql = "SELECT id,firstname,lastname,email,username,gender,dob,phone,url,location FROM `user_personal_info` WHERE id = " . $this->id;

            //the condition will return true. if the id is not zero, then run query and enter block else enter block
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows > 0) {
                    $arr = $result->fetch_assoc();
                    $pix = $this->getProfilePix();
                    if ($pix['status']) {
                        $arr['photo'] = $pix['pix'];
                    } else {
                        $arr['photo'] = array("nophoto" => TRUE, "alt" => $pix['alt']);
                    }
                    $response['user'] = $arr;
                    $this->fname = $arr['firstname'];
                    $this->lname = $arr['lastname'];
                    $this->gender = $arr['gender'];
                    $this->location = $arr['location'];
                    $this->url = $arr['url'];
                    $this->tel = $arr['phone'];
                    $this->email = $arr['email'];
                    $this->screenName = $arr['username'];
                    $this->dob = $arr['dob'];
                    $response['status'] = true;
                } else {
                    $response['status'] = false;
                }
                $result->free();
            } else {
                $response['status'] = false;
            }
        }
        $mysql->close();
        return $response;
    }

    public function updateProfilePix($pix_id) {
        $response = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "SELECT * FROM profile_pix WHERE user_id=$this->id AND $pix_id=$pix_id";
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows == 0) {
                    $sql = "INSERT INTO profile_pix (pix_id,user_id) VALUES($pix_id,$this->id)";
                } else {
                    $sql = "UPDATE profile_pix SET `pix_id`=$pix_id WHERE user_id=$this->id";
                }
                $mysql->query($sql);
                if ($mysql->affected_rows > 0) {
                    $response['status'] = TRUE;
                } else {
                    $response['status'] = FALSE;
                }
                $result->free();
            }
        }
        $mysql->close();
        return $response;
    }

    public function getProfilePix() {
        $response = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "SELECT id,original,thumbnail,date_added FROM pictureuploads WHERE user_id=$this->id";
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows > 0) {
                    $response['status'] = TRUE;
                    while ($row = $result->fetch_assoc()) {
                        $response['pix'] = $row;
                    }
                } else {
                    $response['status'] = FALSE;
                    $response['alt'] = "images/profile-pix.jpg";
                }
            } else {
                $response['status'] = FALSE;
            }
        }
        $mysql->close();
        return $response;
    }

    public function newPictureUpload($param) {
        $response = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "INSERT INTO pictureuploads (user_id,original) VALUES($this->id,'$param')";
            if ($mysql->query($sql)) {
                if ($mysql->affected_rows > 0) {
                    $response['status'] = TRUE;
                    $response['id'] = $mysql->insert_id;
                } else {
                    $response['status'] = FALSE;
                }
            } else {
                $response['status'] = FALSE;
            }
        }
        $mysql->close();
        return $response;
    }

    public function updateThumbnail($pix_id, $thumb) {
        $response = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "UPDATE pictureuploads SET thumbnail='$thumb' WHERE id=$pix_id";
            $mysql->query($sql);
            if ($mysql->affected_rows > 0) {
                $response['status'] = TRUE;
            } else {
                $response['status'] = FALSE;
            }
        }
        $mysql->close();
        return $response;
    }

    /**
     * 
     * @param int $start This specifies where the query starts from for pagination
     * @param int $limit This specifies the end of the result for pagination
     * @param String $status Either 'Y' or 'N' defualt is 'Y'
     * @return Array This method fetches this user's friends with fetch limit of 20
     * @throws Exception is thrown when the connection to the server fails
     */
    public function getFriends($start, $limit, $status = "Y", $shuffle = FALSE) {
        $arrFetch = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        //$count = 0;
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $str = "Select if(uc.username1=$this->id,uc.username2,uc.username1) as id,username,firstname, lastname,location,gender From user_personal_info, usercontacts as uc Where (username1 = user_personal_info.id AND username2 = $this->id) OR (username2 = user_personal_info.id AND username1 = $this->id) AND status ='$status' LIMIT $start,$limit";
            if ($result = $mysql->query($str)) {
                if ($result->num_rows > 0) {
                    $user = new GossoutUser(0);
                    while ($row = $result->fetch_assoc()) {
                        $user->setUserId($row['id']);
                        $pix = $user->getProfilePix();
                        if ($pix['status']) {
                            $row['photo'] = $pix['pix'];
                        } else {
                            $row['photo'] = array("nophoto" => TRUE, "alt" => $pix['alt']);
                        }

                        $arrFetch['friends'][] = $row;
                    }
                    if ($shuffle) {
                        shuffle($arrFetch['friends']);
                    }
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

    public function countUserFriends() {
        $arrFetch = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        //$count = 0;
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $str = "Select count(if(uc.username1=$this->id,uc.username2,uc.username1)) as count From usercontacts as uc Where if(uc.username1<>$this->id,uc.username2,uc.username1) = $this->id AND status ='Y'";
            if ($result = $mysql->query($str)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $arrFetch['friends_count'] = $row;

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

    public function suggestFriend() {
        $arrfetch = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        //$count = 0;
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            //suggest frinds of my friends
            $my = $this->getFriends(0, 1000);
            $arr = array();
            if ($my['status']) {
                foreach ($my['friends'] as $friend) {
                    $user = new GossoutUser($friend['id']);
                    $userFriend = $user->getFriends(0, 1000);
                    if ($userFriend['status']) {
                        foreach ($userFriend['friends'] as $userFrnd) {
                            $arr[$userFrnd['id']] = $userFrnd;
                        }
                    }
                }
                $arrfetch['status'] = TRUE;
            } else {
                $arrfetch['status'] = FALSE;
            }
            include_once './Community.php';
            $com = new Community();
            $com->setUser($this->id);
            //suggest people from community i belong
            $myCom = $com->userComm(0, 1000);
            if ($myCom['status']) {
                foreach ($myCom['community_list'] as $userComm) {
                    $com->setCommunityId($userComm['id']);
                    $comMem = $com->getMembers(0, 1000);
                    foreach ($comMem['com_mem'] as $mem) {
                        $arr[$mem['id']] = $mem;
                    }
                }
                $arrfetch['status'] = TRUE;
            } else {
                if (!$arrfetch['status']) {
                    $arrfetch['status'] = FALSE;
                }
            }
            if ($arrfetch['status']) {
                unset($arr[$this->id]);
                if ($my['status']) {
                    foreach ($my['friends'] as $friend) {
                        if (array_key_exists($friend['id'], $arr)) {
                            unset($arr[$friend['id']]);
                        }
                    }
                    if(count($arr)==0){
                        $arrfetch['status'] = FALSE;
                    }
                }
                $arrfetch['suggest'] = array_values($arr);
                shuffle($arrfetch['suggest']);
            }
        }

        return $arrfetch;
    }

    /**
     * 
     * @param int $start This specifies where the query starts from for pagination
     * @param int $limit This specifies the end of the result for pagination
     * @param String $status
     * @return Array
     * @throws Exception is thrown when the connection to the server fails
     */
    public function getMessages($start, $limit, $status) {
        $arrFetch = array();
        $temp = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "SELECT pm.`id`, pm.`sender_id`,u.firstname,u.lastname, pm.`message`, pm.`time`, pm.`status` FROM `privatemessae` as pm JOIN user_personal_info as u ON pm.sender_id=u.id WHERE pm.`receiver_id` = $this->id $status order by pm.id ASC LIMIT $start,$limit";
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows > 0) {
                    $user = new GossoutUser(0);
                    while ($row = $result->fetch_assoc()) {
                        $user->setUserId($row['sender_id']);
                        $pix = $user->getProfilePix();
                        if ($pix['status']) {
                            $row['photo'] = $pix['pix'];
                        } else {
                            $row['photo'] = array("nophoto" => TRUE, "alt" => $pix['alt']);
                        }
                        $temp[$row['sender_id']] = $row;
                        if($row['status']=="N"){
                            $mysql->query("UPDATE `privatemessae` SET `status`='D' WHERE `id`=$row[id]");
                        }
                    }
                    $arrFetch['message'] = array_values($temp);
                    $arrFetch['status'] = TRUE;
                } else {
                    $arrFetch['status'] = FALSE;
                }
                $result->free();
            } else {
                $arrFetch['status'] = FALSE;
            }
            $result = $mysql->query("SELECT NOW() as time");
            $row = $result->fetch_assoc();
            $result->free();
            $arrFetch['m_t'] = $row['time'];
        }
        $mysql->close();
        return $arrFetch;
    }

    /**
     * Fetches user’s gossbag combining post,comment, and tweak and wink
     * @return Array
     * @throws Exception is thrown when the connection to the server fails
     */
    public function getGossbag() {
        $arrFetch = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "SELECT p.`id`, p.`post`, p.`community_id`, p.`sender_id`,u.firstname,u.lastname, p.`time`, p.`status` FROM post as p JOIN `community_subscribers` as cs ON p.community_id=cs.community_id JOIN user_personal_info as u ON p.sender_id=u.id JOIN usercontacts as uc ON (p.sender_id=uc.username1 AND uc.username2=$this->id) OR (p.sender_id=uc.username2 AND uc.username1=$this->id) AND uc.status='Y' WHERE cs.user=$this->id AND p.sender_id<>$this->id order by p.time desc";
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['type'] = "post";
                        $arrFetch['bag'][] = $row;
                    }
                    $arrFetch['status'] = TRUE;
                } else {
                    $arrFetch['status'] = FALSE;
                }
                $result->free();
            } else {
                $arrFetch['status'] = FALSE;
            }

            $sql = "SELECT c.`id`, c.`comment`, c.`post_id`, c.`sender_id`,u.firstname,u.lastname, c.`time` FROM comments as c JOIN `post` as p ON c.post_id=p.id JOIN community_subscribers as cs ON cs.community_id=p.community_id JOIN user_personal_info as u ON c.sender_id=u.id JOIN usercontacts as uc ON (p.sender_id=uc.username1 AND uc.username2=$this->id) OR (p.sender_id=uc.username2 AND uc.username1=$this->id ) AND uc.status='Y' WHERE cs.user=$this->id AND c.sender_id<>$this->id order by c.time desc";
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['type'] = "comment";
                        $arrFetch['bag'][] = $row;
                    }
                    $arrFetch['status'] = TRUE;
                } else {
                    if (!$arrFetch['status'])
                        $arrFetch['status'] = FALSE;
                }
                $result->free();
            } else {
                if (!$arrFetch['status'])
                    $arrFetch['status'] = FALSE;
            }

            $sql = "SELECT t.`id`, t.`sender_id`,u.firstname,u.lastname, t.`type`, t.`time`, t.`status` FROM `tweakwink` as t JOIN user_personal_info as u ON t.sender_id=u.id  WHERE t.`receiver_id` =$this->id order by t.time desc";
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['type'] = "TW";
                        $arrFetch['bag'][] = $row;
                    }
                    $arrFetch['status'] = TRUE;
                } else {
                    if (!$arrFetch['status'])
                        $arrFetch['status'] = FALSE;
                }
                $result->free();
            } else {
                if (!$arrFetch['status'])
                    $arrFetch['status'] = FALSE;
            }
        }
        return $arrFetch;
    }
    public function getNotificationSummary() {
        $gb = $this->getGossbag();
        $msg = $this->getMessages(0, 1000, "AND status='N'");
        $response['msg'] = $msg['status']?count($msg['message']):0;
        $response['gb'] = $gb['status']?count($gb['bag']):0;
        return $response;
    }
    public function getTimeline() {
        $arrFetch = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "SELECT p.`id`, p.`post`, p.`community_id`, p.`sender_id`,u.firstname,u.lastname, p.`time`, p.`status` FROM post as p JOIN `community_subscribers` as cs ON p.community_id=cs.community_id JOIN user_personal_info as u ON p.sender_id=u.id JOIN usercontacts as uc ON (p.sender_id=uc.username1 AND uc.username2=$this->id) OR (p.sender_id=uc.username2 AND uc.username1=$this->id) AND uc.status='Y' WHERE cs.user=$this->id AND p.sender_id<>$this->id order by p.time desc";
            if ($result = $mysql->query($sql)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $arrFetch['message'][] = $row;
                    }
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

    public function register($firstname, $lastname, $email, $password, $gender, $dob) {
        $arrFetch = array();
        $mysql = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if ($mysql->connect_errno > 0) {
            throw new Exception("Connection to server failed!");
        } else {
            $sql = "INSERT INTO `user_personal_info`(`firstname`, `lastname`, `email`, `gender`, `dob`) VALUES ('$firstname','$lastname','$email','$gender','$dob')";
            if ($mysql->query($sql)) {
                if ($mysql->affected_rows > 0) {
                    $newUid = $mysql->insert_id;
                    $token = md5(strtolower($email . $lastname . $password));
                    $sql = "INSERT INTO `user_login_details`(`id`, `password`, `token`) VALUES ('$newUid','$password','$token')";
                    $mysql->query($sql);
                    if ($mysql->affected_rows > 0) {
                        include_once './encryptionClass.php';
                        $encrypt = new Encryption();
                        setcookie("user_auth", $encrypt->safe_b64encode($newUid));
                        $this->setUserId($newUid);
                        $user = $this->getProfile();
                        $_SESSION['auth'] = $user['user'];
                        $arrFetch['status'] = TRUE;
                        $arrFetch['id'] = $newUid;
                    } else {
                        $sql = "DELETE FROM `user_personal_info` WHERE `id`=$newUid";
                        $mysql->query($sql);
                        $arrFetch['status'] = FALSE;
                        $arrFetch['message'] = "An unexpected error just occured. Please try again some minutes later.";
                    }
                } else {
                    $arrFetch['status'] = FALSE;
                    $arrFetch['message'] = "An unexpected error just occured. Please try again some minutes later.";
                }
            } else {
                $arrFetch['status'] = FALSE;
                $arrFetch['message'] = "An unexpected error just occured. Please try again some minutes later.";
            }
        }
        $mysql->close();
        return $arrFetch;
    }

    public function getMiniStat($param = "ALL") {
        include_once './Post.php';
        include_once './Community.php';
        $userCom = new Community();
        $post = new Post();
        $post->setUserId($this->getId());
        $userCom->setUser($this->getId());

        $com_count = 0;
        $user_count = 0;
        $post_count = 0;

        $comCount = $userCom->userCommunityCount();
        if ($comCount['status']) {
            $com_count = $comCount['com_count']['count'];
        }

        $userCount = $this->countUserFriends();
        if ($userCount['status']) {
            $user_count = $userCount['friends_count']['count'];
        }

        $postCount = $post->countUserPosts();
        if ($postCount['status']) {
            $post_count = $postCount['post_count']['count'];
        }
        if ($param == "ALL") {
            return array("fc" => $user_count, "cc" => $com_count, "pc" => $post_count);
        } else if ($param == "fc") {
            return $user_count;
        } else if ($param == "cc") {
            return $com_count;
        } else if ($param == "pc") {
            return $post_count;
        }
    }

    /**
     * 
     * @param String $date The string date format from the database in the format yyyy-mm-dd
     * @param boolean $withYear specify whether the year should be displayed or not. DEAFULT value is 'FALSE'
     * @return String This returns the formated string in the form  13 January 2014
     */
    private function dateToString($date, $withYear = false) {
        if (trim($date) == "") {
            return "";
        } else {
            $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $arr = explode('-', $date);
            if ($withYear) {
                $str = $arr[2] . " " . $month[$arr[1] - 1] . ", " . $arr[0];
            } else {
                $str = $arr[2] . " " . $month[$arr[1] - 1];
            }
            return $str;
        }
    }

    public function toSentenceCase($str) {
        $arr = explode(' ', $str);
        $exp = array();
        foreach ($arr as $x) {
            if (strtolower($x) == "of") {
                $exp[] = strtolower($x);
            } else {
                if (strlen($x) > 0) {
                    $exp[] = strtoupper($x[0]) . substr($x, 1);
                } else {
                    $exp[] = strtoupper($x);
                }
            }
        }
        return implode(' ', $exp);
    }

}

?>
