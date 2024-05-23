<?php
$menu = "NewReward";
include_once('header.php');
include_once('db.php');
?>
<div class="head-title">
    <div class="left">
        <h1>Add New Reward</h1>
    </div>
    <div class="right">
    <button type="button" onclick="window.history.back()" class="zform-group-b">Back</button>
    </div>
</div>
<div class="table-data">
    <div class="order">
        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Retrieve data from form
            $r_name = $_POST["r_name"];
            $r_points = $_POST["r_points"];
            $r_status = $_POST["r_status"];

            // Update data in database
            $sql = "insert into reward_list(r_name, r_points, r_status) values('$r_name','$r_points','$r_status')";
            $result = mysqli_query($link, $sql);

            // Check if update succeeded
            if ($result) {
                echo "New Scheme Created successfully! </br>";
            } else {
                echo "Error updating data: " . mysqli_error($link);
            }

            // Close database connection
            mysqli_close($link);

        } ?>
        <!-- <p class="card-description"> Horizontal form layout </p> -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class='forms-sample'>
            <div class="zform-group">
                <label for="exampleInputUsername2">Reward Name:</label>
                <input type="text" name="r_name" class="zform-control" id="exampleInputUsername2"
                    placeholder="Reward Name" required>
            </div>
            <div class="zform-group">
                <label for="exampleInputEmail2">Reward Points:</label>
                <input type="number" name="r_points" class="form-control" id="exampleInputEmail2"
                    placeholder="Reward Points">
            </div>
            <div class="zform-group">
                <label for="exampleInputMobile">Reward Status:</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="r_status" id="optionsRadios2" value="1"
                            checked> Activate </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="r_status" id="optionsRadios3" value="0">
                        Deactivate </label>
                </div>
            </div>
            <button type="submit" class="zform-group-b">Submit</button>
            <!-- <button class="zform-group-b">Cancel</button>    -->
        </form>
    </div>
</div>
<?php include_once('footer.php') ?>