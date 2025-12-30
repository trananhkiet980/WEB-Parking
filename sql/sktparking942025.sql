-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 09, 2025 lúc 06:18 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sktparking`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookingextensions`
--

CREATE TABLE `bookingextensions` (
  `extension_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `added_hours` int(11) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `payment_method` enum('balance','momo','bank') NOT NULL,
  `extended_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookingextensions`
--

INSERT INTO `bookingextensions` (`extension_id`, `booking_id`, `added_hours`, `fee`, `payment_method`, `extended_at`) VALUES
(37, 25, 1, 10.00, 'balance', '2025-04-08 10:51:44'),
(38, 25, 1, 10.00, 'balance', '2025-04-08 10:51:53'),
(39, 25, 1, 10.00, 'balance', '2025-04-08 10:53:48'),
(40, 25, 1, 10.00, 'balance', '2025-04-08 10:54:12'),
(41, 25, 1, 10.00, 'balance', '2025-04-08 10:54:14'),
(42, 25, 1, 10.00, 'balance', '2025-04-08 10:55:00'),
(43, 25, 1, 10.00, 'balance', '2025-04-08 10:55:07'),
(44, 25, 1, 10.00, 'balance', '2025-04-08 10:55:10'),
(45, 25, 1, 10.00, 'balance', '2025-04-08 10:55:40'),
(46, 25, 1, 10.00, 'balance', '2025-04-08 10:55:42'),
(52, 25, 1, 10.00, 'balance', '2025-04-08 11:21:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parking_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `duration_hours` int(11) NOT NULL,
  `pricePerHour` int(100) NOT NULL,
  `status` enum('active','cancelled','completed') DEFAULT 'active',
  `total_fee` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `parking_id`, `start_time`, `duration_hours`, `pricePerHour`, `status`, `total_fee`, `created_at`, `end_time`) VALUES
(25, 1, 8, '2025-04-08 15:51:30', 10, 10, 'completed', 10.00, '2025-04-08 10:51:30', '2025-04-09 03:51:30'),
(27, 1, 1, '2025-04-09 10:29:58', 1, 10, 'completed', 10.00, '2025-04-09 05:29:58', '2025-04-09 13:29:58'),
(28, 1, 1, '2025-04-09 10:30:37', 1, 10, 'completed', 10.00, '2025-04-09 05:30:37', '2025-04-09 13:30:37'),
(29, 1, 1, '2025-04-09 10:31:52', 1, 10, 'completed', 10.00, '2025-04-09 05:31:52', '2025-04-09 13:31:52'),
(42, 1, 6, '2025-04-09 15:32:41', 1, 10, 'completed', 10.00, '2025-04-09 10:32:41', '2025-04-09 18:32:41'),
(51, 1, 6, '2025-04-09 15:59:43', 4, 10, 'cancelled', 40.00, '2025-04-09 15:59:43', '2025-04-10 02:59:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `parking_lots`
--

CREATE TABLE `parking_lots` (
  `parking_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `pricePerHour` int(50) NOT NULL,
  `operating_hours` varchar(50) NOT NULL,
  `status` enum('available','full') DEFAULT 'available',
  `image_url` varchar(255) DEFAULT './img/macdinhbaixe.jpg',
  `district` varchar(255) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `occupied_slots` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `parking_lots`
--

INSERT INTO `parking_lots` (`parking_id`, `name`, `address`, `capacity`, `pricePerHour`, `operating_hours`, `status`, `image_url`, `district`, `latitude`, `longitude`, `occupied_slots`) VALUES
(1, 'Tân Quy 1', '123 Đường Tân Quy, Quận 7, TP.HCM', 150, 10, '24/7', 'available', './img/tan-quy-1.jpg', 'quan7', 10.738, 106.705, 10),
(2, 'Phú Mỹ Hưng', '456 Nguyễn Lương Bằng, Phú Mỹ Hưng, Quận 7', 100, 15, '6:00 - 22:00', 'available', './img/phu-my-hung.jpg', 'quan7', 10.737, 106.719, 15),
(3, 'Crescent Mall', '101 Tôn Dật Tiên, Phú Mỹ Hưng, Quận 7', 200, 8, '24/7', 'available', './img/crescent-mall.jpg', 'quan7', 10.732, 106.721, 50),
(4, 'Sunrise City', '23 Nguyễn Hữu Thọ, Quận 7, TP.HCM', 120, 12, '5:00 - 23:00', 'full', './img/sunrise-city.jpg', 'quan7', 10.746, 106.71, 120),
(5, 'Vivo City', '1058 Nguyễn Văn Linh, Quận 7, TP.HCM', 250, 15, '9:00 - 22:00', 'full', './img/vivo-city.jpg', 'quan7', 10.729, 106.707, 250),
(6, 'Lotte Mart', '469 Nguyễn Hữu Thọ, Quận 7, TP.HCM', 180, 10, '8:00 - 22:00', 'available', './img/lotte-mart.jpg', 'quan7', 10.761, 106.704, 10),
(7, 'Lý Thường Kiệt', '456 Đường Lý Thường Kiệt, Quận Tân Bình, TP.HCM', 100, 15, '6:00-22:00', 'full', './img/macdinhbaixe.jpg', 'tanbinh', 10.795, 106.665, 100),
(8, 'Tân Quy 2', '124 Đường Tân Quy, Quận 7, TP.HCM', 150, 10, 'available', 'available', '', 'quan7', 10.739, 106.706, 10),
(9, 'Tân Quy 3', '125 Đường Tân Quy, Quận 7, TP.HCM', 150, 10, 'available', 'available', '', 'quan7', 10.74, 106.707, 10);

--
-- Bẫy `parking_lots`
--
DELIMITER $$
CREATE TRIGGER `update_status_before_insert` BEFORE INSERT ON `parking_lots` FOR EACH ROW BEGIN
    -- Kiểm tra occupied_slots <= capacity
    IF NEW.occupied_slots > NEW.capacity THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Số chỗ đã chiếm không thể vượt quá dung lượng!';
    END IF;
    -- Cập nhật status
    IF NEW.occupied_slots = NEW.capacity THEN
        SET NEW.status = 'full';
    ELSE
        SET NEW.status = 'available';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_status_before_update` BEFORE UPDATE ON `parking_lots` FOR EACH ROW BEGIN
    -- Kiểm tra occupied_slots <= capacity
    IF NEW.occupied_slots > NEW.capacity THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Số chỗ đã chiếm không thể vượt quá dung lượng!';
    END IF;
    -- Cập nhật status
    IF NEW.occupied_slots = NEW.capacity THEN
        SET NEW.status = 'full';
    ELSE
        SET NEW.status = 'available';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_accounts`
--

CREATE TABLE `user_accounts` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT 'default-avatar.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_verification_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_accounts`
--

INSERT INTO `user_accounts` (`user_id`, `username`, `email`, `password`, `full_name`, `phone`, `address`, `profile_pic`, `created_at`, `email_verified_at`, `email_verification_token`) VALUES
(1, 'admin', 'admin@SKTParking.com', '$2y$10$/cIjxLkTLZgYWSjVwVXIEObpqYl1kxJmsuNE0PTeJguMDqyymcGa2', 'SKTParkingdaddawdadawdwadawdawdaw', '1234567888', 'dawddadawdaddaw', 'default_profile.jpg', '2025-03-14 00:05:12', '2025-04-09 08:20:11', NULL),
(18, 'trananhkiet31102005', 'trananhkiet31102005@gmail.com', '$2y$10$uUYn8CKh2/gK7zOQ0MUkauh1mIEv44dCStROrS5GpraFCbnT/0TTK', '', '', '', 'default_profile.jpg', '2025-04-09 13:29:23', '2025-04-09 08:31:25', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookingextensions`
--
ALTER TABLE `bookingextensions`
  ADD PRIMARY KEY (`extension_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parking_id` (`parking_id`);

--
-- Chỉ mục cho bảng `parking_lots`
--
ALTER TABLE `parking_lots`
  ADD PRIMARY KEY (`parking_id`);

--
-- Chỉ mục cho bảng `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookingextensions`
--
ALTER TABLE `bookingextensions`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `parking_lots`
--
ALTER TABLE `parking_lots`
  MODIFY `parking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookingextensions`
--
ALTER TABLE `bookingextensions`
  ADD CONSTRAINT `bookingextensions_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`parking_id`) REFERENCES `parking_lots` (`parking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
