<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance()->getConnection();

$cart_items = [];
$cart_total = 0.00;

// Check if cart exists
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    // Build a list of product IDs to fetch
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $sql = "SELECT * FROM products WHERE id IN ($placeholders)";
    $stmt = $db->prepare($sql);
    $stmt->execute(array_keys($_SESSION['cart']));
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        $product_id = $product['id'];
        $quantity = $_SESSION['cart'][$product_id];
        $total_price = $product['price'] * $quantity;
        $cart_total += $total_price;

        $cart_items[] = [
            'id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'total' => $total_price
        ];
    }
}
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<h2>Your Shopping Cart</h2>

<?php if (!empty($cart_items)): ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price (€)</th>
                <th>Quantity</th>
                <th>Subtotal (€)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['total'], 2); ?></td>
                    <td>
                        <a href="remove-from-cart.php?id=<?php echo $item['id']; ?>">🗑️ Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: €<?php echo number_format($cart_total, 2); ?></h3>

    <div class="cart-actions">
        <a href="read.php">🛍️ Continue Shopping</a>
        <a href="checkout.php" class="checkout-button">🛒 Proceed to Checkout</a>
    </div>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>



<br>
<a href="index.php">🏠 Back to Home</a>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>
