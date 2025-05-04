-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for store_db
CREATE DATABASE IF NOT EXISTS `store_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `store_db`;

-- Dumping structure for table store_db.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table store_db.orders: ~22 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`) VALUES
	(1, 1, 99.98, '2025-04-29 16:12:12'),
	(2, 1, 89.98, '2025-04-29 16:18:23'),
	(3, 1, 209.96, '2025-05-02 02:22:13'),
	(4, 2, 89.97, '2025-05-02 12:52:30'),
	(5, 2, 9.99, '2025-05-02 12:54:04'),
	(6, 2, 39.98, '2025-05-02 13:12:25'),
	(7, 2, 9.99, '2025-05-04 02:54:14'),
	(8, 2, 209.97, '2025-05-04 03:52:15'),
	(9, 3, 89.96, '2025-05-04 06:07:27'),
	(10, 3, 49.98, '2025-05-04 06:08:03'),
	(11, 2, 199.99, '2025-05-04 08:34:09'),
	(12, 2, 199.99, '2025-05-04 08:39:32'),
	(13, 4, 659.97, '2025-05-04 10:36:24'),
	(14, 2, 199.99, '2025-05-04 10:40:57'),
	(15, 2, 199.99, '2025-05-04 10:48:13'),
	(16, 2, 199.99, '2025-05-04 10:48:47'),
	(17, 2, 199.99, '2025-05-04 10:51:15'),
	(18, 2, 199.99, '2025-05-04 10:51:23'),
	(19, 2, 199.99, '2025-05-04 10:58:40'),
	(20, 2, 699.98, '2025-05-04 11:01:05'),
	(21, 2, 399.98, '2025-05-04 11:16:54'),
	(22, 2, 949.98, '2025-05-04 11:18:00');

-- Dumping structure for table store_db.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table store_db.order_items: ~36 rows (approximately)
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
	(1, 1, 1, 1, 69.99),
	(2, 1, 4, 1, 29.99),
	(3, 2, 3, 1, 59.99),
	(4, 2, 4, 1, 29.99),
	(5, 3, 1, 1, 69.99),
	(6, 3, 3, 1, 59.99),
	(7, 3, 4, 1, 29.99),
	(8, 3, 5, 1, 49.99),
	(9, 4, 4, 1, 29.99),
	(10, 4, 5, 1, 49.99),
	(11, 4, 6, 1, 9.99),
	(12, 5, 6, 1, 9.99),
	(13, 6, 4, 1, 29.99),
	(14, 6, 6, 1, 9.99),
	(15, 7, 6, 1, 9.99),
	(16, 8, 1, 3, 69.99),
	(17, 9, 4, 1, 29.99),
	(18, 9, 5, 1, 49.98),
	(19, 9, 6, 1, 9.99),
	(20, 10, 5, 1, 49.98),
	(21, 11, 9, 1, 199.99),
	(22, 12, 9, 1, 199.99),
	(23, 13, 6, 1, 9.99),
	(24, 13, 8, 1, 449.99),
	(25, 13, 9, 1, 199.99),
	(26, 14, 9, 1, 199.99),
	(27, 15, 9, 1, 199.99),
	(28, 16, 9, 1, 199.99),
	(29, 17, 9, 1, 199.99),
	(30, 18, 9, 1, 199.99),
	(31, 19, 9, 1, 199.99),
	(32, 20, 7, 1, 499.99),
	(33, 20, 9, 1, 199.99),
	(34, 21, 9, 2, 199.99),
	(35, 22, 7, 1, 499.99),
	(36, 22, 8, 1, 449.99);

-- Dumping structure for table store_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table store_db.products: ~8 rows (approximately)
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `stock`, `created_at`) VALUES
	(1, 'EAFC 25', 'Football Game', 69.99, 'fc.jpg', 10000, '2025-04-29 00:43:35'),
	(3, 'Call Of Duty Modern Warfare 3', 'Shooter', 59.99, 'mw.png', 10000, '2025-04-29 06:52:15'),
	(4, 'GTA 5', 'Free World', 29.99, 'theft.png', 10000, '2025-04-29 06:52:47'),
	(5, 'NBA2K25', 'Basketball', 49.98, 'nba.jpg', 10000, '2025-05-01 20:45:54'),
	(6, 'Fall Guys', 'Arcade', 9.99, 'fg.jpg', 10000, '2025-05-02 02:25:22'),
	(7, 'Playstation 5', 'Console', 499.99, 'ps5.jpg', 499, '2025-05-04 06:21:41'),
	(8, 'Xbox Series X', 'Console', 449.99, 'xbox.jpg', 699, '2025-05-04 08:15:43'),
	(9, 'Gaming Monitor', '1440p 165hz', 199.99, 'monitor.png', 998, '2025-05-04 08:18:36');

-- Dumping structure for table store_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table store_db.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `is_admin`) VALUES
	(1, 'kevin.ceausu', 'kevin.ceausu@yahoo.com', '$2y$10$L/UWGHXjcnh6RsZ6DIgBxOhSXDkFSu60bdoqFKXZdU8yqldnEYBYe', '2025-04-29 06:26:25', 0),
	(2, 'admin', 'admin@yahoo.com', '$2y$10$mwOzYkpwWzdd3fgg48o/MOBXknm16HVqpovc3dyFZas4BpB3sIdW.', '2025-04-29 17:05:11', 1),
	(3, 'user', 'user@yahoo.com', '$2y$10$TCXYzuE.j9fZS0BSSgbQCu4qkQS5aSDjN1G0xaWFpV5DvTfdN3ZB.', '2025-05-04 05:30:45', 0),
	(4, 'celine.ceausu', 'celineceausu0@gmail.com', '$2y$10$GAfAjVUTQw.QGN5y95zLVeCfaubEQlZi1snNR1ppoz4WeXfMku3Oy', '2025-05-04 10:33:54', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
