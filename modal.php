<?php include_once('db.php');
$name = $_GET["name"];
if ($name == 1) {
    $sql = "SELECT r_id, r_name, r_points,r_status  FROM reward_list where r_id not in (7,8,9,10,11)";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["r_status"] >= 1) {
            $return_arr[] = array(
                "name" => $row["r_name"],
                "points" => $row["r_points"]
            );
        }
    }
    echo json_encode($return_arr);
    mysqli_free_result($result);
} elseif ($name == 2) {
    $output = [];
    $sql = "SELECT r_points  FROM reward_list where r_id=7";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $val = $row['r_points'];
    }

    $sql = "SELECT value,s_id  FROM settings where s_id in (1,3,4)";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // $rows = array_merge($row,$rows);
        // json_encode($rows);
        $count = 0;
        foreach ($rows as $row) {
            $rId = $row['s_id'];
            $rPoints = $row['value'];
            if ($rId == 1 && $rPoints == 1) {
                $a = "By redeeming points, you can avail yourself of " . $val . "% of the order value";
                $output[] = $a;
            } elseif ($rId == 1 && $rPoints == 0) {
                $a = "You can reedem " . $val . " Points per order";
                $output[] = $a;
            }
            if ($rId == 3) {
                $a = "Minimum Order Value Must be: " . $rPoints . " ";
                $output[] = $a;
            }
            if ($rId == 4) {
                $a = "Max point you can reedem per order is: " . $rPoints . " ";
                $output[] = $a;
            }
        }
        echo json_encode($output);
    }

} elseif ($name == 3) {
    $output = [];
    $sql = "SELECT r_points  FROM reward_list where r_id in (10,11)";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $row = mysqli_fetch_all($result);
        // $val = $row['r_points'];
    }
    echo json_encode($row);
}
elseif ($name == 4) {
    $output = [];
    $sql = "SELECT value  FROM settings where s_id in (7,8,10,11)";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $row = mysqli_fetch_all($result);
        // $val = $row['r_points'];
    }
    echo json_encode($row);
}
?>