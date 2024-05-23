<?php
include_once('header.php');
include_once('db.php')
	?>
<div class="table-data">
	<div class="order">
		<h2 class="card-title">Update Spin </h2>
		<?php

		// Check if form is submitted
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			//FOR LOG
			$s_id = $_POST["s_id"];
			$sql = "SELECT *  FROM settings WHERE s_id='$s_id'";
			$result = mysqli_query($link, $sql);

			// Display form with current data
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$name = $row["name"];
				$value = $row["value"];
			}

			// Retrieve data from form
			$name = $_POST["name"];
			$value = $_POST["value"];

			// Update data in database
			$sql = "UPDATE settings SET name='$name', value='$value' WHERE s_id='$s_id'";
			$result = mysqli_query($link, $sql);

			$result = mysqli_query($link, $sql);
			// Check if update succeeded
			if ($result) {
				echo "Data updated successfully! </br>";
				echo "<a href='settings.php'>Back to settings page</a>";
			} else {
				echo "Error updating data: " . mysqli_error($link);
			}

			// Close database connection
			mysqli_close($link);

		} else {

			// Retrieve id from URL parameter
			$s_id = $_GET["s_id"];

			// Retrieve data from database
			$sql = "SELECT name,value  FROM settings WHERE s_id='$s_id'";
			$result = mysqli_query($link, $sql);

			// Display form with current data
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$name = $row["name"];
				$value = $row["value"];
				?>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<input type="hidden" name="s_id" value="<?php echo $s_id; ?>">
					<div class="zform-group">
						<label for="exampleInputUsername2">Name</label>
						<input type="text" name="name" class="zform-control" id="exampleInputUsername2" placeholder="Name"
							value="<?php echo $name; ?>">
					</div>
					<div class="zform-group">
						<label for="exampleInputMobile">Value</label>
						<input type="text" name="value" class="zform-control" id="exampleInputUsername2" placeholder="Value"
							value="<?php echo $value; ?>">
					</div>
					<button type="submit" class="zform-group-b" value="update">Submit</button>
					<!-- <button class="zform-group-b" >Cancel</button> -->
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

<!-- CREATE TRIGGER `change_log` AFTER UPDATE ON `settings` -->
<!-- FOR EACH ROW insert into settings_log (s_id, r_points_before, r_points_now, value_before, value_now) VALUES(new.s_id, old.r_points, new.r_points, old.value, new.value) -->