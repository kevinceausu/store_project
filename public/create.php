

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


if (isset($_POST['submit'])) {
    $db = Database::getInstance()->getConnection();

    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image = htmlspecialchars(trim($_POST['image']));

    $sql = "INSERT INTO products (name, description, price, image, stock) 
            VALUES (:name, :description, :price, :image, :stock)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':stock', $stock);

    if ($stmt->execute()) {
        $message = "✅ Product added successfully!";
    } else {
        $message = "❌ Failed to add product.";
    }
}
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<div class="admin-form-card">
    <h2>➕ Add New Product</h2>

    <?php if (isset($message)) : ?>
        <div class="<?php echo str_starts_with($message, '✅') ? 'success-box' : 'error-box'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Price (€):</label>
        <input type="number" step="0.01" id="price" name="price" required>

        <label for="stock">Stock Quantity:</label>
        <input type="number" id="stock" name="stock" required>

        <label for="image">Image Filename (optional):</label>
        <input type="text" id="image" name="image">

        <button type="submit" name="submit" class="btn">Add Product</button>
    </form>

    <a href="index.php" class="btn" style="margin-top: 10px;">⬅️ Back to Home</a>
</div>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>
