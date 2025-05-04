<?php include_once __DIR__ . '/../layouts/header.php'; ?>

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
                        <a href="router.php?controller=cart&action=remove&id=<?php echo $item['id']; ?>">🗑️ Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: €<?php echo number_format($cart_total, 2); ?></h3>

    <div class="cart-actions">
        <a href="router.php?controller=product&action=index">🛍️ Continue Shopping</a>
        <a href="router.php?controller=cart&action=checkout" class="checkout-button">🛒 Proceed to Checkout</a>
    </div>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>

<br>
<a href="index.php">🏠 Back to Home</a>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
