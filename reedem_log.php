<?php 
$menu = "ReedemLog";
include_once('header.php'); 
include_once('db.php');
?>
<div class="head-title">
				<div class="left">
					<h1>Reedem Logs</h1>
					<ul class="breadcrumb"> 
						<li>
							<a href="#">When, What, Which Reward User Redeemed </a>
						</li>
					</ul>
				</div>
			</div>

<div class="table-data">
    <div class="order">
      <table >
        <thead>
          <tr>
            <th>Username</th>
            <!-- <th>User ID</th> -->
            <th>Reward</th>
            <th>Reward Point</th>
            <th>Date</th>
          </tr>
        </thead>  
        <tbody>
            <?php 
            $sql = "SELECT reward_log.*, users.username, reward_list.r_name
            FROM reward_log
            JOIN user_reward ON reward_log.user_id = user_reward.user_id
            JOIN users ON user_reward.fk_user_id = users.id
            JOIN reward_list ON reward_log.r_id = reward_list.r_id where reward_log.r_id in (7,9)
            ORDER BY reward_log.r_transaction_ID DESC            
            ";
            $result = mysqli_query($link, $sql);
            if($result){
                        
              // Loop through data and display in table
              while ($row = mysqli_fetch_assoc($result)) {
                // if ($r_id== 7 || $r_id==9){
                  echo "<tr>";
                echo "<td>" . $row["username"] . "</td>";
                // echo "<td>" . $row["user_id"] . "</td>";
                $r_id = $row["r_id"];
                $r_name = $row["r_name"];
                echo "<td>" . $r_name . "</td>";
                $r_points = $row["r_points"];
                    echo "<td>" ."<label class='status pending'>$r_points</label>". "</td>";
                // } 
                echo "<td>" . $row["date_added"] . "</td>";
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
</div>

       
<?php include_once('footer.php')?>