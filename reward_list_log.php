<?php 
$menu = "NewRewardLog";
include_once('header.php'); 
include_once('db.php');
?>
<div class="head-title">
				<div class="left">
					<h1>Reward Update Logs</h1>
					<ul class="breadcrumb"> 
						<li>
							<a href="#">When & What Admin have update in Reward Schemes</a>
						</li>
					</ul>
				</div>
			</div>

<div class="table-data" style="overflow-x: scroll ;">
    <div class="order">
      <table >
        <thead>
          <tr>
            <!-- <th>Log ID</th> -->
            <th>Reward ID</th>
            <th>Reward Name</th>
            <th>Point Before</th>
            <th>Point Now</th>
            <th>Status Before</th>
            <th>Status Now</th>
            <th>Date Modified</th>
          </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT *  FROM reward_list_log order by log_id desc";
            $result = mysqli_query($link, $sql);

            // Loop through data and display in table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                // echo "<td>" . $row["log_id"] . "</td>";
                echo "<td>" . $row["r_id"] . "</td>";
                echo "<td>" . $row["r_name"] . "</td>";
                echo "<td>" . $row["r_points_before"] . "</td>";
                echo "<td>" . $row["r_points_now"] . "</td>";
                echo "<td>" . $row["r_status_before"] . "</td>";
                echo "<td>" . $row["r_status_now"] . "</td>";
                echo "<td>" . $row["r_date_changed"] . "</td>";
                echo "</tr>";
            }

            // Free result set and close database connection
            mysqli_free_result($result);
            
            ?>                          
        </tbody>
      </table>
    </div>
  </div>
</div>

       
<?php include_once('footer.php')?>