<?php
require 'config.php';
if (empty($_SESSION['loggedin'])) { header('Location: login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = intval($_POST['product_id'] ?? 0);
    $cust = trim($_POST['customer_name'] ?? '');
    $addr = trim($_POST['customer_address'] ?? '');
    $qty = floatval($_POST['qty_kg'] ?? 0);
    $amount = ($_POST['amount'] === '') ? null : floatval($_POST['amount']);
    if ($pid && $qty > 0) {
        $stmt = $conn->prepare('INSERT INTO product_out (product_id, customer_name, customer_address, qty_kg, amount, out_date) VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->bind_param('issdd', $pid, $cust, $addr, $qty, $amount);
        $stmt->execute();
    }
}
header('Location: product_out.php');
exit;
?>