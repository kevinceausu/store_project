<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance()->getConnection();
$message = "";

// Handle form submit
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Login success
            $_SESSION['Active'] = true;
            $_SESSION['Username'] = $user['username'];
            $_SESSION['UserID'] = $user['id'];

            $_SESSION['is_admin'] = $user['is_admin'];

            header('Location: index.php');
            exit;
        } else {
            $message = "❌ Incorrect email or password.";
        }
    } else {
        $message = "❌ Please fill in all fields.";
    }
}
?>

<?php include_once __DIR__ . '/../app/views/layouts/header.php'; ?>

<h2>Login</h2>

<?php if (!empty($message)) echo "<p>$message</p>"; ?>

<form method="POST" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="submit">Login</button>
</form>

<br>
<a href="register.php">Don't have an account? Register</a>

<?php include_once __DIR__ . '/../app/views/layouts/footer.php'; ?>
