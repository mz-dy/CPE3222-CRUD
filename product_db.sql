-- Optimized and Fixed SQL Dump for product_db

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `product_db`
--
CREATE DATABASE IF NOT EXISTS `product_db`;
USE `product_db`;

-- --------------------------------------------------------
-- Drop existing tables to start from a blank state
-- --------------------------------------------------------
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;

-- --------------------------------------------------------
-- Table structure for table `categories`
--
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--
INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Beverages'),
(2, 'Snacks'),
(3, 'Household'),
(4, 'Candy'),
(5, 'Personal Care'),
(6, 'Canned Goods'),
(7, 'Bakery'),
(8, 'Frozen'),
(9, 'Other');

-- --------------------------------------------------------
-- Table structure for table `products`
--
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--
INSERT INTO `products` (`product_id`, `product_name`, `category_id`, `price`, `stock_quantity`) VALUES
(1, 'item 1', 3, 24.00, 100),
(2, 'Chips', 2, 50.50, 30),
(3, 'Cookies', 7, 120.00, 15),
(4, 'Coca Cola', 1, 70.99, 43);

-- --------------------------------------------------------
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

COMMIT;
