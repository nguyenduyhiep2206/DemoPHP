<?php
session_start();
require_once 'functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: welcome.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Demo PHP</title>
</head>
<body>

<h1>PHP Login/Register System</h1>

<p>Welcome! Please choose an option:</p>

<p>
    <a href="login.php">Login</a> | <a href="register.php">Register</a>
</p>

</body>
</html>
