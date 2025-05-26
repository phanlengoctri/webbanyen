-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 08:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buuyen`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `avatar` varchar(255) DEFAULT 'image/avartardefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `first_name`, `last_name`, `phone`, `birthdate`, `username`, `password`, `role`, `avatar`) VALUES
(3, '', '', '', NULL, 'user123', '$2y$10$JouTyiEUC9I/WBtWx0xOT.oy7tYr19Dh7pBH1ttvq/K7Stbf.IXBm', 'user', '../image/avatars/avatar3.jpg'),
(4, '', '', '', NULL, 'admin123', '$2y$10$I/61pewTjsqDSz/zjTYVSODWJKnx3680NyUgf4J.6KFUy4lEHQZwu', 'admin', '../image/avatars/avartardefault.png'),
(5, 'Đào', 'Hoàng', '0775806082', '2024-11-13', 'user1', '$2y$10$dCn/YN86u/iyOFEkiMiD5.VFoUOHdwQc284hELSViR2Xe9SzXX/O2', 'user', '../image/avatars/avatar3.jpg'),
(6, '<br /><b>Warning</b>:  Undefined array key ', '<br /><b>Warning</b>:  Undefined array key ', '<br /><b>Warning</b>', '0000-00-00', 'user2', '$2y$10$khqzB/nmzjHgzEzkF09un.nHTV/oJChvRP.R4Ba8WJj/ymMy6Br/y', 'user', '../image/avatars/default_avatar.png'),
(7, 'Dieu', 'Ngoc', '076733304344', '2024-11-07', 'user3', '$2y$10$Fz1KRCbeSepdfgyW1UBJS..1WWyfpperaXRoyZKrRfc5e8.jxDfgi', 'user', '../image/avatars/default_avatar.png'),
(8, 'Đào', 'Hoàng', '0775806082', '2024-11-07', 'user1234', '$2y$10$tIGj1qKQHVwkgnqqhn13YO67YLt8UmybHDb6z4MGqamUZgdo3Sgey', 'user', '../image/avatars/avatar2.jpg'),
(9, 'Hoàng', 'Ngoc', '076733304344', '2024-11-29', 'user4', '$2y$10$3W/CXKqVwVkNkGwz7WK7ruSiGEk4aO.k1BT4.83egJxzdVY74pV/y', 'user', '../image/avartars/avartardefault.png'),
(10, 'Dieu', 'Duong', '077676666', '2024-11-06', 'user5', '$2y$10$ABFO9el5pnz1Ii6WGFb7LehqBHFJ/zl88.I6qK1kxpZtl9DPKLdSS', 'user', '../image/avatars/avatar3.jpg'),
(11, 'hoang123', 'hoang', '076733304344', '2024-11-30', 'hoang2', '$2y$10$a6FvG2yt5zpKM9vuKBUwt.VKePNJ7DRga6zc4BLZ2xNnlLSoRMnty', 'user', '../image/avatars/avartardefault.png');

-- --------------------------------------------------------

--
-- Table structure for table `mooncake`
--

CREATE TABLE `mooncake` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mooncake`
--

INSERT INTO `mooncake` (`id`, `name`, `price`, `description`, `image`) VALUES
(1, 'BTT Yến Sào Hạt Sen – Hạnh Nhân – Saffron', 155000.00, 'Loại bánh: Bánh nướng – Bánh trung thu nhân ngọt\r\nHương vị: Yến sào – hạt sen – hạnh nhân – macca\r\nTrọng lượng: 120gr\r\nHạn sử dụng: 60 ngày kể từ ngày sản xuất', '../uploads/6733a0f836cca-mooncake1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `payment_method`, `total_amount`, `status`, `created_at`, `user_id`) VALUES
(1, 'ĐÀO MINH KHẢI HOÀNG', 'hoang.2174802010277@vanlanguni.vn', '0775806082', 'usa', 'Tiền mặt', 13500000.00, 'Completed', '2024-11-11 08:33:39', NULL),
(2, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:35:49', NULL),
(3, 'Dương Ngọc Diệu', 'quoclam2200@gmail.com', '0921877974', 'usa 3', 'Tiền mặt', 3600000.00, 'Processing', '2024-11-11 08:38:22', NULL),
(4, 'hoc nha', 'ngocdieuduong9597@gmail.com', '0921877974', 'usa', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:39:29', NULL),
(5, 'Strawberry Cakes', 'ngocdieuduong9597@gmail.com', '0921877974', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:41:08', NULL),
(6, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0921877974', 'vn', 'Tiền mặt', 7200000.00, 'pending', '2024-11-11 08:43:17', NULL),
(7, 'Dương Ngọc Diệu', 'nhocvclam12@gmail.com', '0921877974', 'usa', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:46:10', NULL),
(8, 'Bánh kem bắp', 'quoclam2200@gmail.com', '0775806082', 'usa', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:46:27', NULL),
(9, 'Combo Tâm Giao', 'hoang.2174802010277@vanlanguni.vn', '0775806082', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:47:19', NULL),
(10, 'yénao', 'nhocvclam12@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:49:39', NULL),
(11, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0921877974', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:49:52', NULL),
(12, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:52:22', NULL),
(13, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 5100000.00, 'pending', '2024-11-11 08:55:17', NULL),
(14, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 08:56:09', NULL),
(15, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 4950000.00, 'pending', '2024-11-11 08:58:45', NULL),
(16, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 8700000.00, 'pending', '2024-11-11 09:00:25', NULL),
(17, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 5800000.00, 'pending', '2024-11-11 09:02:04', NULL),
(18, 'yénao', 'ngocdieuduong9597@gmail.com', '0775806082', 'usa', 'Chuyển khoản ngân hàng', 3600000.00, 'pending', '2024-11-11 09:02:23', NULL),
(19, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0921877974', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 09:03:27', NULL),
(20, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'usa', 'Tiền mặt', 36000000.00, 'pending', '2024-11-11 18:18:35', NULL),
(21, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 30600000.00, 'pending', '2024-11-11 18:44:16', 3),
(22, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 61200000.00, 'pending', '2024-11-11 18:47:59', 3),
(23, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 21450000.00, 'pending', '2024-11-11 18:53:00', 3),
(24, 'Bánh kem bắp', 'hoang.2174802010277@vanlanguni.vn', '0775806082', 'binhthanh', 'Tiền mặt', 8700000.00, 'pending', '2024-11-11 18:53:48', 3),
(25, 'Combo Tâm Giao', 'ngocdieuduong9597@gmail.com', '0921877974', 'binhthanh', 'Tiền mặt', 6600000.00, 'pending', '2024-11-11 18:54:25', 3),
(26, 'Bánh kem Socola', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-11 18:56:16', 3),
(27, 'Dương Ngọc Diệu', 'hoang.2174802010277@vanlanguni.vn', '0775806082', 'binhthanh', 'Tiền mặt', 14950000.00, 'pending', '2024-11-11 18:57:26', 3),
(28, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 3600000.00, 'pending', '2024-11-12 05:47:15', 5),
(29, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 13200000.00, 'pending', '2024-11-12 06:52:55', 5),
(30, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 10800000.00, 'pending', '2024-11-12 07:33:25', 10),
(31, 'Bánh kem bắp', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 10800000.00, 'pending', '2024-11-12 08:10:30', 8),
(32, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 155000.00, 'pending', '2024-11-12 18:56:16', 10),
(33, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 3755000.00, 'Processing', '2024-11-13 11:46:14', 3),
(34, 'Dương Ngọc Diệu', 'ngocdieuduong9597@gmail.com', '0775806082', 'binhthanh', 'Tiền mặt', 25500000.00, 'pending', '2024-11-14 06:08:17', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `quantity`) VALUES
(1, 1, 19, 'Tổ Yến Tinh Chế Baby 50g – Hộp Vuông', 1350000.00, 10),
(2, 2, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(3, 3, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(4, 4, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(5, 5, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(6, 6, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 2),
(7, 7, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(8, 8, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(9, 9, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(10, 10, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(11, 11, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(12, 12, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(13, 13, 21, 'Combo Cung Đình Thượng Hạng', 5100000.00, 1),
(14, 14, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(15, 15, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(16, 15, 19, 'Tổ Yến Tinh Chế Baby 50g – Hộp Vuông', 1350000.00, 1),
(17, 16, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(18, 16, 21, 'Combo Cung Đình Thượng Hạng', 5100000.00, 1),
(19, 17, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(20, 17, 23, 'Combo Tâm Giao', 2200000.00, 1),
(21, 18, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(22, 19, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(23, 20, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 10),
(24, 21, 21, 'Combo Cung Đình Thượng Hạng', 5100000.00, 6),
(25, 22, 21, 'Combo Cung Đình Thượng Hạng', 5100000.00, 12),
(26, 23, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 2),
(27, 23, 19, 'Tổ Yến Tinh Chế Baby 50g – Hộp Vuông', 1350000.00, 6),
(28, 23, 23, 'Combo Tâm Giao', 2200000.00, 1),
(29, 23, 24, 'Combo Cung Đình', 3950000.00, 1),
(30, 24, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(31, 24, 21, 'Combo Cung Đình Thượng Hạng', 5100000.00, 1),
(32, 25, 25, 'Combo Tâm Giao Thượng Hạng', 2650000.00, 1),
(33, 25, 24, 'Combo Cung Đình', 3950000.00, 1),
(34, 26, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(35, 27, 22, 'Tổ Yến Tinh Chế Thượng Hạng 50g – Hộp Vuông', 2300000.00, 1),
(36, 27, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(37, 27, 21, 'Combo Cung Đình Thượng Hạng', 5100000.00, 1),
(38, 27, 24, 'Combo Cung Đình', 3950000.00, 1),
(39, 28, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(40, 29, 23, 'Combo Tâm Giao', 2200000.00, 6),
(41, 30, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 3),
(42, 31, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 3),
(43, 32, 1, 'BTT Yến Sào Hạt Sen – Hạnh Nhân – Saffron', 155000.00, 1),
(44, 33, 20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 1),
(45, 33, 1, 'BTT Yến Sào Hạt Sen – Hạnh Nhân – Saffron', 155000.00, 1),
(46, 34, 21, 'Combo Cung Đình Thượng Hạng', 5100000.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`) VALUES
(20, 'Tổ Yến Tinh Chế Cao Cấp 100g – Hộp Tròn', 3600000.00, 'Sản phẩm bao gồm:\r\n\r\nTổ yến tinh chế baby 50g\r\nTáo đỏ\r\nĐường phèn\r\nHộp + túi cơ bản', '../uploads/672f36ee6b957-product2.jpg'),
(21, 'Combo Cung Đình Thượng Hạng', 5100000.00, 'Sản phẩm bao gồm:\r\n\r\nTổ yến tinh chế thượng hạng 100g\r\n01 hũ thuỷ tinh kỷ tử 50g\r\n01 hũ thuỷ tinh táo đỏ 40g\r\n01 hũ thuỷ tinh đông trùng hạ thảo 5g\r\n01 hũ long nhãn 50g\r\n01 hộp đường phèn 130g\r\nBộ hộp quà Cung Đình Thượng Hạng', '../uploads/672f375b4ff05-product3.jpg'),
(22, 'Tổ Yến Tinh Chế Thượng Hạng 50g – Hộp Vuông', 2300000.00, 'Tổ yến tinh chế thượng hạng là sản phẩm đã qua quy trình sơ chế kỹ \r\nlưỡng bằng cách làm sạch lông, bụi bẩn và các tạp chất có hại rồi sau đó được tinh chế thành sợi từ tổ yến.\r\nCác sản phẩm tổ yến tinh chế sẽ không dùng hương liệu, hoá chất và các chất bảo quản.', '../uploads/672f384f29668-product4.jpg'),
(23, 'Combo Tâm Giao', 2200000.00, 'Sản phẩm bao gồm:\r\n\r\nTổ yến tinh chế cao cấp 50g\r\n01 hũ thuỷ tinh kỷ tử 50g\r\n01 hũ thuỷ tinh táo đỏ 40g\r\n01 hũ long nhãn 50g\r\n01 hũ thuỷ tinh đông trùng hạ thảo 5g\r\n01 hộp đường phèn 130g\r\nBộ hộp quà Tâm Giao\r\nSản phẩm đi kèm hộp + túi đựng cao cấp', '../uploads/672f393cd66cf-product5.jpg'),
(24, 'Combo Cung Đình', 3950000.00, 'Sản phẩm bao gồm:\r\n\r\nTổ yến tinh chế cao cấp 100g\r\n01 hũ thuỷ tinh kỷ tử 50g\r\n01 hũ thuỷ tinh táo đỏ 40g\r\n01 hũ thuỷ tinh đông trùng hạ thảo 5g\r\n01 hũ long nhãn 50g\r\n01 hộp đường phèn 130g\r\nBộ hộp quà Cung Đình', '../uploads/672f396ba749c-product6.jpg'),
(25, 'Combo Tâm Giao Thượng Hạng', 2650000.00, 'Sản phẩm bao gồm:\r\n\r\nTổ yến tinh chế thượng hạng 50g\r\n01 hũ thuỷ tinh kỷ tử 50g\r\n01 hũ thuỷ tinh táo đỏ 40g\r\n01 hũ thuỷ tinh đông trùng hạ thảo 5g\r\n01 hũ long nhãn 50g\r\n01 hộp đường phèn 130g\r\nBộ hộp quà Tâm Giao Thượng Hạng', '../uploads/672f399c2936c-product7.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `mooncake`
--
ALTER TABLE `mooncake`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mooncake`
--
ALTER TABLE `mooncake`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
