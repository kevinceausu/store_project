<?php include_once __DIR__ . '/../layouts/header.php'; ?>

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
        <a href="router.php?controller=cart&action=index" class="button-link">⬅️ Back to Cart</a>
    </div>
<?php endif; ?>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
