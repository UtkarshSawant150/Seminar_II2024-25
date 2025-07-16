<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../user/login.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
  <h3 class="mb-4">Admin Dashboard</h3>
  <div class="list-group">
    <a href="add_book.php" class="list-group-item">Add Book</a>
    <a href="view_books.php" class="list-group-item">View / Edit / Delete Books</a>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
