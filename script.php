<?php
include_once('db.php');
date_default_timezone_set('Asia/Kolkata');
?>
<?php
//Returns status, If Reward Scheme is active or not
function getStatus($r_id, $link)
{
    $sql = "select r_status from reward_list where r_id=$r_id";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Fetching Status Unsuccessfull";
    } else {

        while ($row = mysqli_fetch_assoc($result)) {
            $r_status = $row["r_status"];
            return $r_status;
        }
    }
}
//Returns Latest points of that particular Reward Scheme
function getPoints($r_id, $link, $user_id)
{
    $sql = "select r_points from reward_list where r_id=$r_id";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Fetching Points Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $r_points = $row["r_points"];
            $date1 = (date("Y-m-d H:i:s"));
            $sql = "select user_id from user_reward where premium_exp>='$date1' and user_id = $user_id";
            // echo $sql;
            $result = mysqli_query($link, $sql);
            $result = mysqli_fetch_array($result);
            if ($result) {
                $sql = "select value from settings where s_id = 10";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $extra_point = $row['value'];
                }
                $extra_point = ($extra_point / 100) + 1;
                return $r_points * $extra_point;
            }
            return $r_points;
        }
    }
}
// echo getPoints(11, $link, 27);
function getUserRewardPoints($link, $user_id)
{
    $sql = "select user_reward from user_reward where user_id = $user_id";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Getting User Points Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $user_reward = $row["user_reward"];
        }
        return $user_reward;
    }
}

//Get Premium Days left
function getUserPremiumDays($link, $user_id)
{
    $sql = "select premium_exp from user_reward where user_id = $user_id";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Getting User Points Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $premium_exp = $row["premium_exp"];
        }
        return $premium_exp;
    }
}

//Adds log when reward transaction will happen
function addRewardLog($link, $user_id, $r_id, $r_points)
{
    $sql = "insert into reward_log (user_id, r_id, r_points) values($user_id, $r_id, $r_points)";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Couldn't add new log";
    } else {
        echo "Log added";
    }
}
// Updates user points When user gets points or redeems points
function updateUserPoints($link, $user_id, $r_id)
{
    $user_reward = getUserRewardPoints($link, $user_id);
    $r_points = getPoints($r_id, $link, $user_id);
    $update_points = $user_reward + $r_points;
    $sql = "UPDATE user_reward SET user_reward= $update_points WHERE user_id =$user_id";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Updating user reward points unsuccessfull";
    }
}

// Redeem calculation function
function subtractUserPoints($link, $user_id, $disc)
{
    $r_id = 7;
    $user_reward = getUserRewardPoints($link, $user_id);
    $update_points = $user_reward - $disc;
    if ($update_points < 0) {
        if ($user_reward != 0) {
            echo "You will get discount of: ", $user_reward;
            $update_points = 0;
            $sql = "UPDATE user_reward SET user_reward= $update_points WHERE user_id =$user_id";
            $result = mysqli_query($link, $sql);
            if (!$result) {
                echo "Updating user reward points unsuccessfull";
            } else {
                addRewardLog($link, $user_id, $r_id, $user_reward);
                echo "Discount: ", $user_reward;
                $date1 = (date("Y-m-d H:i:s"));
                $sql = "update user_reward set last_point_used = '$date1' where user_id=$user_id";
                mysqli_query($link, $sql);
            }
        } else {
            echo "Insufficient Points";
        }
    } else {
        $sql = "UPDATE user_reward SET user_reward= $update_points WHERE user_id =$user_id";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "Updating user reward points unsuccessfull";
        } else {
            addRewardLog($link, $user_id, $r_id, $disc);
            echo "You will get discount of: ", $disc;
            echo "Discount: ", $disc;
            $date1 = (date("Y-m-d H:i:s"));
            $sql = "update user_reward set last_point_used = '$date1' where user_id=$user_id";
            mysqli_query($link, $sql);
        }
    }
}
// Add respective points to respective user if ...
function newOrderTookPlace($link, $user_id)
{
    $r_id = 1;
    $r_points = getPoints($r_id, $link, $user_id);
    // echo $r_points;

    if (getStatus($r_id, $link) > 0) {
        updateUserPoints($link, $user_id, $r_id);
        addRewardLog($link, $user_id, $r_id, $r_points);
    }
}
// Add respective points to respective user if ...
function last3Order($link, $user_id)
{
    if (last3OrderApplicable($link, $user_id)) {
        $r_id = 2;
        $r_points = getPoints($r_id, $link, $user_id);
        if (getStatus($r_id, $link) > 0) {
            updateUserPoints($link, $user_id, $r_id);
            addRewardLog($link, $user_id, $r_id, $r_points);
        }
    }
}
// Add respective points to respective user if ...
function newAccountCreated($link, $fk_user_id, $refer_username)
{
    $r_id = 3;
    if (getStatus($r_id, $link) > 0) {
        // echo "Activated";
        $r_points = getPoints($r_id, $link, $fk_user_id);
        if (!isset($refer_username) || $refer_username == NULL || strlen($refer_username) < 2) {
            $sql = "insert into user_reward (fk_user_id, user_reward, refer_user_id) values($fk_user_id,$r_points,NULL)";
            // echo " NO";
        } else {
            $sql = "insert into user_reward (fk_user_id, user_reward, refer_user_id) values($fk_user_id,$r_points, (select ur.user_id from user_reward ur where ur.fk_user_id = (select u.id from users u where u.username = '$refer_username')))";
            // echo " ref";
        }
        $result = mysqli_query($link, $sql);
        // $result = null;
        if ($result) {
            $user_id = fk_id_to_user_id($link, $fk_user_id);
            // echo $fk_user_id + " : " + $user_id;
            if (getStatus(10, $link) > 0 &&(isset($refer_username) || $refer_username != NULL || strlen($refer_username) > 2)) {
                $r_points2 = getPoints(10, $link, $fk_user_id);
                addRewardLog($link, $user_id, 10, $r_points2);
                updateUserPoints($link, $user_id, 10);
            } else {
                addRewardLog($link, $user_id, 10, 0);
            }
            if (getStatus(11, $link) > 0 &&(isset($refer_username) || $refer_username != NULL || strlen($refer_username) > 2)) {
                $sql = "select refer_user_id from user_reward where fk_user_id = $fk_user_id ";
                $result2 = mysqli_query($link, $sql);
                if ($result2) {
                    $refer_user_id = mysqli_fetch_array($result2)[0];
                    updateUserPoints($link, $refer_user_id, 11);
                    addRewardLog($link, $refer_user_id, 11, getPoints(11, $link, $refer_user_id));
                }
            }
            addRewardLog($link, $user_id, $r_id, $r_points);
        } else {
            echo "Couldn't add new user ";
        }

    } else {
        if (!isset($refer_username) || $refer_username == NULL || strlen($refer_username) < 2) {
            $sql = "insert into user_reward (fk_user_id, refer_user_id) values($fk_user_id, NULL)";
        } else {
            $sql = "insert into user_reward (fk_user_id, refer_user_id) values($fk_user_id, (select ur.user_id from user_reward ur where ur.fk_user_id = (select u.id from users u where u.username = '$refer_username')))";
        }
        $result = mysqli_query($link, $sql);
        if ($result) {
            $user_id = fk_id_to_user_id($link, $fk_user_id);
            // $user_id = getLatestUserID($link);
            if (getStatus(10, $link) > 0 &&(isset($refer_username) || $refer_username != NULL || strlen($refer_username) > 2)) {
                $r_points2 = getPoints(10, $link, $fk_user_id);
                addRewardLog($link, $user_id, 10, $r_points2);
            } else {
                addRewardLog($link, $user_id, 10, 0);
            }
            addRewardLog($link, $user_id, $r_id, 0);

            if (getStatus(11, $link) > 0 &&(isset($refer_username) || $refer_username != NULL || strlen($refer_username) > 2)) {
                $sql = "select refer_user_id from user_reward where fk_user_id = $fk_user_id ";
                $result2 = mysqli_query($link, $sql);
                if ($result2) {
                    $refer_user_id = mysqli_fetch_array($result2)[0];
                    updateUserPoints($link, $refer_user_id, 11);
                    addRewardLog($link, $refer_user_id, 11, getPoints(11, $link, $refer_user_id));
                }
            }
        } else {
            echo "Couldn't add new user ";
        }
    }
}
// newAccountCreated($link, 12, 'nityam2');
// Add respective points to respective user if ...
function newReviewAdded($link, $user_id, $order_id)
{
    $r_id = 4;
    $flag = 0;
    if (getStatus($r_id, $link) > 0) {
        $sql = "select id from s_orders where fk_user_id = (select fk_user_id from user_reward where user_id = $user_id)";
        $result = mysqli_query($link, $sql);
        // $result = null;
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $order_id_r = $row['id'];
                if ($order_id == $order_id_r) {
                    $flag = 1;
                    break;
                }
            }
            if ($flag == 1) {
                $r_points = getPoints($r_id, $link, $user_id);
                updateUserPoints($link, $user_id, $r_id);
                addRewardLog($link, $user_id, $r_id, $r_points);
            } else {
                echo "You will not get any points";
            }
        }
    }
}
// Add respective points to respective user if ...
function userActivatesNewsLetter($link, $user_id)
{
    $r_id = 5;
    $r_points = getPoints($r_id, $link, $user_id);
    if (getStatus($r_id, $link) > 0) {
        updateUserPoints($link, $user_id, $r_id);
        addRewardLog($link, $user_id, $r_id, $r_points);
    }
}
// Add respective points to respective user if ...
function newOrderBefore7Days($link, $user_id)
{
    if (lastOrder7Applicable($link, $user_id) == 1) {
        $r_id = 6;
        $r_points = getPoints($r_id, $link, $user_id);
        if (getStatus($r_id, $link) > 0) {
            updateUserPoints($link, $user_id, $r_id);
            addRewardLog($link, $user_id, $r_id, $r_points);
        }
    }
}
//Checks if Percentage option is selected or Number option
function percentage_number_reward($link)
{
    $sql = "select value from settings where s_id=1";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Fetching Value Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $r_points = $row["value"];
            return $r_points;
        }
    }
}

//Check what is minimum order value to check eligibilty of redeeming points
function getMinOrderValue($link)
{
    $sql = "select value from settings where s_id=3";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Fetching Value Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $r_points = $row["value"];
            return $r_points;
        }
    }
}
//returns Maximum reedemable points at once
function getMaxReedemPoints($link)
{
    $sql = "select value from settings where s_id=4";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Fetching Value Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $r_points = $row["value"];
            return $r_points;
        }
    }
}
//When user places order, Calculate Usable points based on order value
function usePoints($link, $user_id, $order_value)
{
    $r_id = 7;
    if (getStatus($r_id, $link) > 0 && getMinOrderValue($link) <= $order_value) {
        $r_points_per = getPoints($r_id, $link, $user_id);
        if (percentage_number_reward($link) > 0) {
            $disc = (int) (($order_value * $r_points_per) / 100);
        } else {
            $disc = $r_points_per;
        }
        $maxPoints = getMaxReedemPoints($link);
        if ($maxPoints <= $disc) {
            $disc = $maxPoints;
        }
        return $disc;
        // subtractUserPoints($link, $user_id, $disc);
    } else {
        // echo "Scheme is deactivated or Order value is too low";
        return 0;
    }
}
// Adds newly added user to our DB, When this script runs
function scriptNewUsers($link)
{
    // $last_user_sync_time = getLastUserSyncTime($link);
    // $sql = "SELECT id,date_added,refer_username FROM users WHERE (date_added) > '$last_user_sync_time'";
    $sql = "SELECT id,date_added,refer_username FROM users WHERE (sync)=0";
    $result = mysqli_query($link, $sql);
    $date_added = null;
    if (!$result) {
        echo "Getting IDs Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $fk_user_id = $row["id"];
            $refer_username = $row["refer_username"];
            newAccountCreated($link, $fk_user_id, $refer_username);
            $newsql = "update users set sync = 1 where id = $fk_user_id";
            mysqli_query($link, $newsql);
            $date_added = $row["date_added"];

        }
        if ($date_added) {
            $date1 = new DateTime();
            $date1 = $date1->format('Y-m-d H:i:s');
            $sql = "UPDATE settings set value='$date1' WHERE s_id=5";
            mysqli_query($link, $sql);
        }
    }
}
// scriptNewUsers($link);

//Returns when was last time new user was added
function getLastUserSyncTime($link)
{
    $sql = "select value from settings where s_id=5";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Getting Last User Sync Time Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $last_sync_date = $row["value"];
        }
        return $last_sync_date;
    }
}

// Adds newly added revies to our DB, When this script runs
function scriptNewReview($link)
{
    // $last_sync_date = getLastReviewSyncTime($link);
    // $sql = "SELECT published_on, fk_user_id,order_id  FROM s_review WHERE (published_on) > '$last_sync_date'";
    $sql = "SELECT id,published_on, fk_user_id,order_id  FROM s_review WHERE (sync)=0";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Getting Review IDs Unsuccessfull";
    } else {
        $published_on = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $fk_user_id = $row["fk_user_id"];
            $order_id = $row["order_id"];
            $user_id = fk_id_to_user_id($link, $fk_user_id);
            newReviewAdded($link, $user_id, $order_id);
            $id = $row["id"];
            $newsql = "update s_review set sync = 1 where id = $id";
            mysqli_query($link, $newsql);
            $published_on = $row["published_on"];
        }
        if ($published_on) {
            // $last_review_id = date($published_on);
            // $sql = "UPDATE settings set value='$last_review_id' WHERE s_id=2";
            $date1 = new DateTime();
            $date1 = $date1->format('Y-m-d H:i:s');
            $sql = "UPDATE settings set value='$date1' WHERE s_id=2";
            mysqli_query($link, $sql);
        }
    }
}
function scriptNewOrder($link)
{
    // $last_sync_date = getLastOrderSyncTime($link);
    // $sql = "SELECT order_on, fk_user_id,amount FROM s_orders WHERE (order_on) > '$last_sync_date'";
    $sql = "SELECT order_on, fk_user_id,amount,id FROM s_orders WHERE (sync)=0";
    // echo $sql;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Getting Order IDs Unsuccessfull";
    } else {
        $published_on = null;
        while ($row = mysqli_fetch_assoc($result)) {
            $fk_user_id = $row["fk_user_id"];
            $user_id = fk_id_to_user_id($link, $fk_user_id);
            last3Order($link, $user_id);
            newOrderBefore7Days($link, $user_id);
            newOrderTookPlace($link, $user_id);
            subtractUserPoints($link, $user_id, usePoints($link, $user_id, $row["amount"]));
            $id = $row["id"];
            $newsql = "update s_orders set sync = 1 where id = $id";
            mysqli_query($link, $newsql);
            $published_on = $row["order_on"];
        }
        if ($published_on) {
            // $published_on = date($published_on);
            // $sql = "UPDATE settings set value='$published_on' WHERE s_id=6";
            $date1 = new DateTime();
            $date1 = $date1->format('Y-m-d H:i:s');
            $sql = "UPDATE settings set value='$date1' WHERE s_id=6";
            mysqli_query($link, $sql);
        }
    }
}
// scriptNewReview($link);
//Returns when was last time new review was added
function getLastReviewSyncTime($link)
{
    $sql = "select value from settings where s_id=2";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Getting Latest Review ID Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $last_sync_date = $row["value"];
        }
        return $last_sync_date;
    }
}
function getLastOrderSyncTime($link)
{
    $sql = "select value from settings where s_id=6";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Getting Latest Review ID Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $last_sync_date = $row["value"];
        }
        return $last_sync_date;
    }
}
//Takes foreign key ID as input and returns local user id
function fk_id_to_user_id($link, $fk_user_id)
{
    $sql = "select user_id from user_reward where fk_user_id = $fk_user_id";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Getting Latest FK UserID Unsuccessfull";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row["user_id"];
        }
        return $user_id;
    }
}
//Checks if last 3 order were returned or replaced
function last3OrderApplicable($link, $user_id)
{
    $sql = "select fk_user_id from user_reward where user_id = $user_id";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $fk_user_id = $row["fk_user_id"];
    }
    $sql = "SELECT not_returned FROM s_orders WHERE fk_user_id = $fk_user_id AND id NOT IN ( SELECT MAX(id) FROM s_orders WHERE fk_user_id = $fk_user_id );";
    // $sql = "select not_returned from s_orders where fk_user_id = $fk_user_id"; 
    // echo $sql;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Can't check for eligibility for 3 order scheme";
    } else {
        $not_returned = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($not_returned, $row["not_returned"]);
        }
        $counter = 0;
        $value_count = 0;
        $not_returned = array_reverse($not_returned);
        foreach ($not_returned as $value) {
            $counter += 1;
            $value_count += $value;
            if ($counter == 3) {
                break;
            }
        }
        echo "Value:", $value_count;
        if ($value_count == 3) {
            return true;
        } else {
            return false;
        }
    }
}
// echo last3OrderApplicable($link, 1);
//Check when was last order by this user took place
function lastOrder7Applicable($link, $user_id)
{
    $sql = "select fk_user_id from user_reward where user_id = $user_id";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $fk_user_id = $row["fk_user_id"];
    }
    $last_order = 1500;
    // $sql = "select order_on from s_orders where fk_user_id = $fk_user_id";
    $sql = "SELECT order_on FROM s_orders WHERE fk_user_id = $fk_user_id ORDER BY order_on DESC LIMIT 1 OFFSET 1";
    // echo $sql;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Can't check for eligibility for 3 order scheme";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $last_order = $row["order_on"];
            // echo $last_order;
        }
        if ($last_order != 1500) {
            $date1 = date_create($last_order);
            $date2 = date_create(date("Y-m-d"));
            $diff = date_diff($date1, $date2);
            $last_order = (int) $diff->format("%a");
            // echo $last_order;
            if ($last_order <= 7) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
}
function getSettingValue($link, $id)
{
    $sql = "select value from settings where s_id = $id";
    // echo $sql;
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $value = $row["value"];
        // echo $value;
    }
    return $value;
}
function ScriptRewardExpiry($link)
{
    $sql = "SELECT * FROM user_reward WHERE (last_point_used + INTERVAL (SELECT value FROM settings WHERE s_id=7) DAY) < CURDATE()";
    // echo $sql;
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {

        $user_id = $row["user_id"];
        $user_reward = $row['user_reward'];
        $date1 = (date("Y-m-d H:i:s"));
        $sql = "select user_id from user_reward where premium_exp>='$date1' and user_id = $user_id";
        $result_p = mysqli_query($link, $sql);
        $result_p = mysqli_fetch_array($result_p);
        if ($result_p) {
            $expire = getSettingValue($link, 11);
            $expire = ($user_reward * ($expire) / 100);
        } else {
            $expire = getSettingValue($link, 8);
            $expire = ($user_reward * ($expire) / 100);
        }
        $sql = "update user_reward set user_reward= user_reward-$expire where user_id = $user_id";
        mysqli_query($link, $sql);
        addRewardLog($link, $user_id, 9, $expire);
        $sql = "update user_reward set last_point_used = '$date1' where user_id=$user_id";
        mysqli_query($link, $sql);
    }
}
function nextSpin($link, $user_id)
{
    $sql = "select next_spin from user_reward where user_id = $user_id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    $date1 = new DateTime();
    $next_spin = new DateTime($row['next_spin']);
    $interval = $next_spin->diff($date1);
    $minutes = abs($interval->format('%r%a') * 24 * 60) + abs($interval->format('%h') * 60) + abs($interval->format('%i'));
    if ($interval->invert == 1) {
        return $minutes * -1;
    } else {
        return $minutes;
    }
}
// echo nextSpin($link, 1);
function activeSpins($link)
{
    $sql = "select id,value,name from spin where status=1";
    $result = mysqli_query($link, $sql);
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $item = array(
            "id" => (int) $row['id'],
            "label" => $row['name'] . ' ' . $row['value'],
            "value" => (int) $row['value']
        );
        $data[] = $item;
    }
    return json_encode($data);
}
// echo activeSpins($link);

function spinComplete($link, $user_id, $spin_id, $value)
{
    $date1 = (date("Y-m-d H:i:s"));
    $sql = "update user_reward set next_spin = date_add('$date1', INTERVAL (select value from settings where s_id=9) hour) where user_id = $user_id ";
    mysqli_query($link, $sql);
    switch ($spin_id) {
        case 1: {
                $sql = "update user_reward set user_reward = user_reward+$value where user_id = $user_id";
                mysqli_query($link, $sql);
                addRewardLog($link, $user_id, 8, $value);
                return "$value Points Rewarded to your account";
                // break;
            }
        case 2: {
                $sql = "UPDATE user_reward SET premium_exp = (IF(premium_exp < CURRENT_DATE(), DATE_ADD(CURRENT_DATE(), INTERVAL $value DAY), DATE_ADD(premium_exp, INTERVAL 30 DAY))) WHERE user_id = $user_id";
                mysqli_query($link, $sql);
                return "$value Premium Subscription Added";
                // break;
            }
        case 3: {
                $sql = "update user_reward set next_spin = '$date1' where user_id = $user_id ";
                mysqli_query($link, $sql);
                return "Spin Again";
                // break;
            }
        case 4: {
                $sql = "update user_reward set user_reward = user_reward+$value where user_id = $user_id";
                mysqli_query($link, $sql);
                addRewardLog($link, $user_id, 8, $value);
                return "$value Points Rewarded to your account";
                // break;
            }
        case 5: {
                $sql = "update user_reward set next_spin = date_add('$date1', INTERVAL ((select value from settings where s_id=9)+24) hour) where user_id = $user_id ";
                mysqli_query($link, $sql);
                return "No Spin For You Tomorrow";
                // break;
            }
        case 6: {
                return "Better Luck Next time";
            }
        default: {
                return "Default";
                // break;
            }
    }
}

function total_user($link)
{
    $sql = "SELECT count(user_reward) FROM user_reward";
    $result = mysqli_query($link, $sql);
    $total = 0;
    while ($row = mysqli_fetch_row($result)) {
        $total = $row[0];
        return $total;
    }
}

function total_reward_awarded($link)
{
    $sql = "SELECT sum(r_points) FROM reward_log where r_id != 7 and r_id != 9";
    $result = mysqli_query($link, $sql);
    $total = 0;
    if ($result) {

        while ($row = mysqli_fetch_row($result)) {
            $total = $row[0];
            return $total;
        }
    }
}

function total_reward_reedemed($link)
{
    $sql = "SELECT sum(r_points) FROM reward_log where r_id = 7 ";
    $result = mysqli_query($link, $sql);
    $total = 0;
    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            $total = $row[0];
            return $total;
        }
    }
    return $total;
}

function getTimeDifferenceString($specifiedDateTime)
{
    $currentDateTime = new DateTime();
    $specifiedDateTime = new DateTime($specifiedDateTime);
    $timeDifference = $currentDateTime->diff($specifiedDateTime);

    if ($timeDifference->days > 7) {
        return "More than a week ago";
    } elseif ($timeDifference->days > 0) {
        return "More than a day ago";
    } elseif ($timeDifference->h > 1) {
        return $timeDifference->h . " hours ago";
    } elseif ($timeDifference->h === 1) {
        return "1 hour ago";
    } elseif ($timeDifference->i > 0) {
        return "Less than an hour ago";
    } else {
        return "Just now";
    }
}

// echo lastOrder7Applicable($link, 53);

// //Main Functions
// echo newOrderTookPlace($link, 53); // PP
// echo last3Order($link, 53); // PP
// echo newReviewAdded($link, 53, 6); // PP
// echo userActivatesNewsLetter($link, 53); // PP
// echo newOrderBefore7Days($link, 53); // PP
// echo usePoints($link, 53, 1500); // PP
// echo scriptNewUsers($link); // PP
// echo scriptNewReview($link); // PP   
// echo scriptNewOrder($link); // PP
// ScriptRewardExpiry($link); // PP

// //Secondary Functions
// echo newAccountCreated($link, 8); // PP
// echo getStatus(7, $link); // PP
// echo getPoints(7, $link, 53); // PP
// echo getUserRewardPoints($link, 53); // PP
// echo addRewardLog($link, 53, 5, 120); // PP
// echo updateUserPoints($link, 27, 3); // PP
// echo subtractUserPoints($link, 53, 100); // PP
// echo percentage_number_reward($link); // PP
// echo getMinOrderValue($link); // PP
// echo getMaxReedemPoints($link); // PP
// echo getLastUserSyncTime($link); // PP
// echo getLastReviewSyncTime($link);// PP
// echo fk_id_to_user_id($link, 1); // PP
// echo last3OrderApplicable($link, 1); // PP
// echo lastOrder7Applicable($link, 1); // PP

// New Features
// 0 Reward Expiry 
// - 1 Only Give Review points to the product he have purchased, max reviews he can add to get points
// 2 Referral Points, If User Brings new user old user would get reward 
// *3 Buy Products from only reward points *It would be costly, *User need to save that much reward points, *points also gets expire
// 4 If THESE many reward points you have used, You will get THIS
// 5 Premium Customer
// *6 You can use reward points on any of the store we have Collaborated with.
// - 7 Lucky Spin Everyday to get exciting gift/ Reward points
// *8 Convert reward points to cash!!!

// 9 You have to pay * after ** discount

// Premium customer:
// 0 would get 1.25x more points then normal user
// 1 Expiry time would be more than normal user
// 2 More chance of getting better reward at daily spin

// Our Benefit:
// 0 Collab with games Platform as reward management system
// 1 For every THIS reward point user get, CLIENT need to pay us THIS MUCH
// 2 For every user gets added We'll Charge this much

// Goals
// Who will user our product: Our Platform will be used by any online/offline Platform who need to have reward management system.
// How will they Benefits: If they have Collaborated with us, user of that platform would get good benefits based on points & also can use points on any store, So the value of reward for user would be increased
// Our Platform would be a market place for all the store specifically for reward system
// Every User would have same Reward ID for all the online store we have Collaborated with. So points would be syncronized
// Even we can Collab with offline small retail store for rewards system
// RMS Could be collaborated with banks for reward points management for credit card, user will be HAPPILY using that bank CARD.

// How System will work:
// RMS = Our System
// P1 = Platform 1 Collaborated with us
// P2 = Platform 2 Collaborated with us
// U1 = User 1
// 1 Points = $1

// U1 purchased $100 thing from P1 and received 10 points from RMS & RMS will get $6.5 From P1 
// U1 can use points at any P.
// U1 Bought $100 thing from P2, U1 need to pay $90 + 10 Points at P2.
// P2 will get $4.5 as U1 used 10 Points from RMS

// U1 Benefit:
// Can use points at any store. 
// Getting point would be extra benefit to user as if U1 don't use RMS still he need to buy product at that price only
// U1 will even get extra reward from RMS

// P1 Benefit:
// User Bought item from P1 as P1 was providing points

// P1 Loss:
// 6.5% 

// P2 Benefits:
// User Had points so he purchased from that P2

// P2 Loss:
// 5.5%

// RMS Benefit:
// RMS got 1% commission in between transaction, RMS need to be maintained & RMS need to provide more valuable benefits to user from that  

?>