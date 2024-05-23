<?php
include_once('header.php');
include_once('db.php')
	?>
<div class="head-title">
	<div class="left">
		<h1>Update Reward</h1>
	</div>
</div>
<div class="table-data">
	<div class="order">
		<?php
		// Check if form is submitted
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			//FOR LOG
			$r_id = $_POST["r_id"];
			$sql = "SELECT r_points,r_status  FROM reward_list WHERE r_id='$r_id'";
			$result = mysqli_query($link, $sql);

			// Display form with current data
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$r_points_b = $row["r_points"];
				$r_status_b = $row["r_status"];
			}

			// Retrieve data from form
			$r_name = $_POST["r_name"];
			$r_points = $_POST["r_points"];
			$r_status = $_POST["r_status"];

			// Update data in database
			$sql = "UPDATE reward_list SET r_name='$r_name', r_points='$r_points', r_status='$r_status' WHERE r_id='$r_id'";
			$result = mysqli_query($link, $sql);

			$sql = "INSERT INTO reward_list_log (r_id, r_name, r_points_before, r_points_now, r_status_before, r_status_now)
        VALUES ($r_id, '$r_name', $r_points_b, $r_points, $r_status_b, $r_status)";

			$result = mysqli_query($link, $sql);
			// Check if update succeeded
			if ($result) {
				echo "Data updated successfully! </br>";
				echo "<a href='index.php'>Back to index page</a>";
				// header("Location: index.php");
			} else {
				echo "Error updating data: " . mysqli_error($link);
			}

			// Close database connection
			mysqli_close($link);

		} else {

			// Retrieve id from URL parameter
			$r_id = $_GET["r_id"];

			// Retrieve data from database
			$sql = "SELECT r_name,r_points,r_status  FROM reward_list WHERE r_id='$r_id'";
			$result = mysqli_query($link, $sql);

			// Display form with current data
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$r_name = $row["r_name"];
				$r_points = $row["r_points"];
				$r_status = $row["r_status"];
				?>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<input type="hidden" name="r_id" value="<?php echo $r_id; ?>">

					<div class="zform-group">
						<label for="exampleInputUsername2" class="col-sm-3 col-form-label">Reward Name:</label>
						<input type="text" name="r_name" class="zform-control" id="exampleInputUsername2"
							placeholder="Reward Name" value="<?php echo $r_name; ?>">
					</div>
					<div class="zform-group">
						<label for="exampleInputEmail2" class="col-sm-3 col-form-label">Reward Points</label>
						<input type="number" name="r_points" class="zform-control" id="exampleInputEmail2"
							placeholder="Reward Points" value="<?php echo $r_points; ?>">
					</div>
					<div class="zform-group">
						<label for="exampleInputMobile" class="col-sm-3 col-form-label">Reward Status</label>
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" name="r_status" id="optionsRadios2" value="1" <?php if ($r_status > 0) {
									echo "checked";
								} ?>> Activate </label>
						</div>
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" name="r_status" id="optionsRadios3" value="0" <?php if ($r_status <= 0) {
									echo "checked";
								} ?>> Deactivate </label>
						</div>
					</div>
					<button type="submit" class="zform-group-b" value="update">Submit</button>
					<!-- <button class="zform-group-b">Cancel</button> -->
				</form>

				<?php
			} else {
				echo "No data found!";
			}
			mysqli_free_result($result);
			mysqli_close($link);
		}
		?>

	</div>
</div>
<?php
include_once('footer.php'); ?>

<!-- CREATE TRIGGER `change_log` AFTER UPDATE ON `reward_list` -->
<!-- FOR EACH ROW insert into reward_list_log (r_id, r_points_before, r_points_now, r_status_before, r_status_now) VALUES(new.r_id, old.r_points, new.r_points, old.r_status, new.r_status) -->