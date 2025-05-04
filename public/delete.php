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

// Delete the product
$sql = "DELETE FROM products WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $product_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $message = "✅ Product deleted successfully!";
} else {
    $message = "❌ Failed to delete product.";
}
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<div class="admin-form-card">
    <h2>🗑️ Delete Product</h2>

    <div class="<?php echo str_starts_with($message, '✅') ? 'success-box' : 'error-box'; ?>">
        <?php echo $message; ?>
    </div>

    <div class="admin-actions">
        <a href="read.php" class="btn">📄 View All Products</a>
        <a href="index.php" class="btn">🏠 Home</a>
    </div>
</div>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>

