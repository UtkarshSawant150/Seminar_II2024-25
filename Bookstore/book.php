<?php
session_start();
include 'config/db.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT books.*, categories.name as category_name FROM books LEFT JOIN categories ON books.category_id = categories.id WHERE books.id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
  die("Book not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $quantity = intval($_POST['quantity']);
  if ($quantity > 0) {
    $_SESSION['cart'][$id] = $quantity;
    header("Location: cart.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo htmlspecialchars($book['title']); ?> - My Bookstore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
  <div class="row">
    <div class="col-md-4">
      <img src="<?php echo htmlspecialchars($book['image']); ?>" class="img-fluid">
    </div>
    <div class="col-md-8">
      <h3><?php echo htmlspecialchars($book['title']); ?></h3>
      <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
      <p>Category: <?php echo htmlspecialchars($book['category_name']); ?></p>
      <p><strong>₹<?php echo number_format($book['price'],2); ?></strong></p>
      <form method="POST" class="mt-3">
        <div class="input-group mb-3" style="max-width:200px;">
          <input type="number" name="quantity" class="form-control" value="1" min="1">
          <button class="btn btn-primary" type="submit">Add to Cart</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
