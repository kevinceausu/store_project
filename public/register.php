<?php
require_once __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance()->getConnection();
$message = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Basic validation
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Check if user already exists
        $checkSql = "SELECT * FROM users WHERE email = :email";
        $checkStmt = $db->prepare($checkSql);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $message = "❌ Email is already registered.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password_hash) 
                    VALUES (:username, :email, :password_hash)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $password_hash);

            if ($stmt->execute()) {
                $message = "✅ Registered successfully. <a href='login.php'>Click here to log in</a>.";
            } else {
                $message = "❌ Registration failed.";
            }
        }
    } else {
        $message = "❌ All fields are required.";
    }
}
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<h2>Register</h2>

<?php if (!empty($message)) echo "<p>$message</p>"; ?>

<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="submit">Register</button>
</form>

<br>
<a href="login.php">Already have an account? Login</a>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>
