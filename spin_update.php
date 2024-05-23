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
	$id = $_POST["id"];
	$sql = "SELECT value,status  FROM spin WHERE id='$id'";
	$result = mysqli_query($link, $sql);

	// Display form with current data
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$value_b = $row["value"];
		$status_b = $row["status"];
	}
	

	// Retrieve data from form
	$name = $_POST["name"];
	$value = $_POST["value"];
	$status = $_POST["status"];

	// Update data in database
	$sql = "UPDATE spin SET name='$name',value='$value', status='$status' WHERE id='$id'";
	$result = mysqli_query($link, $sql);

	// $sql = "INSERT INTO spin_log (id, name, value_before, value_now, status_before, status_now)
    //     VALUES ($id, '$name', $value_b, $value, $status_b, $status)";
	
	$result = mysqli_query($link, $sql);
	// Check if update succeeded
	if ($result) {
		echo "Data updated successfully! </br>";
		echo "<a href='spin.php'>Back to spin page</a>";
		// header("Location: index.php");
	} else {
		echo "Error updating data: " . mysqli_error($link);
	}

	// Close database connection
	mysqli_close($link);

} else {

	// Retrieve id from URL parameter
	$id = $_GET["id"];

	// Retrieve data from database
	$sql = "SELECT name,value,status  FROM spin WHERE id='$id'";
	$result = mysqli_query($link, $sql);

	// Display form with current data
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$name = $row["name"];
		$value = $row["value"];
		$status = $row["status"];
		?>
		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
			<input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="zform-group ">
                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Reward Name:</label>
                    <input type="text" name="name" class="form-control" id="exampleInputUsername2"
                        placeholder="Reward Name" value="<?php echo $name; ?>">
            </div>
            <div class="zform-group ">
                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Reward Points</label>
                    <input type="number" name="value" class="form-control" id="exampleInputEmail2"
                        placeholder="Reward Points" value="<?php echo $value; ?>">
            </div>
            <div class="zform-group ">
                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Reward Status</label>
						<div class="form-check">
						<label class="form-check-label">
							<input type="radio" class="form-check-input" name="status" id="optionsRadios2"
							value="1" <?php if($status>0){ echo "checked"; }?>> Activate </label>
						</div>
						<div class="form-check">
						<label class="form-check-label">
							<input type="radio" class="form-check-input" name="status" id="optionsRadios3"
							value="0" <?php if($status<=0){ echo "checked"; }?> > Deactivate </label>
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

<!-- CREATE TRIGGER `change_log` AFTER UPDATE ON `spin` -->
 <!-- FOR EACH ROW insert into spin_log (id, value_before, value_now, status_before, status_now) VALUES(new.id, old.value, new.value, old.status, new.status) -->
