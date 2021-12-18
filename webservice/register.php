<?php
// Include config file
require_once "koneksi.php";
 
// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
 
        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
 
            // Set parameters
            $param_email = trim($_POST["email"]);
 
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
 
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
 
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
 
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
 
    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
 
        // Prepare an insert statement
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
 
        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
 
            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
 
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($con);
}
?>
 
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
 
<body>
    <div class="wrapper">
        <h2>Register</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="box-login <?php echo (!empty($email_err)) ? 'has - error' : ""; ?>">
                    <i class="fas fa-envelope-open-text"></i>
                    <input type="text" placeholder="E-mail" name="email" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="box-login <?php echo (!empty($password_err)) ? 'has - error' : ""; ?>">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="box-login <?php echo (!empty($confirm_password_err)) ? 'has - error' : ""; ?>">
                    <i class="fas fa-lock"></i>    
                    <input type="password" placeholder="Confirm Password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn-primary" value="Register">
                <div class="bottom"
                    <center><p>Back to <a href="login.php">Login</a></p>
                </div>
            </form>
    </div>
</body>

</html>