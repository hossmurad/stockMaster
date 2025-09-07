<?php
require 'config.php';
if (empty($_SESSION['loggedin'])) { header('Location: login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        $stmt = $conn->prepare('INSERT INTO products (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $stmt->execute();
    }
}
header('Location: all_products.php');
exit;
?>