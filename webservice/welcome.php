<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
 
<body><center>
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to our site.</h1>
    <p><a href="logout.php" class="btn-primary">Log Out of Your Account</a></p>
</body>
 
</html>