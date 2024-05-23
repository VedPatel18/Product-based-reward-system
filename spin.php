<?php 
include_once('db.php');
$menu = "Spins";
include_once('header.php'); 
?>
<div class="head-title">
				<div class="left">
					<h1>Spins</h1>
					<ul class="breadcrumb"> 
						<li>
							<a href="#">View & Modify Spins</a>
						</li>
					</ul>
				</div>
			</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <!-- <i class='bx bx-search'></i>
            <i class='bx bx-filter'></i> -->
        </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Spin ID</th>
            <th>Spin Name</th>
            <th>Spin Point</th>
            <th>Spin Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT *  FROM spin";
            $result = mysqli_query($link, $sql);

            // Loop through data and display in table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["value"] . "</td>";
                if ($row["status"] >= 1){
                    echo "<td>" ."<label class='status completed'>Actived</label>". "</td>";
                }else{
                    echo "<td>" ."<label class='status pending'>Deactivated</label>". "</td>";
                }
                echo "<td><a href='spin_update.php?id=" . $row["id"] . "'>Update</a></td>";
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