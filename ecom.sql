-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2025 at 12:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Coats', '2025-08-20 10:08:41', '2025-08-21 17:06:06'),
(2, 'Shirt', '2025-08-20 10:08:41', '2025-08-20 15:31:58'),
(3, 'Shorts', '2025-08-20 10:08:42', '2025-08-20 15:32:07'),
(4, 'Skirts', '2025-08-20 10:08:42', '2025-08-21 09:32:14'),
(5, 'Crop tops', '2025-08-21 09:32:22', '2025-08-21 09:36:50'),
(6, 'Gowns', '2025-08-21 09:37:03', '2025-08-21 09:37:03'),
(7, 'Jeans', '2025-08-21 09:44:54', '2025-08-21 09:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2025_08_19_084058_add_role_to_users', 2),
(4, '2025_08_19_122107_create_category_table', 3),
(5, '2025_08_19_174727_create_products_table', 4),
(6, '2025_08_20_103853_create_orders_table', 5),
(7, '2025_08_20_115952_create_settings_table', 6),
(8, '2025_08_21_093538_add_category_idto_products', 7),
(9, '2025_08_21_111656_create_cache_table', 8),
(10, '2025_08_22_092230_create_carts_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `reference` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `payment_status`, `reference`, `created_at`, `updated_at`) VALUES
(8, 15, 21000.00, 'pending', 'feb15882-8651-4eef-8466-029b9d2bd0fb', '2025-08-22 12:50:37', '2025-08-22 12:50:37'),
(9, 15, 12000.00, 'pending', '4f6cea9c-c002-4718-802f-309714006b09', '2025-08-22 12:54:41', '2025-08-22 12:54:41'),
(10, 15, 7000.00, 'pending', '17a37c93-b007-462d-9812-d56f17f80ecd', '2025-08-22 12:55:58', '2025-08-22 12:55:58'),
(11, 15, 18000.00, 'pending', 'b7562cf4-bd48-4f48-9e38-8ee3ff9ce718', '2025-08-22 14:01:44', '2025-08-22 14:01:44'),
(12, 15, 7000.00, 'pending', 'ffc65852-756a-42f2-9412-048b902cceb1', '2025-08-23 17:01:47', '2025-08-23 17:01:47'),
(13, 15, 7000.00, 'pending', '9846e0ff-f6cf-4ea9-a7e3-269b66ac8ab2', '2025-08-23 17:05:43', '2025-08-23 17:05:43'),
(14, 6, 22000.00, 'pending', 'fed8ce49-1151-49ac-9005-4bff067af982', '2025-08-24 11:16:05', '2025-08-24 11:16:05'),
(15, 6, 7000.00, 'pending', '3b9e0aa9-3981-49ed-9490-8cee759bc031', '2025-08-24 11:18:33', '2025-08-24 11:18:33'),
(16, 6, 6000.00, 'pending', '00ccfa43-8707-43db-8228-0fc7004d8200', '2025-08-24 11:27:30', '2025-08-24 11:27:30'),
(17, 6, 6000.00, 'pending', 'd4b4519d-1576-4848-9c55-9ae4fd9519cb', '2025-08-24 11:31:45', '2025-08-24 11:31:45'),
(18, 6, 18000.00, 'pending', 'bbe399e1-c1ef-4767-bf3c-fb04e338855d', '2025-08-24 11:34:02', '2025-08-24 11:34:02'),
(19, 6, 6000.00, 'success', '2593e9cb-ca0f-4d6e-85b9-05f4ecc685c9', '2025-08-24 11:35:19', '2025-08-24 11:35:19'),
(20, 6, 6000.00, 'success', '81f191e3-e1b6-498d-88ce-244847e03e76', '2025-08-24 11:53:04', '2025-08-24 11:53:04'),
(21, 6, 7000.00, 'success', '80e70a24-fac3-4a53-861e-18593bf4ac35', '2025-08-24 12:08:27', '2025-08-24 12:08:27'),
(22, 6, 6000.00, 'success', '9cff217c-3e4f-41d3-835d-4eb5680ceadf', '2025-08-24 12:13:33', '2025-08-24 12:13:33'),
(23, 15, 5000.00, 'success', '1c700031-00db-49a7-9b38-f519a1072204', '2025-08-24 12:17:23', '2025-08-24 12:17:23'),
(24, 15, 5000.00, 'success', 'dc4eac2f-8cd5-44fc-8da0-3bbd5ee5e2fe', '2025-08-24 12:18:40', '2025-08-24 12:18:40'),
(25, 15, 9000.00, 'success', '8dfdfe5b-2ecf-4ee2-8e46-bb04efc22d7c', '2025-08-24 12:20:45', '2025-08-24 12:20:45'),
(26, 15, 5000.00, 'success', '49df5958-7d04-4d32-a88d-27abdee8ab74', '2025-08-24 12:32:14', '2025-08-24 12:32:14'),
(27, 15, 12000.00, 'success', 'fa50d9a4-c3fb-4f50-b3e4-f897685c92e8', '2025-08-24 12:34:41', '2025-08-24 12:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(12, 8, 5, 3, 7000.00, '2025-08-22 12:50:37', '2025-08-22 12:50:37'),
(13, 9, 4, 2, 6000.00, '2025-08-22 12:54:41', '2025-08-22 12:54:41'),
(14, 10, 5, 1, 7000.00, '2025-08-22 12:55:58', '2025-08-22 12:55:58'),
(15, 11, 12, 1, 9000.00, '2025-08-22 14:01:44', '2025-08-22 14:01:44'),
(16, 11, 9, 1, 9000.00, '2025-08-22 14:01:44', '2025-08-22 14:01:44'),
(17, 12, 5, 1, 7000.00, '2025-08-23 17:01:47', '2025-08-23 17:01:47'),
(18, 13, 5, 1, 7000.00, '2025-08-23 17:05:43', '2025-08-23 17:05:43'),
(19, 14, 5, 2, 7000.00, '2025-08-24 11:16:05', '2025-08-24 11:16:05'),
(20, 14, 7, 1, 8000.00, '2025-08-24 11:16:05', '2025-08-24 11:16:05'),
(21, 15, 5, 1, 7000.00, '2025-08-24 11:18:33', '2025-08-24 11:18:33'),
(22, 16, 4, 1, 6000.00, '2025-08-24 11:27:30', '2025-08-24 11:27:30'),
(23, 17, 4, 1, 6000.00, '2025-08-24 11:31:45', '2025-08-24 11:31:45'),
(24, 18, 4, 3, 6000.00, '2025-08-24 11:34:02', '2025-08-24 11:34:02'),
(25, 19, 4, 1, 6000.00, '2025-08-24 11:35:19', '2025-08-24 11:35:19'),
(26, 20, 4, 1, 6000.00, '2025-08-24 11:53:05', '2025-08-24 11:53:05'),
(27, 21, 5, 1, 7000.00, '2025-08-24 12:08:27', '2025-08-24 12:08:27'),
(28, 22, 4, 1, 6000.00, '2025-08-24 12:13:33', '2025-08-24 12:13:33'),
(29, 23, 6, 1, 5000.00, '2025-08-24 12:17:23', '2025-08-24 12:17:23'),
(30, 24, 6, 1, 5000.00, '2025-08-24 12:18:40', '2025-08-24 12:18:40'),
(31, 25, 9, 1, 9000.00, '2025-08-24 12:20:45', '2025-08-24 12:20:45'),
(32, 26, 6, 1, 5000.00, '2025-08-24 12:32:14', '2025-08-24 12:32:14'),
(33, 27, 8, 1, 12000.00, '2025-08-24 12:34:41', '2025-08-24 12:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `images`, `price`, `stock`, `category_id`, `status`, `description`, `created_at`, `updated_at`) VALUES
(4, 'Cross Shorts', '[\"1755769958_61ulXTJi-TL._UY1000_.jpg\",\"1755769958_71QS+OBgVLL._UY1000_.jpg\",\"1755769958_images (4).jpg\"]', 6000.00, 2, 3, 'trending', '<p><em><strong>Sleek Durable</strong></em> and long lasting</p>', '2025-08-21 08:52:38', '2025-08-24 12:13:33'),
(5, 'Street Wear', '[\"1755772039_9ad552a1cd03b9bfcf4ad0f4591e85cf.jpg\",\"1755772039_546ac9a74d4f0005df6cb01929b8cd93.jpg\"]', 7000.00, 5, 2, 'new', '<p data-start=\"143\" data-end=\"378\"><strong data-start=\"143\" data-end=\"168\">Classic White T-Shirt</strong><br data-start=\"168\" data-end=\"171\"><em>Made from 100% breathable cotton.</em><br data-start=\"204\" data-end=\"207\"><em>Soft, lightweight, and all-day comfortable.</em><br data-start=\"250\" data-end=\"253\"><em>Versatile design pairs with any outfit.</em><br data-start=\"292\" data-end=\"295\"><em>Durable stitching for long-lasting wear.</em><br data-start=\"335\" data-end=\"338\"><em>A wardrobe essential for every season.</em></p>', '2025-08-21 09:27:19', '2025-08-25 09:25:46'),
(6, 'Escape Poverty', '[\"1755772187_eb581969996a09feeaef256c22460cf0.jpg\",\"1755772187_Modern Streetwear Graphic Tee! Artwork.jpg\"]', 5000.00, 7, 2, 'new', '<p><strong data-start=\"608\" data-end=\"631\">Men&rsquo;s Formal Blazer</strong><br data-start=\"631\" data-end=\"634\"><em>Tailored fit for a sharp silhouette.</em><br data-start=\"670\" data-end=\"673\"><em>Premium fabric with a smooth finish.</em><br data-start=\"709\" data-end=\"712\"><em>Two-button closure with inner lining.</em><br data-start=\"749\" data-end=\"752\"><em>Perfect for business or evening events.</em><br data-start=\"791\" data-end=\"794\"><em>Elevates any outfit instantly.</em></p>', '2025-08-21 09:29:47', '2025-08-24 12:32:14'),
(7, 'Jean Coat', '[\"1755772290_0_Wy2vLzupk3Phj6Zi.jpg\",\"1755772290_49ed99d0440c65c57a8b33d3a17551d6.jpg\",\"1755772290_cfe8de3250d7f52e53bb82ed4e811fe4.jpg\"]', 8000.00, 6, 1, 'new', '<p><strong data-start=\"1983\" data-end=\"2001\">Leather Jacket</strong><br data-start=\"2001\" data-end=\"2004\"><em>Crafted from premium faux leather.</em><br data-start=\"2038\" data-end=\"2041\"><em>Zipper closure with side pockets.</em><br data-start=\"2074\" data-end=\"2077\"><em>Stylish collar for a bold look.</em><br data-start=\"2108\" data-end=\"2111\"><em>Durable and versatile for all seasons.</em><br data-start=\"2149\" data-end=\"2152\"><em>Adds edge to any outfit.</em></p>', '2025-08-21 09:31:30', '2025-08-24 11:16:05'),
(8, 'Queen Gown', '[\"1755772531_1.jpg\",\"1755772531_2.jpg\",\"1755772531_Capture.PNG\"]', 12000.00, 8, 4, 'trending', '<p><strong data-start=\"1758\" data-end=\"1781\">Summer Floral Dress</strong><br data-start=\"1781\" data-end=\"1784\"><em>Lightweight fabric ideal for warm weather.</em><br data-start=\"1826\" data-end=\"1829\"><em>Bright floral patterns for a fresh look.</em><br data-start=\"1869\" data-end=\"1872\"><em>Short sleeves with a flowy skirt.</em><br data-start=\"1905\" data-end=\"1908\"><em>Comfortable fit for day-long wear.</em><br data-start=\"1942\" data-end=\"1945\"><em>A must-have summer outfit.</em></p>', '2025-08-21 09:35:31', '2025-08-24 12:34:41'),
(9, 'Woens gown', '[\"1755772755_715e7d94-75d7-4104-aa0b-053932205c1b.jpg\",\"1755772755_b6e5b0b9cb4021d7d4ac8aa4bb254a71.jpg\"]', 9000.00, 5, 6, 'popular', '<p><strong data-start=\"1758\" data-end=\"1781\">Summer Floral Dress</strong><br data-start=\"1781\" data-end=\"1784\"><em>Lightweight fabric ideal for warm weather.</em><br data-start=\"1826\" data-end=\"1829\"><em>Bright floral patterns for a fresh look.</em><br data-start=\"1869\" data-end=\"1872\"><em>Short sleeves with a flowy skirt.</em><br data-start=\"1905\" data-end=\"1908\"><em>Comfortable fit for day-long wear.</em><br data-start=\"1942\" data-end=\"1945\"><em>A must-have summer outfit.</em></p>', '2025-08-21 09:39:15', '2025-08-24 12:20:45'),
(10, 'Ankara skirt', '[\"1755772886_10068558_300e36bc24265aae244d8228460b3195_jpegc460ea904f97f9709544e44ba69cc108.jpg\",\"1755772886_d6368b4c39663b9e1a99231b8338e896.jpg\"]', 6000.00, 16, 4, 'trending', '<p data-start=\"1527\" data-end=\"1748\"><em>High-waist design for a flattering shape. </em><em>Stretch fabric for comfort and flexibility.</em><br data-start=\"1641\" data-end=\"1644\"><em>Classic zipper and button closure. </em><em>Ankle-length cut for modern styling.</em><br data-start=\"1717\" data-end=\"1720\"><em>Perfect for everyday wear.</em></p>', '2025-08-21 09:41:26', '2025-08-21 09:41:26'),
(11, 'Skinny Jeans', '[\"1755773237_49ed99d0440c65c57a8b33d3a17551d6.jpg\",\"1755773237_ca5a204afd99a9857d42ecd3336e7b9a.jpg\"]', 4000.00, 8, 7, 'popular', '<p><strong data-start=\"481\" data-end=\"507\">Ripped Boyfriend Jeans</strong><br data-start=\"507\" data-end=\"510\"><em>Relaxed fit with stylish distressed details.&nbsp;Made from durable cotton blend fabric.</em><br data-start=\"595\" data-end=\"598\"><em>Comfortable mid-rise waistline.&nbsp;Casual yet trendy for everyday wear.</em><br data-start=\"668\" data-end=\"671\"><em>Pairs effortlessly with crop tops.</em></p>', '2025-08-21 09:47:17', '2025-08-21 09:47:17'),
(12, 'Boyfriend Jean', '[\"1755773360_1 (1).jpg\",\"1755773360_2 (1).jpg\",\"1755773360_61YsedoFgfL._UF894,1000_QL80_.jpg\"]', 9000.00, 10, 7, 'new', '<p><strong data-start=\"712\" data-end=\"742\">Classic Straight-Leg Jeans</strong><br data-start=\"742\" data-end=\"745\"><em>Timeless straight cut for all body types.&nbsp;Soft, breathable denim for lasting comfort.</em><br data-start=\"832\" data-end=\"835\"><em>Five-pocket styling with clean finish.&nbsp;Versatile for both casual and formal looks.</em><br data-start=\"919\" data-end=\"922\"><em>A must-have staple in every wardrobe.</em></p>', '2025-08-21 09:49:20', '2025-08-22 14:01:44'),
(13, 'Flared Jeans', '[\"1755773452_images (2).jpg\",\"1755773453_images (3).jpg\"]', 10000.00, 13, 7, 'new', '<p><em>Retro-inspired wide-leg design.&nbsp;Made with soft, stretchable denim.</em><br data-start=\"1053\" data-end=\"1056\"><em>High-waist fit for a flattering silhouette.&nbsp;Perfect for pairing with boots or heels.</em><br data-start=\"1142\" data-end=\"1145\"><em>Adds a bold vintage vibe to outfits.</em></p>', '2025-08-21 09:50:53', '2025-08-21 09:50:53'),
(14, 'Off-Shoulder Crop Top', '[\"1755773621_54f0b23481b69808fac8e91db96b2bd7.jpg\",\"1755773621_241fcefbb0498a8f91b73f7d8e861fcd.jpg\"]', 15000.00, 18, 5, 'new', '<p><em>Chic off-shoulder design for elegance.</em><br data-start=\"2339\" data-end=\"2342\"><em>Stretch fabric for a comfortable fit.</em><br data-start=\"2379\" data-end=\"2382\"><em>Stylish and versatile for day or night.</em><br data-start=\"2421\" data-end=\"2424\"><em>Pairs beautifully with jeans or skirts.</em><br data-start=\"2463\" data-end=\"2466\"><em>A trendy must-have for fashion lovers.</em></p>', '2025-08-21 09:53:41', '2025-08-21 09:53:41');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RbjcZdQz9T5Yasx7XzpFP2LoRyF3s6dmzyNEL3lK', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2JmMzdCNVpjTjRLR0dTeE5QNFhQTWJrUzRTbkkwSExFazlwdWIwZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MS9jYXJ0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTU7fQ==', 1756118590);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `data`, `created_at`, `updated_at`) VALUES
(1, '{\"dark_mode\":false}', '2025-08-20 11:06:57', '2025-08-20 15:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Abdulquadri Abdulsalam', 'salamsamiat45@gmail.com', '8127728104', '2025-08-18 17:01:07', '$2y$12$AAZ4DMEpN3A/LQNLWdsZd.qECt8aLBL2k5rwFjhk88t7VgROqrSBm', NULL, '2025-08-18 17:00:20', '2025-08-21 10:05:09', 'admin'),
(6, 'Money Raiser', 'moneyraiser43@gmail.com', '7082648916', '2025-08-21 10:33:02', '$2y$12$rtca92HH1I6otbzgYwkQCeVKitA0rz/GL/4RFVwR5hQxEbHIrcTPq', NULL, '2025-08-21 10:32:27', '2025-08-23 16:47:32', 'user'),
(15, 'Dickson dicky', 'officialsouthamptonacademy@gmail.com', '7082648919', '2025-08-21 11:52:20', '$2y$12$IwMt/PkW3KiglkJXU/gaWuWu9dieQ0iSNT8Yxi0KAgZ52z7iDEj8.', NULL, '2025-08-21 11:50:02', '2025-08-21 11:52:20', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_category_unique` (`category`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_reference_unique` (`reference`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
