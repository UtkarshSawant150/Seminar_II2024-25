<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="/bookstore/">
      <img src="/bookstore/assets/images/logo.png" alt="Logo" style="height:40px;">
      My Bookstore
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <form class="d-flex me-auto" action="/bookstore/index.php" method="get">
        <input class="form-control me-2" type="search" name="search" placeholder="Search books...">
        <button class="btn btn-primary" type="submit">Search</button>
      </form>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/bookstore/cart.php">Cart</a>
        </li>
        <?php if (isset($_SESSION['user']) || isset($_SESSION['admin'])) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/bookstore/user/logout.php">Logout</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="/bookstore/user/login.php">Login</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
