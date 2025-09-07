<?php
require 'config.php';
if (empty($_SESSION['loggedin'])) { 
    header('Location: login.php'); 
    exit; 
}

$product_id = intval($_GET['product_id'] ?? 0);
$product = $conn->query("SELECT * FROM products WHERE id=$product_id")->fetch_assoc();
if (!$product) { echo "Invalid product."; exit; }

// Handle dispatch add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO product_out (product_id, customer_name, customer_mobile, customer_address, qty_kg, amount) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param(
        "isssdd", 
        $product_id,
        $_POST['customer_name'],
        $_POST['customer_mobile'],
        $_POST['customer_address'],
        $_POST['qty_kg'],
        $_POST['amount']
    );
    $stmt->execute();
    header("Location: product_out_list.php?product_id=" . $product_id);
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dispatch - <?php echo esc($product['name']); ?></title>
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
        <li class="nav-item"><a class="nav-link" href="product_in.php"><i class="bi bi-box-arrow-in-down me-1"></i> Product In</a></li>
        <li class="nav-item"><a class="nav-link active" href="product_out.php"><i class="bi bi-box-arrow-up me-1"></i> Product Out</a></li>
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
  <h2>Dispatch Records - <?php echo esc($product['name']); ?></h2>
  <p><a href="product_out.php" class="btn btn-sm btn-secondary">&laquo; Back to Products</a></p>

  <!-- Add Dispatch Form -->
  <div class="card mb-3">
    <div class="card-body">
      <h5>Add Dispatch</h5>
      <form method="post" class="row g-2">
        <div class="col-md-3">
          <input class="form-control" name="customer_name" placeholder="Customer Name" required>
        </div>
        <div class="col-md-3">
          <input class="form-control" name="customer_mobile" type="tel" placeholder="Mobile" required>
        </div>
        <div class="col-md-3">
          <input class="form-control" name="customer_address" placeholder="Address">
        </div>
        <div class="col-md-1">
          <input class="form-control" type="number" step="0.001" name="qty_kg" placeholder="Weight (kg)" required>
        </div>
        <div class="col-md-2">
          <input class="form-control" type="number" step="0.01" name="amount" placeholder="Amount">
        </div>
        <div class="col-md-12 mt-2">
          <button class="btn btn-success"><i class="bi bi-plus-circle me-1"></i> Add Dispatch</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Dispatch Records Table -->
  <div class="card">
    <div class="card-body">
      <h5>All Dispatch Records</h5>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Customer</th>
              <th>Mobile</th>
              <th>Address</th>
              <th>Weight (kg)</th>
              <th>Amount</th>
              <th>Invoice</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $out = $conn->query("SELECT * FROM product_out WHERE product_id=$product_id ORDER BY created_at DESC");
          $i=1;
          while($r = $out->fetch_assoc()):
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo esc($r['created_at']); ?></td>
            <td><?php echo esc($r['customer_name']); ?></td>
            <td><?php echo esc($r['customer_mobile']); ?></td>
            <td><?php echo esc($r['customer_address']); ?></td>
            <td><?php echo (float)$r['qty_kg']; ?></td>
            <td><?php echo $r['amount']; ?></td>
            <td>
              <a href="invoice.php?type=out&id=<?php echo $r['id']; ?>" target="_blank" class="btn btn-sm btn-info">
                <i class="bi bi-receipt"></i> Invoice
              </a>
            </td>
            <td>
              <a href="delete.php?type=out&id=<?php echo $r['id']; ?>" class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Delete
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
