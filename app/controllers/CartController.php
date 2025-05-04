<?php

require_once __DIR__ . '/../models/Product.php';

class CartController
{
    private $db;
    private $productModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->productModel = new Product($db);
    }

    public function index()
    {
        $cart_items = [];
        $cart_total = 0.00;

        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
            $sql = "SELECT * FROM products WHERE id IN ($placeholders)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array_keys($_SESSION['cart']));
            $products = $stmt->fetchAll();

            foreach ($products as $product) {
                $product_id = $product['id'];
                $quantity = $_SESSION['cart'][$product_id];
                $total_price = $product['price'] * $quantity;
                $cart_total += $total_price;

                $cart_items[] = [
                    'id' => $product_id,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'total' => $total_price
                ];
            }
        }

        require __DIR__ . '/../views/cart/cart.php';
    }

    public function add()
    {
        if (!isset($_GET['id'])) {
            die("❌ No product ID provided.");
        }

        $product_id = intval($_GET['id']);
        $quantity = isset($_GET['qty']) ? intval($_GET['qty']) : 1;

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }

        header("Location: router.php?controller=cart&action=index");
        exit;
    }

    public function remove()
    {
        if (!isset($_GET['id'])) {
            die("❌ No product ID provided.");
        }

        $product_id = intval($_GET['id']);

        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }

        header("Location: router.php?controller=cart&action=index");
        exit;
    }

    public function checkout()
    {
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            header("Location: router.php?controller=auth&action=login");
            exit;
        }
    
        $user_id = $_SESSION['UserID'];
        $cart = $_SESSION['cart'] ?? [];
    
        if (empty($cart)) {
            die("❌ Your cart is empty.");
        }
    
        try {
            $this->db->beginTransaction();
    
            // Fetch products based on cart keys
            $placeholders = implode(',', array_fill(0, count($cart), '?'));
            $stmt = $this->db->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
            $stmt->execute(array_keys($cart));
            $products = $stmt->fetchAll();
    
            if (!$products) {
                throw new Exception("❌ No matching products found.");
            }
    
            $total = 0.00;
    
            foreach ($products as $product) {
                $pid = (string) $product['id'];
                $qty = isset($cart[$pid]) ? $cart[$pid] : 0;
    
                if ($qty <= 0) {
                    continue;
                }
    
                $total += $product['price'] * $qty;
            }
    
            // Insert order
            $orderSql = "INSERT INTO orders (user_id, total) VALUES (:user_id, :total)";
            $orderStmt = $this->db->prepare($orderSql);
            $orderStmt->bindParam(':user_id', $user_id);
            $orderStmt->bindParam(':total', $total);
            $orderStmt->execute();
    
            $order_id = $this->db->lastInsertId();
    
            // Insert order items & update stock
            $itemSql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
            $itemStmt = $this->db->prepare($itemSql);
    
            foreach ($products as $product) {
                $pid = (string) $product['id'];
                $qty = isset($cart[$pid]) ? $cart[$pid] : 0;
    
                if ($qty <= 0) continue;
    
                $price = $product['price'];
    
                $itemStmt->execute([
                    ':order_id' => $order_id,
                    ':product_id' => $pid,
                    ':quantity' => $qty,
                    ':price' => $price
                ]);
    
                $updateStockStmt = $this->db->prepare("UPDATE products SET stock = stock - :qty WHERE id = :id");
                $updateStockStmt->execute([
                    ':qty' => $qty,
                    ':id' => $pid
                ]);
    
                // Optional debug — remove once working
                echo "✔️ Updated stock for product ID $pid (-$qty)<br>";
            }
    
            $this->db->commit();
            unset($_SESSION['cart']);
            $success = true;
    
        } catch (Exception $e) {
            $this->db->rollBack();
            $success = false;
            $error = $e->getMessage();
        }
    
        require __DIR__ . '/../views/cart/checkout.php';
    }
    
}
