<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
$menu = "home";
include_once('header.php');
include_once('db.php');
include_once('script.php');
?>
<div class="head-title">
    <div class="left">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Last 30 Days Analytics</a>
            </li>
        </ul>
    </div>
</div>

<ul class="box-info">
    <li>
        <i class='bx bxs-group'></i>
        <span class="text">
            <h3>
                <?php echo total_user($link); ?>
            </h3>
            <p>Total Users</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-calendar-check'></i>
        <span class="text">
            <h3>
                <?php echo total_reward_awarded($link); ?>
            </h3>
            <p>Reward Received</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-dollar-circle'></i>
        <span class="text">
            <h3>
                <?php echo total_reward_reedemed($link); ?>
            </h3>
            <p>Reward Reedemed</p>
        </span>
    </li>
</ul>
<!-- partial -->
<ul class="box-info">
    <li>
        <canvas id="userChart"></canvas>
    </li>
    <li>
        <canvas id="receivedChart"></canvas>
    </li>
    <li>
        <canvas id="reedemChart"></canvas>
    </li>
</ul>
<ul class="box-info">
    <div class="table-data" style="overflow-x: scroll ;">
        <div class="order">
            <div class="head">
                <h3 style="color: #FFCE26;">Last Reward Received</h3>
                <!-- <i class='bx bx-search'></i>
            <i class='bx bx-filter'></i> -->
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Detail</th>
                        <th>Rewards</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT reward_list.r_name, reward_log.r_points, users.username, reward_log.date_added FROM reward_log, users, user_reward, reward_list where reward_log.r_id = reward_list.r_id and reward_log.user_id = user_reward.user_id and user_reward.fk_user_id = users.id and reward_log.r_id not in (7,9) and reward_log.r_points not in (0) order by reward_log.r_transaction_ID desc limit 5";
                    $result = mysqli_query($link, $sql);

                    // Loop through data and display in table
                    if ($result) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td> <h5>" . $row["username"] . "</h5>";
                            echo "<p>" . $row["r_name"] . "</p></td>";


                            echo "<td> <h5>" . $row["r_points"] . "</h5>";
                            echo "<p>" . getTimeDifferenceString($row["date_added"]) . "</p></td>";
                            echo "</tr>";
                        }
                        mysqli_free_result($result);
                    }

                    // Free result set and close database connection
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-data" style="overflow-x: scroll ;">
        <div class="order">
            <div class="head">
                <h3 style="color: #FD7238;">Last Reward Reedemed</h3>
                <!-- <i class='bx bx-search'></i>
            <i class='bx bx-filter'></i> -->
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Detail</th>
                        <th>Rewards</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT reward_list.r_name, reward_log.r_points, users.username, reward_log.date_added FROM reward_log, users, user_reward, reward_list where reward_log.r_id = reward_list.r_id and reward_log.user_id = user_reward.user_id and user_reward.fk_user_id = users.id and reward_log.r_id in (7,9) and reward_log.r_points not in (0) order by reward_log.r_transaction_ID desc limit 5";
                    $result = mysqli_query($link, $sql);

                    if ($result) {

                        // Loop through data and display in table
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td> <h5>" . $row["username"] . "</h5>";
                            echo "<p>" . $row["r_name"] . "</p></td>";

                            echo "<td> <h5>" . $row["r_points"] . "</h5>";
                            echo "<p>" . getTimeDifferenceString($row["date_added"]) . "</p></td>";
                            echo "</tr>";
                        }

                        // Free result set and close database connection
                        mysqli_free_result($result);
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</ul>
<?php
//Received
$query = "  SELECT
            d.date,
            COALESCE(SUM(t.r_points), 0) AS total_r_points
            FROM (
            SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS date
            FROM (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS a
            CROSS JOIN (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS b
            CROSS JOIN (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS c
            ) AS d
            LEFT JOIN reward_log AS t
            ON DATE(t.date_added) = d.date
            AND t.r_id NOT IN (7, 9)
            WHERE d.date >= CURDATE() - INTERVAL 29 DAY
            GROUP BY d.date ";

// Execute the query
$result = $link->query($query);

// Fetch the results and store in an array
$data = array();
if ($result) {

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
// Extract only the "total_r_points" values from $data array
$points = array_column($data, 'total_r_points');

// Convert string values to number datatype
$points = array_map('floatval', $points);

// Convert $points array to JSON
$data_received = json_encode($points);
?>

<?php
//Reedemed
$query = "  SELECT
            d.date,
            COALESCE(SUM(t.r_points), 0) AS total_r_points
            FROM (
            SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS date
            FROM (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS a
            CROSS JOIN (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS b
            CROSS JOIN (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS c
            ) AS d
            LEFT JOIN reward_log AS t
            ON DATE(t.date_added) = d.date
            AND t.r_id IN (7)
            WHERE d.date >= CURDATE() - INTERVAL 29 DAY
            GROUP BY d.date ";

// Execute the query
$result = $link->query($query);

// Fetch the results and store in an array
$data = array();
if ($result) {

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
// Extract only the "total_r_points" values from $data array
$points = array_column($data, 'total_r_points');

// Convert string values to number datatype
$points = array_map('floatval', $points);

// Convert $points array to JSON
$data_redeem = json_encode($points);
?>

<?php
//Reedemed
$query = "  SELECT
            d.date,
            COALESCE(COUNT(t.user_id), 0) AS total_user
            FROM (
            SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS date
            FROM (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS a
            CROSS JOIN (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS b
            CROSS JOIN (
                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
                SELECT 8 UNION ALL SELECT 9
            ) AS c
            ) AS d
            LEFT JOIN user_reward AS t
            ON DATE(t.date_added) = d.date
            WHERE d.date >= curdate() - INTERVAL 29 DAY
            GROUP BY d.date ";

// Execute the query
$result = $link->query($query);

// Fetch the results and store in an array
$data = array();
if($result){
                        
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
// Extract only the "total_user" values from $data array
$points = array_column($data, 'total_user');

// Convert string values to number datatype
$points = array_map('floatval', $points);

// Convert $points array to JSON
$data_user = json_encode($points);
?>

<script>
    var data_received = <?php echo $data_received; ?>;
    // Sample data
    const data = {
        labels: data_received,
        datasets: [{
            label: "Reward Received",
            data: data_received,
            fill: false,
            borderColor: "#FFCE26",
            pointRadius: 0 // Remove the dots from the line
        }]
    };

    // Chart configuration
    const configReceived = {
        type: "line",
        data: data,
        options: {
            scales: {
                x: {
                    display: false, // Hide x-axis grid ticks and labels
                },
                y: {
                    display: false, // Hide y-axis grid ticks and labels
                }
            }
        }
    };
    const ctReceived = document.getElementById("receivedChart").getContext("2d");
    new Chart(ctReceived, configReceived);

    var data_redeem = <?php echo $data_redeem; ?>;

    const rData = {
        labels: data_redeem,
        datasets: [
            {
                label: "Reward Reedemed",
                data: data_redeem,
                fill: false,
                borderColor: "#FD7238",
                // borderWidth: 0.7,
                pointRadius: 0 // Remove the dots from the line
            }
        ]
    };

    const configReedem = {
        type: "line",
        data: rData,
        options: {
            scales: {
                x: {
                    display: false, // Hide x-axis grid ticks and labels
                },
                y: {
                    display: false, // Hide y-axis grid ticks and labels
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    // display: true,
                    // text: 'Last 30 Days Analytics'
                }
            }
        }
    };

    // Create the chart
    const ctRedeemed = document.getElementById("reedemChart").getContext("2d");
    new Chart(ctRedeemed, configReedem);


    //User Chart
    var data_user = <?php echo $data_user; ?>;

    const udata = {
        labels: data_user,
        datasets: [
            {
                label: "New Users",
                data: data_user,
                fill: false,
                borderColor: "#265b91",
                // borderWidth: 0.7,
                pointRadius: 0 // Remove the dots from the line
            }
        ]
    };

    const configUser = {
        type: "line",
        data: udata,
        options: {
            scales: {
                x: {
                    display: false, // Hide x-axis grid ticks and labels
                },
                y: {
                    display: false, // Hide y-axis grid ticks and labels
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    // display: true,
                    // text: 'Last 30 Days Analytics'
                }
            }
        }
    };

    // Create the chart
    const ctUser = document.getElementById("userChart").getContext("2d");
    new Chart(ctUser, configUser);
</script>

<?php include_once('footer.php') ?>