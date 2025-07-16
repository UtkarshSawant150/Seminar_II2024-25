<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user'])) {
  header("Location: user/login.php");
  exit();
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (!$cart) {
  die("Your cart is empty.");
}

$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
  $user_stmt->bind_param("s", $_SESSION['user']);
  $user_stmt->execute();
  $user_res = $user_stmt->get_result();
  $user = $user_res->fetch_assoc();
  $user_id = $user['id'];

  $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, 0)");
  $order_stmt->bind_param("i", $user_id);
  $order_stmt->execute();
  $order_id = $order_stmt->insert_id;

  $total = 0;
  foreach ($cart as $id => $qty) {
    $stmt = $conn->prepare("SELECT price FROM books WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $subtotal = $book['price'] * $qty;
    $total += $subtotal;

    $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");
    $item_stmt->bind_param("iiid", $order_id, $id, $qty, $book['price']);
    $item_stmt->execute();
  }

  $update_stmt = $conn->prepare("UPDATE orders SET total=? WHERE id=?");
  $update_stmt->bind_param("di", $total, $order_id);
  $update_stmt->execute();

  unset($_SESSION['cart']);
  header("Location: index.php?order=success");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Checkout - My Bookstore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
  <h3 class="mb-3">Checkout</h3>
  <p>Total: ₹<?php echo number_format(array_sum(array_map(function($id, $qty) use($conn) {
    $s = $conn->prepare("SELECT price FROM books WHERE id=?");
    $s->bind_param("i", $id);
    $s->execute();
    $r = $s->get_result();
    $b = $r->fetch_assoc();
    return $b['price'] * $qty;
  }, array_keys($cart), $cart)), 2); ?></p>
  <form method="POST">
    <button class="btn btn-success">Place Order</button>
  </form>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
