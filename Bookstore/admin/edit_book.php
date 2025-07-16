<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../user/login.php");
  exit();
}
include '../config/db.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

$error = "";
$success = "";

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
    $update = $conn->prepare("UPDATE books SET title=?, author=?, price=?, image=?, category_id=? WHERE id=?");
    $update->bind_param("ssdsii", $title, $author, $price, $image, $category, $id);
    $update->execute();
    $success = "Book updated successfully.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5" style="max-width:600px;">
  <h3 class="mb-3">Edit Book</h3>
  <?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <?php if ($success) echo "<div class='alert alert-success'>$success</div>"; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($book['title']); ?>" required>
    </div>
    <div class="mb-3">
      <label>Author</label>
      <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($book['author']); ?>">
    </div>
    <div class="mb-3">
      <label>Price</label>
      <input type="number" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($book['price']); ?>" required>
    </div>
    <div class="mb-3">
      <label>Image URL</label>
      <input type="text" name="image" class="form-control" value="<?php echo htmlspecialchars($book['image']); ?>">
    </div>
    <div class="mb-3">
      <label>Category</label>
      <select name="category" class="form-select" required>
        <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
          <option value="<?php echo $cat['id']; ?>" <?php if($cat['id'] == $book['category_id']) echo 'selected'; ?>>
            <?php echo htmlspecialchars($cat['name']); ?>
          </option>
        <?php } ?>
      </select>
    </div>
    <button class="btn btn-primary w-100">Update Book</button>
  </form>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
