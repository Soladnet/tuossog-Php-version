<?php

//echo strtolower($_SERVER['REQUEST_METHOD']);  
if (isset($_POST['param'])) {
    if ($_POST['param'] == "user") {
        include_once './GossoutUser.php';
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);

            if (is_numeric($id)) {
                $user = new GossoutUser($id);
                $profile = $user->getProfile();
                if ($profile['status']) {
                    header('Content-type: application/json');
                    echo json_encode($profile['user']);
                } else {
                    displayError(404, "Not Found");
                }
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "friends") {
        include_once './GossoutUser.php';
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);
            if (is_numeric($id)) {
                $user = new GossoutUser($id);
                $start = 0;
                $limit = 10;
                $status = "Y";
                if (isset($_POST['start']) && is_numeric($_POST['start'])) {
                    $start = $_POST['start'];
                }
                if (isset($_POST['limit']) && is_numeric($_POST['limit'])) {
                    $limit = $_POST['limit'];
                }
                if (isset($_POST['status'])) {
                    $status = $_POST['status'] == "N" ? "N" : "Y";
                }

                $friends = $user->getFriends($start, $limit, $status);
                if ($friends['status']) {
                    header('Content-type: application/json');
                    echo json_encode($friends['friends']);
                } else {
                    displayError(404, "Not Found");
                }
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "community") {
        include_once './Community.php';
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);
            if (is_numeric($id)) {
                $comm = new Community();
                $comm->setUser($id);
                $start = 0;
                $limit = 10;

                if (isset($_POST['start']) && is_numeric($_POST['start'])) {
                    $start = $_POST['start'];
                }
                if (isset($_POST['limit']) && is_numeric($_POST['limit'])) {
                    $limit = $_POST['limit'];
                }

                $user_comm = $comm->userComm($start, $limit);
                if ($user_comm['status']) {
                    header('Content-type: application/json');
                    echo json_encode($user_comm['community_list']);
                } else {
                    displayError(404, "Not Found");
                }
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else if (isset($_POST['m']) && is_numeric($_POST['m'])) {
            $comm = new Community();
            $comm->setUser($_POST['m']);

            $start = 0;
            $limit = 20;

            if (isset($_POST['start']) && is_numeric($_POST['start'])) {
                $start = $_POST['start'];
            }
            if (isset($_POST['limit']) && is_numeric($_POST['limit'])) {
                $limit = $_POST['limit'];
            }

            $com_mem = $comm->getMembers($start, $limit);
            if ($com_mem['status']) {
                header('Content-type: application/json');
                echo json_encode($com_mem['com_mem']);
            } else {
                displayError(404, "Not Found");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "messages") {
        include_once './GossoutUser.php';
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);
            if (is_numeric($id)) {
                $msg = new GossoutUser($id);
                $start = 0;
                $limit = 10;
                $timestamp = "";
                $status = "";
                if (isset($_POST['start']) && is_numeric($_POST['start'])) {
                    $start = $_POST['start'];
                }
                if (isset($_POST['limit']) && is_numeric($_POST['limit'])) {
                    $limit = $_POST['limit'];
                }
                if (isset($_POST['status'])) {
                    $status = $_POST['status'] == "" ? "" : "AND status='" . clean($_POST['status']) . "'";
                }
                if (isset($_POST['timestamp'])) {
                    if (trim($_POST['timestamp']) != "") {
                        $timestamp = clean(decodeText($_POST['timestamp']));
                        $status .= $status == "" ? "AND `time`>$timestamp" : " AND `time`>'$timestamp'";
                    }
                }
                $user_msg = $msg->getMessages($start, $limit, $status);
                setcookie("m_t", encodeText($user_msg['m_t']));
                if ($user_msg['status']) {
                    include_once("./sortArray_$.php");
                    $SMA = new SortMultiArray($user_msg['message'], "time", 1);
                    $SortedArray = $SMA->GetSortedArray($start, $limit);
                    header('Content-type: application/json');
                    echo json_encode($SortedArray);
                } else {
                    displayError(404, "Not Found");
                }
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "gossbag") {
        include_once './GossoutUser.php';
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);
            if (is_numeric($id)) {
                $bag = new GossoutUser($id);
                $start = 0;
                $limit = 10;
                if (isset($_POST['start']) && is_numeric($_POST['start'])) {
                    $start = $_POST['start'];
                }
                if (isset($_POST['limit']) && is_numeric($_POST['limit'])) {
                    $limit = $_POST['limit'];
                }

                $user_bag = $bag->getGossbag();
                if ($user_bag['status']) {
                    include_once("./sortArray_$.php");
                    $SMA = new SortMultiArray($user_bag['bag'], "time", 1);
                    $SortedArray = $SMA->GetSortedArray($start, $limit);
                    header('Content-type: application/json');
                    echo json_encode($SortedArray);
                } else {
                    displayError(404, "Not Found");
                }
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "notifSum") {
        include_once './GossoutUser.php';
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);
            if (is_numeric($id)) {
                $bag = new GossoutUser($id);

                $user_notif = $bag->getNotificationSummary();
                header('Content-type: application/json');
                echo json_encode($user_notif);
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "search") {
        include_once './Search.php';
        $search = new Search();
        if (isset($_POST['a'])) {
            $start = 0;
            $limit = 10;
            $opt = "both";
            $term = clean($_POST['a']);
            if (isset($_POST['start']) && is_numeric($_POST['start'])) {
                $start = $_POST['start'];
            }
            if (isset($_POST['limit']) && is_numeric($_POST['limit'])) {
                $limit = $_POST['limit'];
            }
            if (isset($_POST['opt'])) {
                $opt = $_POST['opt'];
            }

            $response = $search->search($term, $start, $limit, $opt);
            if ($response['status']) {
                header('Content-type: application/json');
                echo json_encode($response);
            } else {
                displayError(404, "Not Found");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "sugfriend") {
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);
            include_once './GossoutUser.php';
            $limit = 3;
            if (is_numeric($id)) {
                $user = new GossoutUser($id);
                $sug = $user->suggestFriend();
                if (isset($_POST['limit']) && is_numeric($_POST['limit'])) {
                    $limit = $_POST['limit'];
                }
                if ($sug['status']) {
                    header('Content-type: application/json');
                    echo json_encode(array_slice($sug['suggest'], (count($sug['suggest']) - $limit)));
                } else {
                    displayError(404, "Not Found");
                }
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "sugcomm") {
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);
            include_once './Community.php';
            $limit = 5;
            if (is_numeric($id)) {
                $com = new Community();
                $com->setUser($id);
                $sug = $com->suggest();
                if (isset($_POST['limit']) && is_numeric($_POST['limit'])) {
                    $limit = $_POST['limit'];
                }
                if ($sug['status']) {
                    header('Content-type: application/json');
                    echo json_encode(array_slice($sug['suggest'], (count($sug['suggest']) - $limit)));
                } else {
                    displayError(404, "Not Found");
                }
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else if ($_POST['param'] == "logError") {
        if (isset($_POST['uid'])) {
            $id = decodeText($_POST['uid']);
            if (is_numeric($id)) {
                $data = $_POST;
                $htmlHead = "<html><body>";
                $htmlHead .= "User id: $data[uid]<br/>";
                $htmlHead .= "errorThrown: $data[errorThrown]<br/>";
                $htmlHead .= "readyState: $data[readyState]<br/>";
                $htmlHead .= "statusCode: $data[statusCode]<br/>";
                $htmlHead .= "statusText: $data[statusText]<br/>";
                $htmlHead .= "textStatus: $data[textStatus]<br/>";
                $htmlHead .= "Message <br/>";
                $htmlHead .= "$data[responseText]";
                $htmlHead .= "</body></html>";

                @mail("Soladnet Team<soladnet@gmail.com>,Soladnet Team<ola@gossout.com>", "Error log: $data[errorThrown]", $htmlHead);
                header('Content-type: application/json');
                echo json_encode($data);
            } else {
                displayError(400, "The request cannot be fulfilled due to bad syntax");
            }
        } else {
            displayError(400, "The request cannot be fulfilled due to bad syntax");
        }
    } else {
        displayError(406, "The request is not acceptable");
    }
} else {
    displayError(400, "The request cannot be fulfilled due to bad syntax");
}

function displayError($code, $meesage) {
    $response_arr = array();
    $response_arr['error']['code'] = $code;
    $response_arr['error']['message'] = $meesage;
    header('Content-type: application/json');
    echo json_encode($response_arr);
}

function decodeText($param) {
    include_once './encryptionClass.php';
    $encrypt = new Encryption();
    return $encrypt->safe_b64decode($param);
}

function encodeText($param) {
    include_once './encryptionClass.php';
    $encrypt = new Encryption();
    return $encrypt->safe_b64decode($param);
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