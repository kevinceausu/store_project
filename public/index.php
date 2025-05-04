<?php
session_start();
include_once __DIR__ . '/../app/views/layouts/header.php';
?>

<div class="home-intro">
    <h1>👋 Welcome to My Games Store</h1>
    <div class="intro-text">
        <p>This is the home page. Browse our <a href="read.php">products</a>, add items to your cart, and check out when you're ready.</p>
        <?php if (!empty($_SESSION['Username'])): ?>
            <p>👤 Logged in as: <?php echo htmlspecialchars($_SESSION['Username']); ?></p>
        <?php endif; ?>
    </div>
</div>



<h2 class="section-heading">⭐ Featured Products</h2>

<?php
require_once __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance()->getConnection();
$stmt = $db->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 3");
$featured = $stmt->fetchAll();
?>

<?php if ($featured): ?>
    <div class="product-grid">
        <?php foreach ($featured as $product): ?>
            <div class="product-card">
                <?php if (!empty($product['image'])): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product image" class="product-img">
                <?php else: ?>
                    <div class="no-image">No image</div>
                <?php endif; ?>
                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>€<?php echo number_format($product['price'], 2); ?></p>
                <p>Stock: <?php echo (int) $product['stock']; ?></p>
                <a href="router.php?controller=cart&action=add&id=<?php echo $product['id']; ?>">🛒 Add to Cart</a>

            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No featured products found.</p>
<?php endif; ?>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>

