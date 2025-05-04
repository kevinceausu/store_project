<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';

// Protect page — only for logged-in users
if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
    header("Location: login.php");
    exit;
}

$db = Database::getInstance()->getConnection();
$user_id = $_SESSION['UserID'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die("❌ Your cart is empty.");
}

try {
    $db->beginTransaction();

    // Calculate total
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $db->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($cart));
    $products = $stmt->fetchAll();

    $total = 0.00;
    foreach ($products as $product) {
        $pid = $product['id'];
        $qty = $cart[$pid];
        $total += $product['price'] * $qty;
    }

    // Insert into orders table
    $orderSql = "INSERT INTO orders (user_id, total) VALUES (:user_id, :total)";
    $orderStmt = $db->prepare($orderSql);
    $orderStmt->bindParam(':user_id', $user_id);
    $orderStmt->bindParam(':total', $total);
    $orderStmt->execute();

    $order_id = $db->lastInsertId();

    // Insert into order_items
    $itemSql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                VALUES (:order_id, :product_id, :quantity, :price)";
    $itemStmt = $db->prepare($itemSql);

    foreach ($products as $product) {
        $pid = $product['id'];
        $qty = $cart[$pid];
        $price = $product['price'];

        $itemStmt->execute([
            ':order_id' => $order_id,
            ':product_id' => $pid,
            ':quantity' => $qty,
            ':price' => $price
        ]);
    }

    $db->commit();
    unset($_SESSION['cart']); // Clear the cart
    $success = true;
} catch (Exception $e) {
    $db->rollBack();
    $success = false;
    $error = $e->getMessage();
}
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<h2>Checkout</h2>

<?php if (isset($success) && $success): ?>
    <div class="success-box">
        <p>✅ Your order was placed successfully!</p>
        <a href="index.php" class="button-link">🏠 Return to Home</a>
    </div>
<?php else: ?>
    <div class="error-box">
        <p>❌ Something went wrong during checkout.</p>
        <p><?php echo htmlspecialchars($error ?? 'Unknown error'); ?></p>
        <a href="cart.php" class="button-link">⬅️ Back to Cart</a>
    </div>
<?php endif; ?>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>

