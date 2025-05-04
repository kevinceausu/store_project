<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';
include_once __DIR__ . '/../app/views/layouts/header.php';

$db = Database::getInstance()->getConnection();
$stmt = $db->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<h2>All Products</h2>

<?php if ($products): ?>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <?php if (!empty($product['image'])): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product image" class="product-img">
                <?php else: ?>
                    <div class="no-image">No image</div>
                <?php endif; ?>

                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>€<?php echo number_format($product['price'], 2); ?></p>
                <p>Stock: <?php echo (int)$product['stock']; ?></p>
                <a href="add-to-cart.php?id=<?php echo $product['id']; ?>">🛒 Add to Cart</a>

                <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                    <p>
                        <a href="update-single.php?id=<?php echo $product['id']; ?>">✏️ Edit</a> |
                        <a href="delete.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?');">🗑️ Delete</a>
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>

