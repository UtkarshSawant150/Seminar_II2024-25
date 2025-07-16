<?php
session_start();
include '../config/db.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if (empty($username) || empty($email) || empty($password)) {
    $error = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
  } elseif (strlen($password) < 6) {
    $error = "Password must be at least 6 characters.";
  } else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $error = "Email already registered.";
    } else {
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
      $insert->bind_param("sss", $username, $email, $hashed);
      $insert->execute();
      $success = "Account created successfully. You can now login.";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register - My Bookstore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5" style="max-width:400px;">
  <h3 class="mb-3">Register</h3>
  <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
  <?php if ($success) { echo "<div class='alert alert-success'>$success</div>"; } ?>
  <form method="POST">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100" type="submit">Register</button>
    <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
  </form>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
