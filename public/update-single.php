<?php
session_start();



if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("❌ You do not have permission to access this page.");
}

?>

<?php
require_once __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance()->getConnection();

// Check if product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('❌ Product ID not specified.');
}

$product_id = intval($_GET['id']);

// Fetch the product by ID
$sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch();

if (!$product) {
    die('❌ Product not found.');
}

// Handle form submission
if (isset($_POST['submit'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image = htmlspecialchars(trim($_POST['image']));

    $updateSql = "UPDATE products 
                  SET name = :name, description = :description, price = :price, stock = :stock, image = :image 
                  WHERE id = :id";

    $updateStmt = $db->prepare($updateSql);
    $updateStmt->bindParam(':name', $name);
    $updateStmt->bindParam(':description', $description);
    $updateStmt->bindParam(':price', $price);
    $updateStmt->bindParam(':stock', $stock);
    $updateStmt->bindParam(':image', $image);
    $updateStmt->bindParam(':id', $product_id, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        $message = "✅ Product updated successfully!";
        // Reload updated product info
        $stmt->execute();
        $product = $stmt->fetch();
    } else {
        $message = "❌ Failed to update product.";
    }
}
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<div class="admin-form-card">
    <h2>✏️ Edit Product</h2>

    <?php if (isset($message)) : ?>
        <div class="<?php echo str_starts_with($message, '✅') ? 'success-box' : 'error-box'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label for="price">Price (€):</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

        <label for="stock">Stock Quantity:</label>
        <input type="number" id="stock" name="stock" value="<?php echo (int) $product['stock']; ?>" required>

        <label for="image">Image Filename (optional):</label>
        <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">

        <button type="submit" name="submit" class="btn">Update Product</button>
    </form>

    <div class="admin-actions">
        <a href="update.php" class="btn">⬅️ Back to Edit List</a>
        <a href="index.php" class="btn">🏠 Home</a>
    </div>
</div>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>

