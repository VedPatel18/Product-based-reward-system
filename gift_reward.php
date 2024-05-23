<?php
$menu = "GiftReward";
include_once('header.php');
include_once('db.php')
	?>
<div class="head-title">
	<div class="left">
		<h1>Gift Points</h1>
		<ul class="breadcrumb">
			<li>
				<a href="#">
					<?php
					$url = $_SERVER['REQUEST_URI'];
					if (strpos($url, "user_reward") !== false) {
						echo "Points in user account: ". $_GET["user_reward"];
					}
					?>
				</a>
			</li>
		</ul>
		<div class="right">
		</div>
		<button type="button" onclick="window.location.href='users.php'" class="zform-group-b">Back</button>
	</div>
</div>

<div class="table-data">
	<div class="order">
		<?php
		// Check if form is submitted
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			//FOR LOG
			$username = $_POST["username"];
			$r_points = $_POST["r_points"];

			// Update data in database
			$sql = "update user_reward join users on user_reward.fk_user_id = users.id set user_reward=user_reward + $r_points where username = '$username'";
			$result = mysqli_query($link, $sql);


			// Check if update succeeded
			if ($result) {
				$sql = "INSERT INTO reward_log (user_id, r_id, r_points) SELECT user_reward.user_id, , $r_points FROM user_reward JOIN users ON user_reward.fk_user_id = users.id WHERE users.username = '$username'";
				$result = mysqli_query($link, $sql);
				echo "Data updated successfully! </br>";
				// echo "<a href='gift_reward.php'>Back to Gift page</a>";
				// header("Location: index.php");
			} else {
				echo "Error updating data: " . mysqli_error($link);
			}
			// Close database connection
			mysqli_close($link);

		} else {
			$username = $_GET["username"];
			?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<div class="zform-group">
					<label for="exampleInputUsername2">Enter Username</label>
					<input type="text" name="username" class="zform-control" id="exampleInputUsername2"
						placeholder="Username" value="<?php echo $username ?>">
				</div>
				<div class="zform-group">
					<label for="exampleInputEmail2">Add Reward Amount</label>
					<input type="number" name="r_points" class="zform-control" id="exampleInputEmail2"
						placeholder="Reward Points">
				</div>
				<button type="submit" class="zform-group-b" value="update">Submit</button>
				<!-- <button class="zform-group-b">Cancel</button> -->
			</form>
			<?php
		}
		?>

	</div>
</div>
<?php
include_once('footer.php'); ?>

<!-- CREATE TRIGGER `change_log` AFTER UPDATE ON `reward_list` -->
<!-- FOR EACH ROW insert into reward_list_log (r_id, r_points_before, r_points_now, r_status_before, r_status_now) VALUES(new.r_id, old.r_points, new.r_points, old.r_status, new.r_status) -->