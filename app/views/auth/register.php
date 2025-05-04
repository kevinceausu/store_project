<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="admin-form-card">
    <h2>📝 Register</h2>

    <?php if (!empty($message)): ?>
        <div class="<?php echo str_starts_with($message, '✅') ? 'success-box' : 'error-box'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="submit" class="btn">Register</button>
    </form>

    <div class="admin-actions">
        <a href="router.php?controller=auth&action=login" class="btn">🔐 Back to Login</a>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>

