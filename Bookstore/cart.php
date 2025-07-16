<?php
session_start();
include 'config/db.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (isset($_POST['update'])) {
  foreach ($_POST['quantity'] as $id => $qty) {
    if ($qty <= 0) {
      unset($_SESSION['cart'][$id]);
    } else {
      $_SESSION['cart'][$id] = $qty;
    }
  }
  header("Location: cart.php");
  exit();
}

$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cart - My Bookstore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
  <h3 class="mb-3">Your Cart</h3>
  <?php if ($cart) { ?>
  <form method="POST">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Book</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($cart as $id => $qty) {
          $stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $result = $stmt->get_result();
          $book = $result->fetch_assoc();
          $subtotal = $book['price'] * $qty;
          $total += $subtotal;
        ?>
        <tr>
          <td><?php echo htmlspecialchars($book['title']); ?></td>
          <td>₹<?php echo number_format($book['price'],2); ?></td>
          <td style="max-width:100px;">
            <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="0" class="form-control">
          </td>
          <td>₹<?php echo number_format($subtotal,2); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <p><strong>Total: ₹<?php echo number_format($total,2); ?></strong></p>
    <button name="update" class="btn btn-primary">Update Cart</button>
    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
  </form>
  <?php } else { ?>
    <p>Your cart is empty.</p>
  <?php } ?>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
