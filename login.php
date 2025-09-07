<?php
require 'config.php';   // session already handled inside config.php
$error = '';

if (isset($_POST['login'])) {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    if ($u === $admin_user && $p === $admin_pass) {
        session_regenerate_id(true);
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $admin_user;
        header('Location: index.php'); 
        exit;
    } else {
        $error = 'Invalid credentials.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- ✅ for mobile scaling -->
  <title>Login - StockMaster</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-10 col-md-6 col-lg-4"> <!-- ✅ adaptive width -->
        <div class="card shadow-lg border-0 rounded-3">
          <div class="card-body p-4">
            <h4 class="card-title text-center mb-4">🔐 StockMaster Login</h4>
            
            <?php if($error): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="post">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input class="form-control" type="text" name="username" required autofocus>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input class="form-control" type="password" name="password" required>
              </div>
              <div class="d-grid">
                <button name="login" class="btn btn-primary btn-lg">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
