<?php
include_once('db.php');
$menu = "RewardSchemes";
include_once('header.php');
include_once('script.php');
?>

<div class="head-title">
    <div class="left">
        <h1>Reward Schemes</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">View & Modify Schemes</a>
            </li>
        </ul>
    </div>
    <div class="right">
    <button type="button" onclick="window.location.href='new_reward.php'" class="zform-group-b">Add New Reward</button>
       
    </div>
</div>

<div class="table-data">
    <div class="order">
        <table>
            <thead>
                <tr>
                    <th>Reward ID</th>
                    <th>Reward Name</th>
                    <th>Reward Point</th>
                    <th>Reward Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT r_id, r_name, r_points,r_status  FROM reward_list";
                $result = mysqli_query($link, $sql);

                // Loop through data and display in table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["r_id"] . "</td>";
                    echo "<td>" . $row["r_name"] . "</td>";
                    echo "<td>" . $row["r_points"] . "</td>";
                    if ($row["r_status"] >= 1) {
                        echo "<td>" . "<label class='status completed'>Actived</label>" . "</td>";
                    } else {
                        echo "<td>" . "<label class='status pending'>Deactivated</label>" . "</td>";
                    }
                    echo "<td><a href='update.php?r_id=" . $row["r_id"] . "'>Update</a></td>";
                    echo "</tr>";
                }

                // Free result set and close database connection
                mysqli_free_result($result);

                ?>
            </tbody>
        </table>
    </div>


    <?php include_once('footer.php') ?>