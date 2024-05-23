<?php
// Initialize the session
// session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
// if(isset($_SESSION["s_loggedin"]) && $_SESSION["s_loggedin"] === true){
//     header("location: index.php");
//     exit;
// }
 
// Include config file
require_once "db.php";
 
// Define variables and initialize with empty valuesa
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ?";
        
		if($stmt = mysqli_prepare($link, $sql)){
			    // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // $username_err = "This username is already taken.";
					// if($param_username)
					$sql = "SELECT username, password, id  FROM users WHERE username = '$username'";
					$result = $link->query($sql);
					$data = $result->fetch_assoc();
					$pass = $data['password'];
					$id = $data['id'];
                    
					if($pass == $password){
							// Password is correct, so start a new session
							session_start();
							// Store data in session variables
							$_SESSION["s_loggedin"] = true; 
							$_SESSION["s_id"] = $id;
							$_SESSION["s_username"] = $username;                            
							
							// Redirect user to welcome page
							header("location: index.php");
						} else{
							// Password is not valid, display a generic error message
							$login_err = "Invalid username or password.";
						}
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<?php //include_once('header.php') ?>
<div class="lcontainer">
	<div class="login-box">
		<h1>Login</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="textbox">
			<input placeholder="Username" type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
			</div>

			<div class="textbox">
			<input placeholder="Password" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
			</div>

			<input type="submit" class="btn" value="Log in">
		</form>
		<a href="signup.php"><p>New User?</p></a>
	</div>
</div>
<?php //include_once('footer.php') ?>
