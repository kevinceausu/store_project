<?php
session_start();

if (!isset($_GET['id'])) {
    die("❌ No product ID provided.");
}

$product_id = intval($_GET['id']);

// Remove item from cart
if (isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
}

header("Location: cart.php");
exit;
