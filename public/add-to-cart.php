<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';

if (!isset($_GET['id'])) {
    die("❌ No product ID provided.");
}

$product_id = intval($_GET['id']);
$quantity = isset($_GET['qty']) ? intval($_GET['qty']) : 1;

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If already in cart, increase quantity
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

header("Location: cart.php");
exit;
