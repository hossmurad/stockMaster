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
  <title>Product In - StockMaster</title>
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
    .footer {
        text-align:center; padding:15px; margin-top:30px; font-size:0.9rem; color:#555;
    }
    .footer a { text-decoration:none; color:#007bff; }
    .footer a:hover { color:#0056b3; text-decoration:underline; }
  </style>
</head>
<body>

<!-- HEADER -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <i class="bi bi-box-seam"></i> StockMaster
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="all_products.php"><i class="bi bi-list-ul me-1"></i> All Products</a></li>
        <li class="nav-item"><a class="nav-link active" href="product_in.php"><i class="bi bi-box-arrow-in-down me-1"></i> Product In</a></li>
        <li class="nav-item"><a class="nav-link" href="product_out.php"><i class="bi bi-box-arrow-up me-1"></i> Product Out</a></li>
      </ul>
      <span class="navbar-text text-white">
        <i class="bi bi-person-circle"></i> <?php echo esc($_SESSION['user']); ?> &nbsp;
        <a class="btn btn-sm btn-dark" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
      </span>
    </div>
  </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container my-4 content">
  <h2>Product In (Stock Entries)</h2>
  <p><a href='index.php' class='btn btn-sm btn-secondary mb-2'><i class="bi bi-house-door-fill me-1"></i> Dashboard</a></p>

  <div class="card">
    <div class="card-body">
      <h5>Products</h5>
      <div class='table-responsive'>
        <table class='table table-hover table-bordered'>
          <thead class="table-primary">
            <tr>
              <th>SL</th>
              <th>Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $res = $conn->query('SELECT id, name FROM products ORDER BY id'); 
          $i=1; 
          while($p = $res->fetch_assoc()): 
          ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo esc($p['name']); ?></td>
              <td>
                <a class='btn btn-sm btn-primary' href='product_in_details.php?product_id=<?php echo $p['id']; ?>'>
                  <i class="bi bi-pencil-square me-1"></i> Details / Add
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
