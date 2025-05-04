<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="product-detail-card">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>

    <?php if (!empty($product['image'])): ?>
        <img src="/store_project/uploads/<?php echo htmlspecialchars($product['image']); ?>" class="product-img large" alt="Product Image">
    <?php else: ?>
        <div class="no-image large">No image available</div>
    <?php endif; ?>

    <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
    <p><strong>Price:</strong> €<?php echo number_format($product['price'], 2); ?></p>
    <p><strong>Stock:</strong> <?php echo (int) $product['stock']; ?></p>

    <a href="router.php?controller=cart&action=add&id=<?php echo $product['id']; ?>" class="btn">🛒 Add to Cart</a><br><br>
    <a href="router.php?controller=product&action=index" class="btn">⬅ Back to Products</a>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
