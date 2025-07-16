<?php
session_start();
include '../config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if (empty($email) || empty($password)) {
    $error = "All fields are required.";
  } else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();
      if (password_verify($password, $user['password'])) {
        if ($user['is_admin']) {
          $_SESSION['admin'] = $user['username'];
          header("Location: ../admin/dashboard.php");
          exit();
        } else {
          $_SESSION['user'] = $user['username'];
          header("Location: ../index.php");
          exit();
        }
      } else {
        $error = "Invalid password.";
      }
    } else {
      $error = "No account found with that email.";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - My Bookstore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5" style="max-width:400px;">
  <h3 class="mb-3">Login</h3>
  <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
  <form method="POST">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100" type="submit">Login</button>
    <p class="mt-3">Don't have an account? <a href="register.php">Register</a></p>
  </form>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
