<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../user/login.php");
  exit();
}
include '../config/db.php';

$error = "";
$success = "";

// Get categories
$categories = mysqli_query($conn, "SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $author = trim($_POST['author']);
  $price = trim($_POST['price']);
  $image = trim($_POST['image']);
  $category = intval($_POST['category']);

  if (empty($title) || empty($price) || empty($category)) {
    $error = "Title, Price, and Category are required.";
  } else {
    $stmt = $conn->prepare("INSERT INTO books (title, author, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $title, $author, $price, $image, $category);
    $stmt->execute();
    $success = "Book added successfully.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5" style="max-width:600px;">
  <h3 class="mb-3">Add New Book</h3>
  <?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <?php if ($success) echo "<div class='alert alert-success'>$success</div>"; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Author</label>
      <input type="text" name="author" class="form-control">
    </div>
    <div class="mb-3">
      <label>Price</label>
      <input type="number" name="price" class="form-control" step="0.01" required>
    </div>
    <div class="mb-3">
      <label>Image URL</label>
      <input type="text" name="image" class="form-control">
    </div>
    <div class="mb-3">
      <label>Category</label>
      <select name="category" class="form-select" required>
        <option value="">Select Category</option>
        <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
          <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
        <?php } ?>
      </select>
    </div>
    <button class="btn btn-primary w-100">Add Book</button>
  </form>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
