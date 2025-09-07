<?php
// Show errors (only for debugging, remove in production!)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection settings
$host = "";  // Change if your hosting gives a different DB Host
$user = "";   // Your DB username
$pass = "";  // Your DB password
$db   = "";   // Your DB name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Admin credentials
$admin_user = "";
$admin_pass = "";

// Escape helper function (prevent XSS)
function esc($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
