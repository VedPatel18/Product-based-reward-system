<?php include_once('db.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Login</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <!-- <div class="card-header">Login</div> -->
          <h5 class="card-header">Login</h5>
          <div class="card-body">
            <?php
            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

              // Retrieve data from form
              $username = $_POST["username"];
              $password = $_POST["password"];

              // Check if connection succeeded
              if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
              }

              // Retrieve data from database
              $sql = "SELECT username, password FROM admin WHERE username='$username' AND password='$password'";
              $result = mysqli_query($link, $sql);

              // Check if data matches
              if (mysqli_num_rows($result) > 0) {
                // Password is correct, so start a new session
                session_start();

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;

                // Redirect user to welcome page
                header("location: index.php");
              } else {
                echo "Username or Password is incorrect";
              }

              // Free result set and close database connection
              mysqli_free_result($result);
              mysqli_close($link);
            }
            ?>
            <!-- <h3 class="card-title text-left mb-3">Login</h3> -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input name="username" type="text" class="form-control ">
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
              <p class="sign-up">Don't have an Account?<a href="signup.php"> Sign Up</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>