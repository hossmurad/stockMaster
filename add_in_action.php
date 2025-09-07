<?php
require 'config.php';
if (empty($_SESSION['loggedin'])) { header('Location: login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = intval($_POST['product_id'] ?? 0);
    $qty = floatval($_POST['qty_kg'] ?? 0);
    if ($pid && $qty > 0) {
        $stmt = $conn->prepare('INSERT INTO product_in (product_id, qty_kg, entry_date) VALUES (?, ?, NOW())');
        $stmt->bind_param('id', $pid, $qty);
        $stmt->execute();
    }
    header('Location: product_in_details.php?product_id=' . $pid);
    exit;
}
header('Location: product_in.php');
exit;
?>