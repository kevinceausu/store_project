<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<h2 class="order-history-title">📜 Your Order History</h2>


<?php if (empty($orders)): ?>
    <p>You haven't placed any orders yet.</p>
<?php else: ?>
    <div class="order-history-wrapper">
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <h3>Order #<?php echo $order['id']; ?></h3>
                <p><strong>Date:</strong> <?php echo $order['created_at']; ?></p>
                <p><strong>Total:</strong> €<?php echo number_format($order['total'], 2); ?></p>
                <ul class="order-items">
                    <?php foreach ($itemsByOrder[$order['id']] as $item): ?>
                        <li>
                            <?php echo htmlspecialchars($item['name']); ?>
                            — <?php echo $item['quantity']; ?> x €<?php echo number_format($item['price'], 2); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<br>
<a href="index.php" class="btn">🏠 Back to Home</a>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>


