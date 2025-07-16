<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../user/login.php");
  exit();
}
include '../config/db.php';

$result = mysqli_query($conn, "SELECT books.*, categories.name as category_name FROM books LEFT JOIN categories ON books.category_id = categories.id");
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Books</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
  <h3 class="mb-3">Books List</h3>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($book = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo htmlspecialchars($book['title']); ?></td>
        <td><?php echo htmlspecialchars($book['author']); ?></td>
        <td>₹<?php echo number_format($book['price'], 2); ?></td>
        <td><?php echo htmlspecialchars($book['category_name']); ?></td>
        <td>
          <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?');">Delete</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
