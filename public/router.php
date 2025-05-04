<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/controllers/OrderController.php';

$db = Database::getInstance()->getConnection();

$controller = $_GET['controller'] ?? 'product';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

if ($controller === 'product') {
    $productController = new ProductController($db);

    if ($action === 'index') {
        $productController->index();
    } elseif ($action === 'show' && $id !== null) {
        $productController->show($id);
    } else {
        echo "404 - Action not found in product.";
    }

} elseif ($controller === 'auth') {
    $authController = new AuthController($db);

    if ($action === 'login') {
        $authController->login();
    } elseif ($action === 'register') {
        $authController->register();
    } else {
        echo "404 - Action not found in auth.";
    }

} elseif ($controller === 'cart') {
    $cartController = new CartController($db);

    if ($action === 'index') {
        $cartController->index();
    } elseif ($action === 'add' && isset($_GET['id'])) {
        $cartController->add();
    } elseif ($action === 'remove' && isset($_GET['id'])) {
        $cartController->remove();
    } elseif ($action === 'checkout') {
        $cartController->checkout();
    } else {
        echo "404 - Action not found in cart.";
    }

} elseif ($controller === 'order') {
    $orderController = new OrderController($db);

    if ($action === 'history') {
        $orderController->history();
    } else {
        echo "404 - Action not found in order.";
    }

} else {
    echo "404 - Controller not found.";
}



