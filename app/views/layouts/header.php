

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Games Store</title>
    <link rel="stylesheet" href="css/styles.css">



</head>
<body>


<header>
    <div class="navbar">
        <div class="logo">
            <a href="/store_project/public/index.php">🎮 My Games Store</a>
        </div>
        <nav>
            <ul class="nav">
                <li><a href="/store_project/public/index.php">🏠 Home</a></li>
                <li><a href="router.php?controller=product&action=index">🛒 Products</a></li>
                <li><a href="router.php?controller=cart&action=index">🛍️ Cart</a></li>

                <?php if (!empty($_SESSION['Active'])): ?>
                    <li><a href="/store_project/public/logout.php">🚪 Logout</a></li>
                    <li><a href="router.php?controller=order&action=history">📜 Order History</a></li>
                    <li><strong>👤 <?php echo htmlspecialchars($_SESSION['Username']); ?></strong></li>
                    <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <li><a href="/store_project/public/create.php">➕ Add Product</a></li>
                        <li><a href="/store_project/public/update.php">✏️ Edit Products</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="router.php?controller=auth&action=register">📝 Register</a></li>
                    <li><a href="router.php?controller=auth&action=login">🔑 Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <hr>
</header>
