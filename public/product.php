<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/models/Product.php';

if (!isset($_GET['id'])) {
    die("❌ Product ID not specified.");
}

$id = intval($_GET['id']);
$product = Product::getProductById($id);

if (!$product) {
    die("❌ Product not found.");
}
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<div class="product-details">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <img src="/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="product-img">
    <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
    <p><strong>Price:</strong> €<?php echo number_format($product['price'], 2); ?></p>
    <p><strong>In Stock:</strong> <?php echo $product['stock']; ?></p>

    <a href="add-to-cart.php?id=<?php echo $product['id']; ?>" class="btn">🛒 Add to Cart</a>
    <br><br>
    <a href="products.php">⬅ Back to Products</a>
</div>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>
