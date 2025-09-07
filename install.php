<?php
require 'config.php';
if (isset($_POST['install'])) {
    $sqls = [];
    $sqls[] = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(191) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $sqls[] = "CREATE TABLE IF NOT EXISTS product_in (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        qty_kg DECIMAL(10,3) NOT NULL,
        entry_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $sqls[] = "CREATE TABLE IF NOT EXISTS product_out (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        customer_name VARCHAR(191),
        customer_address TEXT,
        qty_kg DECIMAL(10,3) NOT NULL,
        amount DECIMAL(12,2),
        out_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    foreach ($sqls as $sql) {
        if (!$conn->query($sql)) {
            echo "Error creating table: " . $conn->error;
            exit;
        }
    }
    echo "<h3 class='alert alert-success'>Success: Tables created.</h3>";
    echo "<p>Please delete <strong>install.php</strong> now (for security).</p>";
    echo "<p><a href='login.php' class='btn btn-primary'>Go to Login</a></p>";
    exit;
}
?>
<!doctype html><html><head><meta charset='utf-8'><title>Install StockMaster</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4">
<div class="container">
<h2>Install StockMaster</h2>
<p>This will create the required database tables (if they do not already exist).</p>
<form method='post'>
    <button name='install' type='submit' class='btn btn-success'>Create Tables</button>
</form>
</div>
</body></html>