<?php
require_once __DIR__ . '/../app/core/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "✅ Database connection successful!";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage();
}
?>
