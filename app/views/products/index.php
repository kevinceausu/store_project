<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<h2 class="section-heading">🎮 All Products</h2>

<?php if ($products): ?>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <?php if (!empty($product['image'])): ?>
                    <img src="/store_project/uploads/<?php echo htmlspecialchars($product['image']); ?>" class="product-img" alt="Product Image">
                <?php else: ?>
                    <div class="no-image">No image</div>
                <?php endif; ?>

                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                <p>€<?php echo number_format($product['price'], 2); ?></p>

                <a href="router.php?controller=product&action=show&id=<?php echo $product['id']; ?>" class="btn small">🔍 View Details</a>
                <a href="router.php?controller=cart&action=add&id=<?php echo $product['id']; ?>">🛒 Add to Cart</a>


                <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                    <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn small danger" onclick="return confirm('Are you sure you want to delete this product?');">🗑️ Delete</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>

