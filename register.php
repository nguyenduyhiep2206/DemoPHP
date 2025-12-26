<?php
session_start();
require_once 'functions.php';

$error = '';
$success = '';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: welcome.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($name)) {
        $error = "Name is required";
    } elseif (empty($email)) {
        $error = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif (empty($password)) {
        $error = "Password is required";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match";
    } else {
        // Register user
        $result = registerUser($name, $email, $password);

        if ($result['success']) {
            $success = "Registration successful! Please login.";
            // Clear form
            $name = $email = '';
        } else {
            $error = $result['error'];
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>

<body>

    <h2>Register</h2>

    <?php if (!empty($error)): ?>
        <p><strong>Error:</strong> <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p><strong>Success:</strong> <?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Name:</label><br>
            <input type="text" name="name" value="<?= $name ?>" required>
        </p>
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" value="<?= $email ?>" required>
        </p>
        <p>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </p>
        <p>
            <label>Confirm Password:</label><br>
            <input type="password" name="confirm_password" required>
        </p>
        <p>
            <button type="submit">Register</button>
        </p>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>

</body>

</html>