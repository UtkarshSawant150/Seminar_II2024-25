<?php
session_start();
include 'config/db.php';


// Get categories
$catResult = mysqli_query($conn, "SELECT * FROM categories");

// Handle filters
$search = "";
$category = "";
$query = "SELECT * FROM books WHERE 1";

if (!empty($_GET['search'])) {
  $search = mysqli_real_escape_string($conn, $_GET['search']);
  $query .= " AND (title LIKE '%$search%' OR author LIKE '%$search%')";
}
if (!empty($_GET['category'])) {
  $category = intval($_GET['category']);
  $query .= " AND category_id = $category";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Bookstore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
  <form class="row mb-4" method="GET">
    <div class="col-md-4 mb-2">
      <input type="search" name="search" class="form-control" placeholder="Search books..." value="<?php echo htmlspecialchars($search); ?>">
    </div>
    <div class="col-md-3 mb-2">
      <select name="category" class="form-select">
        <option value="">All Categories</option>
        <?php while($cat = mysqli_fetch_assoc($catResult)) { ?>
          <option value="<?php echo $cat['id']; ?>" <?php if($cat['id']==$category) echo 'selected'; ?>>
            <?php echo htmlspecialchars($cat['name']); ?>
          </option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md-2 mb-2">
      <button class="btn btn-primary w-100">Filter</button>
    </div>
  </form>

  <div class="row">
    <?php if (mysqli_num_rows($result) > 0) { ?>
      <?php while($book = mysqli_fetch_assoc($result)) { ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100">
          <img src="<?php echo htmlspecialchars($book['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($book['title']); ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($book['author']); ?></p>
            <p><strong>₹<?php echo number_format($book['price'],2); ?></strong></p>
            <a href="book.php?id=<?php echo $book['id']; ?>" class="btn btn-primary w-100">View Details</a>
          </div>
        </div>
      </div>
      <?php } ?>
    <?php } else { ?>
      <p>No books found.</p>
    <?php } ?>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
