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
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  // Validation
  if (empty($email)) {
    $error = "Email is required";
  } elseif (empty($password)) {
    $error = "Password is required";
  } else {
    $result = loginUser($email, $password);

    if ($result['success']) {
      $_SESSION['user'] = $result['user'];
      header("Location: welcome.php");
      exit;
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
  <title>Login</title>
</head>

<body>

  <h2>Login</h2>

  <?php if (!empty($error)): ?>
    <p><strong>Error:</strong> <?= $error ?></p>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <p><strong>Success:</strong> <?= $success?></p>
  <?php endif; ?>

  <form method="POST">
    <p>
      <label>Email:</label><br>
      <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required autofocus>
    </p>

    <p>
      <label>Password:</label><br>
      <input type="password" name="password" required>
    </p>

    <p>
      <button type="submit">Login</button>
    </p>
  </form>

  <p>Don't have an account? <a href="register.php">Register here</a></p>

</body>

</html>