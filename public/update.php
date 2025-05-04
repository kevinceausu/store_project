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

// Get all products
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$stmt = $db->query($sql);
$products = $stmt->fetchAll();
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<div class="admin-form-card">
    <h2>🛠️ Edit Products</h2>

    <?php if (count($products) > 0): ?>
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price (€)</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo (int) $product['stock']; ?></td>
                        <td>
                            <a href="update-single.php?id=<?php echo $product['id']; ?>" class="btn small">✏️ Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>

    <div class="admin-actions">
        <a href="create.php" class="btn">➕ Add New Product</a>
        <a href="index.php" class="btn">🏠 Back to Home</a>
    </div>
</div>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>

