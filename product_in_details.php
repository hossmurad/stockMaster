<?php
require_once 'config.php'; 

if (empty($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$pid = intval($_GET['product_id'] ?? 0);
if (!$pid) {
    header('Location: product_in.php');
    exit;
}

// Fetch product info
$stmt = $conn->prepare('SELECT id, name FROM products WHERE id = ?');
$stmt->bind_param('i', $pid);
$stmt->execute();
$prod = $stmt->get_result()->fetch_assoc();

// Fetch product_in entries
$res = $conn->prepare('SELECT id, qty_kg, entry_date FROM product_in WHERE product_id = ? ORDER BY entry_date DESC');
$res->bind_param('i', $pid);
$res->execute();
$entries = $res->get_result();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StockMaster - Product In Details</title>
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
        <li class="nav-item"><a class="nav-link" href="all_products.php"><i class="bi bi-list-ul me-1"></i> All Products</a></li>
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
  <h2>Stock Entries for: <?php echo esc($prod['name']); ?></h2>
  <p><a href="product_in.php" class="btn btn-sm btn-secondary mb-2"><i class="bi bi-arrow-left-circle me-1"></i> Back</a></p>

  <!-- Add Stock Entry -->
  <div class="card mb-3">
    <div class="card-body">
      <h5>Add Stock Entry</h5>
      <form method="post" action="add_in_action.php" class="row g-2">
        <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
        <div class="col-md-4">
          <input class="form-control" type="number" step="0.001" name="qty_kg" placeholder="Weight (kg)" required>
        </div>
        <div class="col-md-2">
          <button class="btn btn-success w-100" type="submit"><i class="bi bi-plus-circle me-1"></i> Add</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Stock Entries Table -->
  <div class="card">
    <div class="card-body">
      <h5>Entries</h5>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
          <thead class="table-primary">
            <tr>
              <th>SL</th>
              <th>Date</th>
              <th>Weight (kg)</th>
              <th>Invoice</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; while ($row = $entries->fetch_assoc()): ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo esc($row['entry_date']); ?></td>
                <td><?php echo (float)$row['qty_kg']; ?></td>
                <td>
                  <a class="btn btn-sm btn-info" href="invoice.php?type=in&id=<?php echo $row['id']; ?>" target="_blank">
                    <i class="bi bi-file-earmark-text me-1"></i> Invoice
                  </a>
                </td>
                <td>
                  <a class="btn btn-sm btn-danger" href="delete.php?type=in&id=<?php echo $row['id']; ?>">
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
