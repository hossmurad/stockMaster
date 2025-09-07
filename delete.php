<?php
require 'config.php';

// Only allow logged-in users
if (empty($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Set deletion password (can use admin password from config)
$deletion_password = $admin_pass;

$type = $_GET['type'] ?? '';
$id = intval($_GET['id'] ?? 0);
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pw = $_POST['pw'] ?? '';
    if ($pw !== $deletion_password) {
        $err = 'Invalid deletion password.';
    } else {
        if ($_POST['type'] === 'product') {
            $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
            $stmt->bind_param('i', $_POST['id']);
            $stmt->execute();
            header('Location: all_products.php');
            exit;
        } elseif ($_POST['type'] === 'in') {
            $stmt = $conn->prepare('DELETE FROM product_in WHERE id = ?');
            $stmt->bind_param('i', $_POST['id']);
            $stmt->execute();
            header('Location: product_in.php');
            exit;
        } elseif ($_POST['type'] === 'out') {
            $stmt = $conn->prepare('DELETE FROM product_out WHERE id = ?');
            $stmt->bind_param('i', $_POST['id']);
            $stmt->execute();
            header('Location: product_out.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Delete - StockMaster</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="container">
  <div class="col-md-6 col-lg-5 mx-auto">
    <div class="card shadow-lg border-0 rounded-3">
      <div class="card-body p-4">
        <h4 class="card-title mb-4 text-center text-danger">⚠️ Delete Confirmation</h4>

        <?php if (!empty($err)): ?>
          <div class="alert alert-danger"><?php echo esc($err); ?></div>
        <?php endif; ?>

        <p>You're about to delete <strong><?php echo esc($type); ?></strong> record with ID: <?php echo $id; ?></p>

        <form method="post">
          <input type="hidden" name="type" value="<?php echo esc($type); ?>">
          <input type="hidden" name="id" value="<?php echo $id; ?>">

          <div class="mb-3">
            <label class="form-label">Enter deletion password</label>
            <input class="form-control" type="password" name="pw" required autofocus>
          </div>

          <div class="d-grid gap-2">
            <button class="btn btn-danger" type="submit">Confirm Delete</button>
            <a class="btn btn-secondary" href="javascript:history.back()">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>
