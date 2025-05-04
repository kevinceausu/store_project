<?php

class OrderController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function history()
    {
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            header("Location: router.php?controller=auth&action=login");
            exit;
        }

        $userId = $_SESSION['UserID'];

        // Fetch orders
        $orderStmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC");

        $orderStmt->bindParam(':user_id', $userId);
        $orderStmt->execute();
        $orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch order items
        $itemsByOrder = [];

        foreach ($orders as $order) {
            $itemStmt = $this->db->prepare("
                SELECT oi.*, p.name
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = :order_id
            ");
            $itemStmt->bindParam(':order_id', $order['id']);
            $itemStmt->execute();
            $itemsByOrder[$order['id']] = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        require __DIR__ . '/../views/order/history.php';
    }
}
