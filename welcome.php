<?php
session_start();
require_once 'functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user = getCurrentUser();

// Handle logout
if (isset($_GET['logout'])) {
    logoutUser();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>

<h2>Welcome!</h2>

<p>Hello, <strong><?= htmlspecialchars($user['name']) ?></strong>!</p>

<h3>Your Information:</h3>
<table border="1">
    <tr>
        <td><strong>ID:</strong></td>
        <td><?= htmlspecialchars($user['id']) ?></td>
    </tr>
    <tr>
        <td><strong>Name:</strong></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
    </tr>
    <tr>
        <td><strong>Email:</strong></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
    </tr>
    <tr>
        <td><strong>Created At:</strong></td>
        <td><?= htmlspecialchars($user['created_at']) ?></td>
    </tr>
</table>

<p>
    <a href="?logout=1">Logout</a>
</p>

</body>
</html>

