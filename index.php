<?php
require 'config.php';
if (empty($_SESSION['loggedin'])) { 
    header('Location: login.php'); 
    exit; 
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StockMaster</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Custom Styles -->
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Card hover effect */
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        transition: all 0.3s ease-in-out;
    }

    /* Buttons hover */
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: #fff;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn-outline-success:hover {
        background-color: #198754;
        color: #fff;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    /* Navbar links hover */
    .nav-link:hover {
        color: #ffd700 !important;
        transition: 0.2s;
    }

    /* Footer style */
    .footer {
        text-align: center;
        padding: 15px;
        margin-top: 50px;
        font-size: 0.9rem;
        color: #555;
    }
    .footer a {
        text-decoration: none;
        color: #007bff;
    }
    .footer a:hover {
        color: #0056b3;
        text-decoration: underline;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="bi bi-box-seam"></i> StockMaster</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="all_products.php"><i class="bi bi-list-ul"></i> All Products</a></li>
        <li class="nav-item"><a class="nav-link" href="product_in.php"><i class="bi bi-box-arrow-in-down"></i> Product In</a></li>
        <li class="nav-item"><a class="nav-link" href="product_out.php"><i class="bi bi-box-arrow-up"></i> Product Out</a></li>
      </ul>
      <span class="navbar-text text-white">
        <i class="bi bi-person-circle"></i> <?php echo esc($_SESSION['user']); ?> 
        &nbsp; <a class="btn btn-sm btn-dark" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
      </span>
    </div>
  </div>
</nav>

<div class="container my-4">
  <div class="row g-4">
    <!-- Dashboard Cards -->
    <div class="col-md-4 col-sm-6">
      <div class="card text-center shadow-sm h-100">
        <div class="card-body">
          <i class="bi bi-list-ul display-4 text-primary"></i>
          <h5 class="card-title mt-2">All Products</h5>
          <p class="card-text">Manage product list and stock summary.</p>
          <a href="all_products.php" class="btn btn-outline-primary btn-sm">Go</a>
        </div>
      </div>
    </div>
    
    <div class="col-md-4 col-sm-6">
      <div class="card text-center shadow-sm h-100">
        <div class="card-body">
          <i class="bi bi-box-arrow-in-down display-4 text-success"></i>
          <h5 class="card-title mt-2">Product In</h5>
          <p class="card-text">Add and track stock entries with invoices.</p>
          <a href="product_in.php" class="btn btn-outline-success btn-sm">Go</a>
        </div>
      </div>
    </div>
    
    <div class="col-md-4 col-sm-6">
      <div class="card text-center shadow-sm h-100">
        <div class="card-body">
          <i class="bi bi-box-arrow-up display-4 text-danger"></i>
          <h5 class="card-title mt-2">Product Out</h5>
          <p class="card-text">Record dispatches, customers, and invoices.</p>
          <a href="product_out.php" class="btn btn-outline-danger btn-sm">Go</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Summary Section -->
  <div class="row mt-5">
    <div class="col-md-6 mx-auto">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-bar-chart-fill"></i> Quick Summary</h5>
          <?php
          $res = $conn->query("SELECT COUNT(*) AS c FROM products");
          $c = $res->fetch_assoc()['c'] ?? 0;
          echo "<p>Total products: <strong>" . (int)$c . "</strong></p>";
          ?>
          <p class="text-muted">Use the cards above to manage inventory.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<div class="footer">
  This system is designed and developed by 
  <a href="https://wa.me/8801517800309" target="_blank">Md. Murad Hossain</a> &copy; <?php echo date('Y'); ?>
</div>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

