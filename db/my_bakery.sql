-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2023 at 11:37 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_bakery`
--

-- --------------------------------------------------------

--
-- Table structure for table `bakeries`
--

CREATE TABLE `bakeries` (
  `id` int(11) NOT NULL,
  `bakery_name` varchar(255) NOT NULL,
  `bakery_img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bakeries`
--

INSERT INTO `bakeries` (`id`, `bakery_name`, `bakery_img`, `description`, `price`, `created_at`, `modified_at`, `is_deleted`) VALUES
(1, 'Very flacky kuasong', 'upload-20231206042833.jpg', 'kuasong from perancis', 50000, '2023-12-06 04:28:33', NULL, 0),
(2, 'Maccaron', 'upload-20231206042914.jpg', 'Maccaron from maroko', 120000, '2023-12-06 04:29:14', NULL, 0),
(3, 'Just Bread', 'upload-20231206042936.jpg', 'Just ordinary bread', 10000, '2023-12-06 04:29:36', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bakery_id` int(11) NOT NULL,
  `qty` int(100) NOT NULL,
  `total_price` int(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `bakery_id`, `qty`, `total_price`, `created_at`, `modified_at`, `is_complete`, `is_deleted`) VALUES
(1, 8, 2, 2, 240000, '2023-12-10 13:36:57', '2023-12-12 11:31:49', 1, 0),
(2, 8, 4, 2, 240000, '2023-12-10 13:41:42', '2023-12-12 11:31:49', 1, 0),
(3, 7, 3, 2, 20000, '2023-12-11 16:45:13', '2023-12-12 11:30:34', 1, 1),
(4, 7, 2, 2, 240000, '2023-12-11 16:52:18', '2023-12-12 11:31:49', 1, 1),
(5, 7, 2, 1, 120000, '2023-12-12 10:25:21', '2023-12-12 11:31:49', 1, 1),
(6, 7, 3, 1, 10000, '2023-12-12 10:25:28', '2023-12-12 11:30:34', 1, 1),
(7, 7, 2, 2, 240000, '2023-12-12 13:22:02', NULL, 1, 0),
(8, 7, 3, 1, 10000, '2023-12-12 13:22:17', NULL, 1, 0),
(9, 8, 1, 2, 100000, '2023-12-13 08:33:49', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `status_order` enum('cancel','in process','shipping','done') NOT NULL DEFAULT 'in process',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `status_order`, `created_at`) VALUES
(1, 7, 1, 'shipping', '2023-12-12 16:58:58'),
(2, 8, 7, 'shipping', '2023-12-13 10:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `bakery_id` int(11) NOT NULL,
  `qty` int(100) NOT NULL,
  `subtotal` int(255) NOT NULL,
  `total_price` int(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `bakery_id`, `qty`, `subtotal`, `total_price`, `created_at`, `modified_at`) VALUES
(1, 1, 2, 2, 250000, 265000, '2023-12-12 16:58:58', NULL),
(2, 1, 3, 1, 250000, 265000, '2023-12-12 16:58:58', NULL),
(3, 2, 1, 2, 100000, 115000, '2023-12-13 10:21:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_img` varchar(255) NOT NULL,
  `submitted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`id`, `order_id`, `user_id`, `payment_img`, `submitted_at`) VALUES
(1, 1, 7, 'receipt-1120231212101955.jpg', '2023-12-12 10:19:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role`, `created_at`, `modified_at`) VALUES
(1, '', 'admin@exp.com', 'admin', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'admin', '2023-12-04 07:28:33', NULL),
(2, '', 'jhon@exp.com', 'jhon1', '$2y$10$UBfcSx3kIcdg1yXacmyYcewP2kBcgOCR/A0y24yBEmQJ2JX.0bB9i', 'user', '2023-12-07 13:48:09', NULL),
(3, '', 'teguh@exp.com', 'test', '$2y$10$nO14tXgze5JrCiWWmB/7EeSLPbKiyRMi9RYVGcoW32SewmJx6pPwC', 'user', '2023-12-07 13:48:36', NULL),
(4, '', 'test@exp.com', 'rara', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', '2023-12-07 17:41:38', NULL),
(5, 'jhon smith', 'jon', 'jon', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', '2023-12-08 13:17:36', NULL),
(7, 'katarina', 'karina@exp.com', 'karina@exp.com', '1a6262506caed6d26e7306efca90800b5a10afda9f9209afac52b01510f28d46', 'user', '2023-12-08 13:23:37', '2023-12-08 18:20:33'),
(8, NULL, 'amir@exp.com', 'amir', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', '2023-12-10 13:38:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `full_address` text NOT NULL,
  `postal_code` int(11) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `fullname`, `city`, `full_address`, `postal_code`, `phone_number`, `is_default`, `created_at`, `modified_at`, `is_deleted`) VALUES
(1, 7, 'Karina almahera', 'Bogor', 'jl hayam wuruk', 344324, '081123124', 1, '2023-12-10 07:43:53', '2023-12-10 13:20:15', 0),
(2, 7, 'jhon smith', 'bogor', 'air mancur bogor', 16960, '82102020', 0, '2023-12-10 07:45:00', '2023-12-10 09:22:34', 0),
(3, 7, 'Darwin', 'Jakarta', 'jl marthadinata no 10', 9887, '09877689', 0, '2023-12-11 17:42:05', '0000-00-00 00:00:00', 0),
(4, 8, 'joko sanono', 'Bogor', 'Jalan taruma ledeng barat ciputat', 16630, '09823237', 0, '2023-12-13 09:12:32', '0000-00-00 00:00:00', 1),
(5, 8, 'KOKO sanoso', 'bogor', 'kp sumedang rt1011 jl cilubang', 18830, '09873823', 1, '2023-12-13 09:19:49', '0000-00-00 00:00:00', 0),
(6, 8, 'Koko sasono', 'Jakarta', 'jl marthadinata no 2', 12000, '09878732', 0, '2023-12-13 10:10:01', '0000-00-00 00:00:00', 1),
(7, 8, 'Teguh Satria', 'Bogor', 'kp melayu kecamatan jagakarsa rt 20', 23123213, '232324324', 0, '2023-12-13 10:19:56', '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bakeries`
--
ALTER TABLE `bakeries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bakeries`
--
ALTER TABLE `bakeries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
