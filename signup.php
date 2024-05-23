<?php include_once('db.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Signup</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <!-- <div class="card-header">Login</div> -->
          <h5 class="card-header">Sign up</h5>
          <div class="card-body">
            <?php
                            // Check if form is submitted
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                // Retrieve data from form
                                $username = $_POST["username"];
                                $password= $_POST["password"];


                                // Check if connection succeeded
                                if (!$link) {
                                    die("Connection failed: " . mysqli_connect_error());
                                }

                                // Insert data into database
                                $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";
                                if (mysqli_query($link, $sql)) {
                                    echo "New Admin Account Created";
                                } else {
                                    echo "Can't Create account, Try changing username";
                                }
                                
                                // Close database connection
                                mysqli_close($link);
                            }
                        ?>
                
                    
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name = "username" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                  </div>                  
                  <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Sign up</button>
                  </div>
                  <p class="sign-up">Already have an Account?<a href="login.php"> Login Up</a></p>
                </form>
              </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>
