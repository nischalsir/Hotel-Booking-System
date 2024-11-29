-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 11:41 AM
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
-- Database: `hotel_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(218) NOT NULL,
  `image_path` varchar(218) NOT NULL,
  `temp_password` varchar(255) DEFAULT NULL,
  `is_temp_password` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `first_name`, `last_name`, `address`, `phone`, `username`, `password`, `email`, `image_path`, `temp_password`, `is_temp_password`) VALUES
(14, 'Niranjan', 'Shah', 'Janakpur', '9815818915', 'hbs.niranja0001', '', 'sahniranjan78@gmail.com', 'uploads/admin_e0223d7e159b72373c19978718f50f1e.jpg', '$2y$10$nlBayedX9shDLIMrCxM8D.5OUD2FBKhqCkik77BpmXp//a/n3iM0W', 1),
(16, 'Tarani', 'Pant', 'Kanchanpur', '986241498', 'hbs.tarani0001', '', 'taranipant123@gmail.com', 'uploads/admin_ff93034d96019aabc04c70f237d29bc4.png', '$2y$10$yotJbrh266n2WVr8NcsggOy.ophMyT0jSskjG6G2yST0jAUwF8RLO', 1),
(20, 'Nischal', 'Pandey', 'Kirtipur Sadak\r\n17', '9865060952', 'hbs.nischal0001', '$2y$10$6RF.ZHZjbgbpFxI76Vwj7OxFD6.EBuuHZVsTVpicBcbSqA9KmgMLu', 'pandenishchal@gmail.com', 'uploads/admin_ed7b383f73cd2c445cc06f40fadb5c40.jpg', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_id` int(10) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL DEFAULT curdate(),
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `guests` int(3) NOT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

CREATE TABLE `checkouts` (
  `id` int(11) NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `checkout_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('Cash','Online') NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `is_early_checkout` tinyint(1) DEFAULT 0,
  `is_late_checkout` tinyint(1) DEFAULT 0,
  `discount_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`, `reply`) VALUES
(1, 'Nischal Pandey', 'pandenishchal@gmail.com', 'Hello! This is a test message', '2024-08-04 12:46:47', NULL),
(5, 'Tarani Pant', 'taranipant123@gmail.com', 'Hello! This is a test message.', '2024-08-04 13:11:40', 'Hello'),
(13, 'Nischal Pandey', 'pandenishchal@gmail.com', 'Hi', '2024-08-11 13:24:22', NULL),
(14, 'Nischal Pandey', 'pandenishchal@gmail.com', 'Hi', '2024-08-11 13:25:56', NULL),
(15, 'Rajesh Gyawali', 'pandenishchal@gmail.com', 'Hello', '2024-11-18 04:51:51', NULL),
(16, 'Rajesh Gyawali', 'pandenishchal@gmail.com', 'Hello', '2024-11-19 06:31:45', 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `discount_codes`
--

CREATE TABLE `discount_codes` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `discount_code` varchar(10) NOT NULL,
  `discount_percentage` int(11) NOT NULL DEFAULT 40,
  `is_used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount_codes`
--

INSERT INTO `discount_codes` (`id`, `user_email`, `discount_code`, `discount_percentage`, `is_used`, `created_at`) VALUES
(1, 'nischalsir69@gmail.com', '094A6B90', 40, 0, '2024-11-29 07:51:44'),
(2, 'nischalsir69@gmail.com', '8E697D05', 40, 1, '2024-11-29 07:52:13'),
(3, 'pandenishchal@gmail.com', '41D688A3', 40, 0, '2024-11-29 07:54:31'),
(4, 'pandenishchal@gmail.com', '33E06C76', 40, 0, '2024-11-29 07:55:36'),
(5, 'pandenishchal@gmail.com', '8C09C0EA', 40, 0, '2024-11-29 09:39:34'),
(6, 'pandenishchal@gmail.com', '5E07CEF4', 40, 0, '2024-11-29 09:43:30'),
(7, 'pandenishchal@gmail.com', '6759756E', 40, 0, '2024-11-29 09:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_email`, `rating`, `comment`, `created_at`) VALUES
(26, 'pandenishchal@gmail.com', 4, 'Accc', '2024-11-29 05:45:16'),
(27, 'pandenishchal@gmail.com', 4, 'ss', '2024-11-29 05:47:36'),
(28, 'pandenishchal@gmail.com', 4, 'sss', '2024-11-29 05:47:39'),
(29, 'pandenishchal@gmail.com', 5, 'ssss', '2024-11-29 05:47:42');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `availability` tinyint(1) DEFAULT 1,
  `image` varchar(218) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 2,
  `available_rooms` int(10) UNSIGNED NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_type`, `description`, `price`, `availability`, `image`, `capacity`, `available_rooms`) VALUES
(19, 'Standard Room', 'Basic and cozy', 5000.00, 1, 'images/standard-room.jpeg', 2, 3),
(20, 'Deluxe Room', 'Spacious and elegant', 8000.00, 1, 'images/deluxe-room.jpeg', 3, 2),
(21, 'Executive Room', 'Modern and premium', 12000.00, 1, 'images/executive-room.jpeg', 3, 10),
(22, 'Suite Room', 'Luxurious suite style', 20000.00, 1, 'images/suite-room.jpeg', 4, 10),
(24, 'Presidential Suite', 'Top-tier luxury', 50000.00, 1, 'images/presidential-suite.jpeg', 6, 10),
(26, 'Luxury Room', 'luxury', 22000.00, 1, 'images/luxury-room.jpeg', 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(700) NOT NULL,
  `shutdown` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'HBS', 'Happy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `used_discount_codes`
--

CREATE TABLE `used_discount_codes` (
  `id` int(11) NOT NULL,
  `discount_code` varchar(10) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `code` int(10) UNSIGNED NOT NULL,
  `status` varchar(10) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `terms_agreed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `code`, `status`, `profile_picture`, `gender`, `terms_agreed`) VALUES
(24, 'Nischal Pandey', 'pandenishchal@gmail.com', 9865060952, '$2y$10$t7rbtuahzqOBxQTmsLYrG.TDsEy8RSHg69s1yli7ZczFA5ZV19JpC', '2024-08-11 13:01:56', 0, 'verified', 'uploads/d151b09554b5d08c0c61e213af9bc182.jpg', 'Male', 1),
(26, 'Ashish Rawal', 'rawalashish69@gmail.com', 9865060952, '$2y$10$N3EyxBc3OO5Ig8OgDqyAROwlETXBfdqk1BSdo9XCupqUB9SNwFnAC', '2024-11-17 07:00:29', 0, 'verified', 'u.jpg', 'Male', 1),
(34, 'Niranjan Shah', 'nischalsir69@gmail.com', 9865060952, '$2y$10$RxAL/2b//59ntmzYA6kZQOwic4lnU20RjOoPM4VUB5N76JtqF2o1i', '2024-11-23 09:20:31', 0, 'verified', 'uploads/03ee786c3a60bd975e0465cfc7e09524.jpg', 'Male', 1),
(35, 'Madhu Kc', 'mkc98417@gmail.com', 1234567890, '$2y$10$ZDndyQ9PZ0P5ByIAve/7Q.XeJi5qjHvSimZOTY06nigvFMtuNo0LS', '2024-11-27 16:27:18', 0, 'verified', 'uploads/405f33b35a00e8c37f0e2f2d2bd930ed.jpg', 'Male', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_room_id` (`room_id`),
  ADD KEY `fk_user_email` (`user_email`);

--
-- Indexes for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_code` (`discount_code`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `used_discount_codes`
--
ALTER TABLE `used_discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_code` (`discount_code`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `checkouts`
--
ALTER TABLE `checkouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `used_discount_codes`
--
ALTER TABLE `used_discount_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_email` FOREIGN KEY (`user_email`) REFERENCES `usertable` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD CONSTRAINT `checkouts_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkouts_ibfk_2` FOREIGN KEY (`user_email`) REFERENCES `usertable` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD CONSTRAINT `discount_codes_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `usertable` (`email`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `usertable` (`email`);

--
-- Constraints for table `used_discount_codes`
--
ALTER TABLE `used_discount_codes`
  ADD CONSTRAINT `used_discount_codes_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `usertable` (`email`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
