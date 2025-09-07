<?php
require 'config.php';
if (empty($_SESSION['loggedin'])) { 
    header('Location: login.php'); 
    exit; 
}

$sql = "SELECT p.id, p.name,
  (SELECT COALESCE(SUM(qty_kg),0) FROM product_in WHERE product_id = p.id) AS total_in,
  (SELECT COALESCE(SUM(qty_kg),0) FROM product_out WHERE product_id = p.id) AS total_out
  FROM products p ORDER BY p.id";
$res = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StockMaster - All Products</title>
  <!-- Bootstrap 5 & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <style>
    body { display:flex; flex-direction:column; min-height:100vh; }
    .content { flex:1; }
    /* Navbar hover */
    .navbar .nav-link:hover { color: #ffd700 !important; transition: 0.2s; }
    .navbar-brand i { margin-right: 0.5rem; }
    /* Footer styling */
    .footer { text-align:center; padding:15px; margin-top:30px; font-size:0.9rem; color:#555; }
    .footer a { text-decoration:none; color:#007bff; }
    .footer a:hover { color:#0056b3; text-decoration:underline; }
    /* Logout button dark */
    .btn-logout {
        background-color:#343a40;
        color:#fff;
        border:none;
    }
    .btn-logout:hover {
        background-color:#23272b;
        color:#fff;
    }
  </style>
</head>
<body>

<!-- HEADER -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <i class="bi bi-box-seam"></i> StockMaster
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="all_products.php"><i class="bi bi-list-ul me-1"></i> All Products</a></li>
        <li class="nav-item"><a class="nav-link" href="product_in.php"><i class="bi bi-box-arrow-in-down me-1"></i> Product In</a></li>
        <li class="nav-item"><a class="nav-link" href="product_out.php"><i class="bi bi-box-arrow-up me-1"></i> Product Out</a></li>
      </ul>
      <span class="navbar-text text-white">
        <i class="bi bi-person-circle"></i> <?php echo esc($_SESSION['user']); ?> &nbsp;
        <a class="btn btn-sm btn-logout" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
      </span>
    </div>
  </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container my-4 content">
  <h2>All Products</h2>
  <p><a href='index.php' class='btn btn-sm btn-secondary mb-2'><i class="bi bi-house-door-fill me-1"></i> Dashboard</a></p>

  <!-- Add Product -->
  <div class="card mb-3">
    <div class="card-body">
      <h5>Add Product</h5>
      <form method='post' action='add_product.php' class='row g-2'>
        <div class='col-md-8'>
          <input class='form-control' type='text' name='name' placeholder='Product name' required>
        </div>
        <div class='col-md-4'>
          <button class='btn btn-success w-100' type='submit'><i class="bi bi-plus-circle me-1"></i> Add Product</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Products List -->
  <div class="card">
    <div class="card-body">
      <h5 class='card-title'>Products List</h5>
      <div class='table-responsive'>
        <table class='table table-striped table-hover table-bordered'>
          <thead class="table-primary">
            <tr>
              <th>SL</th>
              <th>Name</th>
              <th>Total In (kg)</th>
              <th>Total Out (kg)</th>
              <th>Remaining (kg)</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $i=1; 
          while($row = $res->fetch_assoc()): 
              $remain = (float)$row['total_in'] - (float)$row['total_out'];
          ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo esc($row['name']); ?></td>
              <td><?php echo (float)$row['total_in']; ?></td>
              <td><?php echo (float)$row['total_out']; ?></td>
              <td><?php echo $remain; ?></td>
              <td>
                <a class='btn btn-sm btn-danger' href='delete.php?type=product&id=<?php echo $row['id']; ?>'
                   onclick="return confirm('Are you sure?')">
                   <i class="bi bi-trash me-1"></i> Delete
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<div class="footer mt-5">
  This system is designed and developed by 
  <a href="https://wa.me/8801517800309" target="_blank">Md. Murad Hossain</a> &copy; <?php echo date('Y'); ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
