-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2025 at 11:08 AM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saed_custom_photostack`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@example.com', 'admin', NULL, '6592a12f1aea91704108335.jpg', '$2y$10$XKhuY.532/Cg33sm/2HKZuBoaLY1gXVfta8LgGFV0mnJwGY6A5LQm', 'H0CivKVFR6Irg4MJ9xUd52lyT9JuAp9rd7d8rdPwF1mBRkSboXfriIwSavDA', NULL, '2024-01-05 16:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `read_status` tinyint(1) NOT NULL DEFAULT 0,
  `click_url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `user_id`, `title`, `read_status`, `click_url`, `created_at`, `updated_at`) VALUES
(1, 0, 'SMTP Error: Could not connect to SMTP host. Failed to connect to server', 0, '#', '2023-01-21 07:29:16', '2023-01-21 07:29:16'),
(2, 0, 'SMTP Error: Could not connect to SMTP host. Failed to connect to server', 0, '#', '2023-01-21 07:40:48', '2023-01-21 07:40:48'),
(3, 0, 'SMTP Error: Could not connect to SMTP host. Failed to connect to server', 0, '#', '2023-01-21 07:43:51', '2023-01-21 07:43:51'),
(4, 32, 'New member registered', 0, '/admin/manage/users/detail/32', '2023-03-22 04:09:55', '2023-03-22 04:09:55'),
(5, 0, 'SMTP Error: Could not connect to SMTP host. Failed to connect to server', 0, '#', '2023-03-22 04:09:57', '2023-03-22 04:09:57'),
(6, 32, 'Deposit request from testuser1', 0, '/admin/manage/deposits/details/64', '2023-05-27 02:51:35', '2023-05-27 02:51:35'),
(7, 0, 'SMTP Error: Could not connect to SMTP host. Failed to connect to server', 0, '#', '2023-05-27 02:51:35', '2023-05-27 02:51:35'),
(8, 33, 'New member registered', 0, '/admin/manage/users/detail/33', '2023-12-06 07:55:33', '2023-12-06 07:55:33'),
(9, 34, 'New member registered', 0, '/admin/manage/users/detail/34', '2023-12-18 10:58:01', '2023-12-18 10:58:01'),
(10, 34, 'New withdraw request from testuser', 0, '/admin/manage/withdrawals/details/5', '2023-12-19 09:44:06', '2023-12-19 09:44:06'),
(11, 34, 'New withdraw request from testuser', 0, '/admin/manage/withdrawals/details/6', '2023-12-19 10:19:34', '2023-12-19 10:19:34'),
(12, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/66', '2023-12-19 12:24:44', '2023-12-19 12:24:44'),
(13, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/67', '2023-12-19 12:25:48', '2023-12-19 12:25:48'),
(14, 34, 'New support ticket has opened', 0, '/admin/support/tickets/view/53', '2023-12-20 05:40:50', '2023-12-20 05:40:50'),
(15, 0, 'A new support ticket has opened ', 0, '/admin/support/tickets/view/54', '2023-12-20 12:06:19', '2023-12-20 12:06:19'),
(16, 34, 'New support ticket has opened', 0, '/admin/support/tickets/view/55', '2023-12-20 12:54:23', '2023-12-20 12:54:23'),
(17, 34, 'A new support ticket has opened ', 0, '/admin/support/tickets/view/56', '2023-12-21 12:43:51', '2023-12-21 12:43:51'),
(18, 0, 'A new support ticket has opened ', 0, '/admin/support/tickets/view/57', '2023-12-21 12:46:35', '2023-12-21 12:46:35'),
(19, 34, 'New withdraw request from testuser', 0, '/admin/manage/withdrawals/details/8', '2024-01-03 10:01:13', '2024-01-03 10:01:13'),
(20, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/69', '2024-01-03 11:19:22', '2024-01-03 11:19:22'),
(21, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/70', '2024-01-03 11:20:12', '2024-01-03 11:20:12'),
(22, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/71', '2024-01-03 11:23:30', '2024-01-03 11:23:30'),
(23, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/72', '2024-01-03 11:23:55', '2024-01-03 11:23:55'),
(24, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/73', '2024-01-03 15:11:22', '2024-01-03 15:11:22'),
(25, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/74', '2024-01-03 15:12:41', '2024-01-03 15:12:41'),
(26, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/75', '2024-01-03 15:15:00', '2024-01-03 15:15:00'),
(27, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/76', '2024-01-03 15:56:43', '2024-01-03 15:56:43'),
(28, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/77', '2024-01-03 16:03:22', '2024-01-03 16:03:22'),
(29, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/78', '2024-01-03 16:13:33', '2024-01-03 16:13:33'),
(30, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/79', '2024-01-03 16:23:54', '2024-01-03 16:23:54'),
(31, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/80', '2024-01-03 16:30:52', '2024-01-03 16:30:52'),
(32, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/81', '2024-01-03 16:57:41', '2024-01-03 16:57:41'),
(33, 35, 'New member registered', 0, '/admin/manage/users/detail/35', '2024-01-04 04:30:11', '2024-01-04 04:30:11'),
(34, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/82', '2024-01-04 04:44:45', '2024-01-04 04:44:45'),
(35, 35, 'Deposit request from testuser2', 0, '/admin/manage/deposits/details/83', '2024-01-04 04:51:53', '2024-01-04 04:51:53'),
(36, 35, 'Deposit request from testuser2', 0, '/admin/manage/deposits/details/84', '2024-01-04 05:08:05', '2024-01-04 05:08:05'),
(37, 35, 'Deposit request from testuser2', 0, '/admin/manage/deposits/details/85', '2024-01-04 05:16:42', '2024-01-04 05:16:42'),
(38, 36, 'New member registered', 0, '/admin/manage/users/detail/36', '2024-01-06 10:46:00', '2024-01-06 10:46:00'),
(39, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/88', '2024-01-08 10:01:57', '2024-01-08 10:01:57'),
(40, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/89', '2024-01-08 10:06:41', '2024-01-08 10:06:41'),
(41, 35, 'Deposit request from testuser2', 0, '/admin/manage/deposits/details/90', '2024-01-08 10:12:28', '2024-01-08 10:12:28'),
(42, 35, 'Deposit request from testuser2', 0, '/admin/manage/deposits/details/91', '2024-01-11 09:10:19', '2024-01-11 09:10:19'),
(43, 37, 'New member registered', 0, '/admin/manage/users/detail/37', '2025-03-01 12:33:47', '2025-03-01 12:33:47'),
(44, 34, 'Deposit request from testuser', 0, '/admin/manage/deposits/details/92', '2025-03-03 10:12:53', '2025-03-03 10:12:53'),
(45, 1, 'New member registered', 0, '/admin/manage/users/detail/1', '2025-03-03 11:01:58', '2025-03-03 11:01:58'),
(46, 2, 'New member registered', 0, '/admin/manage/users/detail/2', '2025-05-07 08:46:16', '2025-05-07 08:46:16'),
(47, 2, 'Deposit request from sasovo', 0, '/admin/manage/deposits/details/2', '2025-05-20 07:24:17', '2025-05-20 07:24:17'),
(48, 2, 'Deposit request from sasovo', 0, '/admin/manage/deposits/details/1', '2025-05-20 09:30:40', '2025-05-20 09:30:40'),
(49, 2, 'Deposit request from sasovo', 0, '/admin/manage/deposits/details/2', '2025-05-20 09:34:31', '2025-05-20 09:34:31'),
(50, 2, 'Deposit request from sasovo', 0, '/admin/manage/deposits/details/1', '2025-05-20 09:37:40', '2025-05-20 09:37:40'),
(51, 2, 'Deposit request from sasovo', 0, '/admin/manage/deposits/details/1', '2025-05-20 09:43:24', '2025-05-20 09:43:24'),
(52, 2, 'Deposit request from sasovo', 0, '/admin/manage/deposits/details/1', '2025-05-20 10:32:27', '2025-05-20 10:32:27'),
(53, 2, 'Deposit request from sasovo', 0, '/admin/manage/deposits/details/3', '2025-05-20 11:42:45', '2025-05-20 11:42:45'),
(54, 1, 'New withdraw request from testuser', 0, '/admin/manage/withdrawals/details/1', '2025-05-20 15:55:30', '2025-05-20 15:55:30'),
(55, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/4', '2025-05-29 14:04:54', '2025-05-29 14:04:54'),
(56, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/6', '2025-05-29 14:10:52', '2025-05-29 14:10:52'),
(57, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/7', '2025-05-29 14:13:06', '2025-05-29 14:13:06'),
(58, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/1', '2025-05-29 14:47:30', '2025-05-29 14:47:30'),
(59, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/2', '2025-05-29 14:49:39', '2025-05-29 14:49:39'),
(60, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/3', '2025-05-29 14:57:24', '2025-05-29 14:57:24'),
(61, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/4', '2025-05-29 14:58:53', '2025-05-29 14:58:53'),
(62, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/5', '2025-05-31 12:40:46', '2025-05-31 12:40:46'),
(63, 2, 'Payment request from sasovo', 0, '/admin/manage/deposits/details/6', '2025-05-31 12:42:13', '2025-05-31 12:42:13'),
(64, 3, 'Payment request from naira', 0, '/admin/manage/deposits/details/9', '2025-06-17 20:52:28', '2025-06-17 20:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_password_resets`
--

INSERT INTO `admin_password_resets` (`id`, `email`, `token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin@example.com', '812324', 1, '2024-01-05 04:33:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` int(10) UNSIGNED NOT NULL,
  `neighborhood_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `year_built` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `units` varchar(40) NOT NULL,
  `stories` varchar(40) NOT NULL,
  `zip_url` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `address` varchar(150) NOT NULL,
  `description` longtext NOT NULL,
  `copyright_description` longtext NOT NULL,
  `claim` tinyint(4) NOT NULL COMMENT ' 1 = admin , 2 = user ',
  `claim_by` int(11) NOT NULL DEFAULT 0 COMMENT ' here user contributor id',
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `neighborhood_id`, `name`, `year_built`, `price`, `units`, `stories`, `zip_url`, `image`, `address`, `description`, `copyright_description`, `claim`, `claim_by`, `status`, `created_at`, `updated_at`) VALUES
(2, 8, 'Uttara Squre', 2025, 200.00, '15', '18', 'http://localhost/custom_photostack_2/zip_1748693484_BIQxzczK_uttara_squre.zip', '6837f97bd415b1748498811.jpg', '94 Brown St. Fort Lauderdale, FL 33319', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>', 1, 0, 1, '2025-05-29 06:06:52', '2025-05-31 12:11:24'),
(3, 1, 'Jamjam Tower', 2025, 230.00, '13', '33', 'http://localhost/custom_photostack_2/zip_1748505223_1KkM8tpM_jamjam_tower.zip', '683809257131f1748502821.jpg', '8567 NE. Andover St.Apopka, FL 32703', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 2, 1, 1, '2025-05-29 07:13:41', '2025-05-29 11:08:46'),
(4, 4, 'Yoshi Sheppard', 1988, 124.00, '65', '52', 'http://localhost/custom_photostack_2/zip_1748505511_pI1ilHco_yoshi_sheppard.zip', '683813a7b48101748505511.jpg', 'Sint veritatis aliq', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 1, 0, 1, '2025-05-29 07:58:31', '2025-05-29 07:58:31'),
(5, 12, 'Maggie Mccall', 1993, 376.00, '5', '96', 'http://localhost/custom_photostack_2/zip_1748515233_ipGm7Lma_maggie_mccall.zip', '6838259baf4131748510107.png', 'Molestiae maiores se', '<p>zfdgz</p>', '<p>zfgzdfg</p>', 1, 0, 1, '2025-05-29 09:15:07', '2025-05-31 12:36:35'),
(6, 6, 'Nipson Tower', 2025, 150.00, '50', '22', 'http://localhost/custom_photostack_2/zip_1748515761_RdoRq7rp_nipson_tower.zip', '68383bb1a95431748515761.jpg', 'Eisenbahnstrasse 35, Ravensburg, Baden-Württemberg, 88212 germany', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 2, 0, 1, '2025-05-29 10:49:22', '2025-05-29 11:51:06'),
(7, 9, 'Rafael Case', 1974, 40.00, '49', '42', 'http://localhost/custom_photostack_2/zip_1748693862_QY9loVO3_rafael_case.zip', '683af3669af381748693862.jpg', 'Eaque voluptate accu', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 1, 0, 1, '2025-05-31 12:17:42', '2025-05-31 12:17:42'),
(8, 1, 'Phillip Good', 1976, 654.00, '55', '95', 'http://localhost/custom_photostack_2/zip_1748697587_JYyh1e3k_phillip_good.zip', '683b01f38991e1748697587.jpg', 'Odio quasi esse reru', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', 1, 0, 1, '2025-05-31 13:19:47', '2025-05-31 13:19:47'),
(9, 1, 'Quinn Rodriguez', 1984, 402.00, '41', '8', 'http://localhost/custom_photostack_2/zip_1748697616_sW2jia3P_quinn_rodriguez.zip', '683b021012a401748697616.jpg', 'Nemo porro ea dolor', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', 1, 0, 1, '2025-05-31 13:20:16', '2025-05-31 13:20:35'),
(10, 1, 'Apter fab', 1976, 654.00, '55', '95', 'http://localhost/custom_photostack_2/zip_1748697587_JYyh1e3k_phillip_good.zip', '683b01f38991e1748697587.jpg', 'Odio quasi esse reru', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', 1, 0, 1, '2025-05-31 13:19:47', '2025-05-31 13:19:47'),
(11, 1, 'Joweq Tareiu', 1984, 402.00, '41', '8', 'http://localhost/custom_photostack_2/zip_1748697616_sW2jia3P_quinn_rodriguez.zip', '683b021012a401748697616.jpg', 'Nemo porro ea dolor', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', '<p>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>', 1, 0, 1, '2025-05-31 13:20:16', '2025-05-31 13:20:35'),
(12, 16, 'Onda Residences', 2025, 49.99, '49', '12', 'https://saed.wstacks.com/custom_photostack/zip_1749069153_lTW5D63C_onda_residences.zip', '6840a76bcfbea1749067627.jpg', '1135 103rd St, Bay Harbor Islands, FL 33154', '<p>Offering Ideal Spaces for Total Relaxation, With a Rooftop Pool &amp; Sundeck and Private Spa. Direct Biscayne Bay Access From <strong>Onda\'s</strong> Private Marina</p>', '<p>This image is protected by copyright and is either licensed for use through a stock photography agency or owned by its creator. Unauthorized reproduction, distribution, or modification is strictly prohibited. If you wish to use this image for commercial or editorial purposes, please ensure you have obtained the appropriate license or written permission from the copyright holder or licensing agency.</p>', 1, 0, 1, '2025-06-05 06:07:08', '2025-06-05 06:32:33'),
(13, 15, '1010 Brickell', 2025, 49.99, '400', '50', 'https://saed.wstacks.com/custom_photostack/zip_1751930180_fVLTDMvQ_1010_brickell.zip', '6849f930191b61749678384.jpg', '90 SW 3rd St\r\ncu3', '<p>des</p>', '<p>Copyright Description</p>', 1, 0, 1, '2025-06-12 07:46:24', '2025-07-08 09:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `building_images`
--

CREATE TABLE `building_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED NOT NULL,
  `image_category_id` bigint(20) UNSIGNED NOT NULL,
  `userable_id` int(11) NOT NULL,
  `userable_type` varchar(5) NOT NULL,
  `storage` varchar(10) DEFAULT NULL,
  `full_path` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `building_images`
--

INSERT INTO `building_images` (`id`, `building_id`, `image_category_id`, `userable_id`, `userable_type`, `storage`, `full_path`, `image`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 'admin', 'local', NULL, '6837f9b7dacc61748498871.jpg', '2025-05-29 06:07:52', '2025-05-29 06:07:52'),
(2, 2, 1, 1, 'admin', 'local', NULL, '6837f9b7d2fa71748498871.jpg', '2025-05-29 06:07:52', '2025-05-29 06:07:52'),
(3, 2, 2, 1, 'admin', 'local', NULL, '683807adc0b511748502445.jpg', '2025-05-29 07:07:25', '2025-05-29 07:07:25'),
(7, 2, 1, 1, 'admin', 'local', NULL, '683809c9280f71748502985.jpg', '2025-05-29 07:16:25', '2025-05-29 07:16:25'),
(8, 4, 2, 1, 'admin', 'local', NULL, '683813f23d38a1748505586.jpg', '2025-05-29 07:59:46', '2025-05-29 07:59:46'),
(11, 5, 3, 1, 'user', 'local', NULL, '68382952a70e31748511058.jpg', '2025-05-29 09:30:58', '2025-05-29 09:30:58'),
(12, 3, 1, 1, 'user', 'local', NULL, '683874a36adba1748530339.jpg', '2025-05-29 14:52:19', '2025-05-29 14:52:19'),
(13, 3, 1, 1, 'user', 'local', NULL, '683874a3767f11748530339.jpg', '2025-05-29 14:52:19', '2025-05-29 14:52:19'),
(14, 3, 1, 1, 'user', 'local', NULL, '683874a3e73021748530339.jpg', '2025-05-29 14:52:20', '2025-05-29 14:52:20'),
(15, 2, 3, 1, 'admin', 'local', NULL, '683ad0dd83ff21748685021.jpg', '2025-05-31 09:50:22', '2025-05-31 09:50:22'),
(16, 2, 3, 1, 'admin', 'local', NULL, '683ad0dd75b281748685021.jpg', '2025-05-31 09:50:22', '2025-05-31 09:50:22'),
(17, 2, 3, 1, 'admin', 'local', NULL, '683ad0ddd849c1748685021.jpg', '2025-05-31 09:50:22', '2025-05-31 09:50:22'),
(18, 2, 3, 1, 'admin', 'local', NULL, '683ad0ddecfa81748685021.jpg', '2025-05-31 09:50:22', '2025-05-31 09:50:22'),
(19, 2, 2, 1, 'admin', 'local', NULL, '683af2fbbed6f1748693755.jpg', '2025-05-31 12:15:56', '2025-05-31 12:15:56'),
(20, 2, 2, 1, 'admin', 'local', NULL, '683af2fc4c1fe1748693756.jpg', '2025-05-31 12:15:56', '2025-05-31 12:15:56'),
(21, 2, 2, 1, 'admin', 'local', NULL, '683af2fc5c3ba1748693756.jpg', '2025-05-31 12:15:56', '2025-05-31 12:15:56'),
(22, 2, 2, 1, 'admin', 'local', NULL, '683af2fcc76bf1748693756.jpg', '2025-05-31 12:15:56', '2025-05-31 12:15:56'),
(23, 2, 3, 1, 'admin', 'local', NULL, '683af3014c18f1748693761.jpg', '2025-05-31 12:16:01', '2025-05-31 12:16:01'),
(24, 2, 3, 1, 'admin', 'local', NULL, '683af3015d0ef1748693761.jpg', '2025-05-31 12:16:01', '2025-05-31 12:16:01'),
(25, 2, 3, 1, 'admin', 'local', NULL, '683af301dea051748693761.jpg', '2025-05-31 12:16:02', '2025-05-31 12:16:02'),
(26, 2, 3, 1, 'admin', 'local', NULL, '683af302031df1748693762.jpg', '2025-05-31 12:16:02', '2025-05-31 12:16:02'),
(27, 2, 3, 1, 'admin', 'local', NULL, '683af302c477e1748693762.jpg', '2025-05-31 12:16:02', '2025-05-31 12:16:02'),
(28, 2, 3, 1, 'admin', 'local', NULL, '683af3034402c1748693763.jpg', '2025-05-31 12:16:03', '2025-05-31 12:16:03'),
(29, 2, 3, 1, 'admin', 'local', NULL, '683af3037620a1748693763.jpg', '2025-05-31 12:16:03', '2025-05-31 12:16:03'),
(30, 2, 2, 1, 'admin', 'local', NULL, '683af30bd70a41748693771.jpg', '2025-05-31 12:16:12', '2025-05-31 12:16:12'),
(31, 2, 2, 1, 'admin', 'local', NULL, '683af30bd52e31748693771.jpg', '2025-05-31 12:16:12', '2025-05-31 12:16:12'),
(32, 2, 2, 1, 'admin', 'local', NULL, '683af30c5cd581748693772.jpg', '2025-05-31 12:16:12', '2025-05-31 12:16:12'),
(33, 2, 2, 1, 'admin', 'local', NULL, '683af30ca8a331748693772.jpg', '2025-05-31 12:16:12', '2025-05-31 12:16:12'),
(34, 2, 2, 1, 'admin', 'local', NULL, '683af30d135171748693773.jpg', '2025-05-31 12:16:13', '2025-05-31 12:16:13'),
(35, 2, 2, 1, 'admin', 'local', NULL, '683af30d4309d1748693773.jpg', '2025-05-31 12:16:13', '2025-05-31 12:16:13'),
(36, 2, 1, 1, 'admin', 'local', NULL, '683af3157be1e1748693781.jpg', '2025-05-31 12:16:21', '2025-05-31 12:16:21'),
(37, 2, 1, 1, 'admin', 'local', NULL, '683af3157b3641748693781.jpg', '2025-05-31 12:16:21', '2025-05-31 12:16:21'),
(38, 2, 1, 1, 'admin', 'local', NULL, '683af315dfb9f1748693781.jpg', '2025-05-31 12:16:22', '2025-05-31 12:16:22'),
(39, 7, 1, 1, 'admin', 'local', NULL, '683af37253c001748693874.jpg', '2025-05-31 12:17:54', '2025-05-31 12:17:54'),
(40, 7, 1, 1, 'admin', 'local', NULL, '683af3730943f1748693875.jpg', '2025-05-31 12:17:55', '2025-05-31 12:17:55'),
(41, 7, 1, 1, 'admin', 'local', NULL, '683af3732e36d1748693875.jpg', '2025-05-31 12:17:55', '2025-05-31 12:17:55'),
(42, 7, 1, 1, 'admin', 'local', NULL, '683af3740d9e91748693876.jpg', '2025-05-31 12:17:56', '2025-05-31 12:17:56'),
(43, 7, 1, 1, 'admin', 'local', NULL, '683af37457ca71748693876.jpg', '2025-05-31 12:17:56', '2025-05-31 12:17:56'),
(44, 7, 1, 1, 'admin', 'local', NULL, '683af374defbf1748693876.jpg', '2025-05-31 12:17:57', '2025-05-31 12:17:57'),
(45, 7, 1, 1, 'admin', 'local', NULL, '683af375554a61748693877.jpg', '2025-05-31 12:17:57', '2025-05-31 12:17:57'),
(46, 7, 1, 1, 'admin', 'local', NULL, '683af375ab4281748693877.jpg', '2025-05-31 12:17:57', '2025-05-31 12:17:57'),
(47, 7, 1, 1, 'admin', 'local', NULL, '683af37622e101748693878.jpg', '2025-05-31 12:17:58', '2025-05-31 12:17:58'),
(48, 7, 1, 1, 'admin', 'local', NULL, '683af376700351748693878.jpg', '2025-05-31 12:17:58', '2025-05-31 12:17:58'),
(49, 7, 2, 1, 'admin', 'local', NULL, '683af379d80911748693881.jpg', '2025-05-31 12:18:02', '2025-05-31 12:18:02'),
(50, 7, 2, 1, 'admin', 'local', NULL, '683af37a7d6cb1748693882.jpg', '2025-05-31 12:18:02', '2025-05-31 12:18:02'),
(51, 7, 2, 1, 'admin', 'local', NULL, '683af37a9ab251748693882.jpg', '2025-05-31 12:18:03', '2025-05-31 12:18:03'),
(52, 7, 2, 1, 'admin', 'local', NULL, '683af37bb683c1748693883.jpg', '2025-05-31 12:18:03', '2025-05-31 12:18:03'),
(53, 7, 2, 1, 'admin', 'local', NULL, '683af37bef1c91748693883.jpg', '2025-05-31 12:18:04', '2025-05-31 12:18:04'),
(54, 7, 2, 1, 'admin', 'local', NULL, '683af37c838b21748693884.jpg', '2025-05-31 12:18:04', '2025-05-31 12:18:04'),
(55, 7, 2, 1, 'admin', 'local', NULL, '683af37cf024b1748693884.jpg', '2025-05-31 12:18:05', '2025-05-31 12:18:05'),
(56, 7, 2, 1, 'admin', 'local', NULL, '683af37d743271748693885.jpg', '2025-05-31 12:18:05', '2025-05-31 12:18:05'),
(57, 7, 2, 1, 'admin', 'local', NULL, '683af37dbc6f21748693885.jpg', '2025-05-31 12:18:05', '2025-05-31 12:18:05'),
(58, 7, 2, 1, 'admin', 'local', NULL, '683af37e02e311748693886.jpg', '2025-05-31 12:18:06', '2025-05-31 12:18:06'),
(59, 7, 3, 1, 'admin', 'local', NULL, '683af3830c0551748693891.jpg', '2025-05-31 12:18:11', '2025-05-31 12:18:11'),
(60, 7, 3, 1, 'admin', 'local', NULL, '683af38309e531748693891.jpg', '2025-05-31 12:18:11', '2025-05-31 12:18:11'),
(61, 7, 3, 1, 'admin', 'local', NULL, '683af383ad5031748693891.jpg', '2025-05-31 12:18:11', '2025-05-31 12:18:11'),
(62, 7, 3, 1, 'admin', 'local', NULL, '683af38406d531748693892.jpg', '2025-05-31 12:18:12', '2025-05-31 12:18:12'),
(63, 7, 3, 1, 'admin', 'local', NULL, '683af384684ed1748693892.jpg', '2025-05-31 12:18:12', '2025-05-31 12:18:12'),
(64, 7, 3, 1, 'admin', 'local', NULL, '683af384d88e51748693892.jpg', '2025-05-31 12:18:13', '2025-05-31 12:18:13'),
(65, 7, 3, 1, 'admin', 'local', NULL, '683af3853e1551748693893.jpg', '2025-05-31 12:18:13', '2025-05-31 12:18:13'),
(102, 12, 2, 1, 'admin', 'local', NULL, '6840aae57ea411749068517.jpg', '2025-06-05 06:21:57', '2025-06-05 06:21:57'),
(103, 12, 2, 1, 'admin', 'local', NULL, '6840aae58a3091749068517.jpg', '2025-06-05 06:21:57', '2025-06-05 06:21:57'),
(110, 12, 7, 1, 'admin', 'local', NULL, '6840ab047f4251749068548.jpg', '2025-06-05 06:22:28', '2025-06-05 06:22:28'),
(111, 12, 7, 1, 'admin', 'local', NULL, '6840ab0489ed01749068548.jpg', '2025-06-05 06:22:28', '2025-06-05 06:22:28'),
(112, 12, 7, 1, 'admin', 'local', NULL, '6840ab055cd121749068549.jpg', '2025-06-05 06:22:29', '2025-06-05 06:22:29'),
(113, 12, 7, 1, 'admin', 'local', NULL, '6840ab056947e1749068549.jpg', '2025-06-05 06:22:29', '2025-06-05 06:22:29'),
(114, 12, 7, 1, 'admin', 'local', NULL, '6840ab061bbe81749068550.jpg', '2025-06-05 06:22:30', '2025-06-05 06:22:30'),
(115, 12, 7, 1, 'admin', 'local', NULL, '6840ab0640f3c1749068550.jpg', '2025-06-05 06:22:30', '2025-06-05 06:22:30'),
(117, 12, 7, 1, 'admin', 'local', NULL, '6840ab070c29b1749068551.jpg', '2025-06-05 06:22:31', '2025-06-05 06:22:31'),
(118, 12, 7, 1, 'admin', 'local', NULL, '6840ab070a0621749068551.jpg', '2025-06-05 06:22:31', '2025-06-05 06:22:31'),
(119, 12, 7, 1, 'admin', 'local', NULL, '6840ab07ad9c51749068551.jpg', '2025-06-05 06:22:31', '2025-06-05 06:22:31'),
(120, 12, 7, 1, 'admin', 'local', NULL, '6840ab07ca06e1749068551.jpg', '2025-06-05 06:22:31', '2025-06-05 06:22:31'),
(121, 12, 7, 1, 'admin', 'local', NULL, '6840ab081cbd21749068552.jpg', '2025-06-05 06:22:32', '2025-06-05 06:22:32'),
(134, 12, 6, 1, 'admin', 'local', NULL, '6840ab9e5b0741749068702.jpg', '2025-06-05 06:25:02', '2025-06-05 06:25:02'),
(135, 12, 6, 1, 'admin', 'local', NULL, '6840ab9e5acc51749068702.jpg', '2025-06-05 06:25:02', '2025-06-05 06:25:02'),
(136, 12, 6, 1, 'admin', 'local', NULL, '6840ab9e7cfb91749068702.jpg', '2025-06-05 06:25:02', '2025-06-05 06:25:02'),
(140, 12, 1, 1, 'admin', 'local', NULL, '6840ad38a78951749069112.jpg', '2025-06-05 06:31:52', '2025-06-05 06:31:52'),
(141, 12, 1, 1, 'admin', 'local', NULL, '6840ad38a9b9b1749069112.jpg', '2025-06-05 06:31:52', '2025-06-05 06:31:52'),
(142, 12, 2, 1, 'admin', 'local', NULL, '6840ad3f9eece1749069119.jpg', '2025-06-05 06:31:59', '2025-06-05 06:31:59'),
(143, 12, 2, 1, 'admin', 'local', NULL, '6840ad3fa4db81749069119.jpg', '2025-06-05 06:31:59', '2025-06-05 06:31:59'),
(144, 12, 3, 1, 'admin', 'local', NULL, '6840ad4b70f331749069131.jpg', '2025-06-05 06:32:11', '2025-06-05 06:32:11'),
(145, 12, 3, 1, 'admin', 'local', NULL, '6840ad4b7bd0f1749069131.jpg', '2025-06-05 06:32:11', '2025-06-05 06:32:11'),
(146, 12, 3, 1, 'admin', 'local', NULL, '6840ad4c999f21749069132.jpg', '2025-06-05 06:32:13', '2025-06-05 06:32:13'),
(147, 12, 3, 1, 'admin', 'local', NULL, '6840ad4cabec71749069132.jpg', '2025-06-05 06:32:13', '2025-06-05 06:32:13'),
(148, 12, 5, 1, 'admin', 'local', NULL, '6840ad54e29181749069140.jpg', '2025-06-05 06:32:21', '2025-06-05 06:32:21'),
(149, 12, 5, 1, 'admin', 'local', NULL, '6840ad552cb181749069141.jpg', '2025-06-05 06:32:21', '2025-06-05 06:32:21'),
(150, 12, 5, 1, 'admin', 'local', NULL, '6840ad57086271749069143.jpg', '2025-06-05 06:32:23', '2025-06-05 06:32:23'),
(151, 12, 5, 1, 'admin', 'local', NULL, '6840ad572fe851749069143.jpg', '2025-06-05 06:32:23', '2025-06-05 06:32:23'),
(152, 12, 5, 1, 'admin', 'local', NULL, '6840ad584e4191749069144.jpg', '2025-06-05 06:32:24', '2025-06-05 06:32:24'),
(153, 13, 1, 1, 'admin', 'local', NULL, '6849f9496b85e1749678409.jpg', '2025-06-12 07:46:49', '2025-06-12 07:46:49'),
(154, 13, 1, 1, 'admin', 'local', NULL, '6849f949a5ffd1749678409.jpg', '2025-06-12 07:46:49', '2025-06-12 07:46:49'),
(155, 13, 1, 1, 'admin', 'local', NULL, '6849f949f0e641749678409.jpg', '2025-06-12 07:46:50', '2025-06-12 07:46:50'),
(156, 13, 1, 1, 'admin', 'local', NULL, '686c554c35cec1751930188.jpg', '2025-07-08 09:16:28', '2025-07-08 09:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT 'active = 1,\r\ndeactive = 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ai Image', '68370fd05b4d81748438992.png', 1, '2025-05-28 13:29:52', '2025-05-28 13:29:52'),
(2, 'Building Image', '683710b23d9931748439218.jpg', 1, '2025-05-28 13:30:14', '2025-05-28 13:33:38'),
(3, 'Road Image', '6837104db50dc1748439117.jpg', 1, '2025-05-28 13:31:57', '2025-05-28 13:31:57'),
(4, 'Car Building', '6837113f3a1b71748439359.jpg', 1, '2025-05-28 13:35:59', '2025-05-28 13:35:59'),
(5, 'House', '683711e97aab61748439529.jpg', 1, '2025-05-28 13:38:49', '2025-05-28 13:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `commission_logs`
--

CREATE TABLE `commission_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `level` varchar(191) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `type` varchar(40) NOT NULL,
  `details` varchar(255) NOT NULL,
  `trx` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE `counties` (
  `id` bigint(20) NOT NULL,
  `state_id` bigint(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`id`, `state_id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'Bishan', '68371477e51ea1748440183.jpg', 1, '2025-05-28 13:49:44', '2025-05-28 13:49:44'),
(2, 6, 'River Valley', '68371487e1c311748440199.jpg', 1, '2025-05-28 13:50:00', '2025-05-28 13:50:00'),
(3, 6, 'Rochor', '683714980ac581748440216.jpg', 1, '2025-05-28 13:50:16', '2025-05-28 13:50:16'),
(4, 3, 'Alachua', '6837151d574be1748440349.jpg', 1, '2025-05-28 13:52:29', '2025-05-28 13:52:29'),
(5, 3, 'Osceola', '68371569499c11748440425.jpg', 1, '2025-05-28 13:53:45', '2025-05-28 13:53:45'),
(6, 5, 'Berlin', '68371607017c41748440583.png', 1, '2025-05-28 13:56:23', '2025-05-28 13:56:23'),
(7, 5, 'Hamburg', '683716515b9b01748440657.jpg', 1, '2025-05-28 13:57:37', '2025-05-28 13:57:37'),
(8, 4, 'Cabra', '683716d79b1e51748440791.jpg', 1, '2025-05-28 13:59:51', '2025-05-28 13:59:51'),
(9, 2, 'Clayton County', '683717389cfe81748440888.jpg', 1, '2025-05-28 14:01:28', '2025-05-28 14:01:28'),
(10, 2, 'Woodford County', '683717b701c451748441015.jpg', 1, '2025-05-28 14:03:35', '2025-05-28 14:03:35'),
(11, 1, 'Molise', '6837180fe46681748441103.jpg', 1, '2025-05-28 14:05:04', '2025-05-28 14:05:04'),
(12, 3, 'Miami-Dade', '6840a6c5a5cb81749067461.jpeg', 1, '2025-06-05 06:04:21', '2025-06-05 06:04:26'),
(13, 3, 'Broward', '6842f8de3c9a31749219550.jpg', 1, '2025-06-07 00:19:10', '2025-06-07 00:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order_id` bigint(20) UNSIGNED DEFAULT 0,
  `payment_type` tinyint(4) NOT NULL COMMENT '1 = user balance add, \r\n2= payment type is order',
  `method_code` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `method_currency` varchar(40) DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amo` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `detail` text DEFAULT NULL,
  `btc_amo` varchar(255) DEFAULT NULL,
  `btc_wallet` varchar(255) DEFAULT NULL,
  `trx` varchar(40) DEFAULT NULL,
  `try` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT 0,
  `admin_feedback` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `user_id`, `order_id`, `payment_type`, `method_code`, `amount`, `method_currency`, `charge`, `rate`, `final_amo`, `detail`, `btc_amo`, `btc_wallet`, `trx`, `try`, `status`, `from_api`, `admin_feedback`, `created_at`, `updated_at`) VALUES
(1, 2, 6, 2, 1000, 200.00000000, 'BDT', 3.00000000, 110.00000000, 22330.00000000, '[{\"name\":\"Name\",\"type\":\"text\",\"value\":\"Education\"},{\"name\":\"Account Number\",\"type\":\"text\",\"value\":\"HDFFH55@#%00\"},{\"name\":\"Mobile\",\"type\":\"text\",\"value\":\"02542685253\"}]', '0', '', 'TPP7EHZGUSRV', 0, 1, 0, NULL, '2025-05-29 14:47:24', '2025-05-29 14:47:41'),
(2, 2, 7, 2, 1000, 200.00000000, 'BDT', 3.00000000, 110.00000000, 22330.00000000, '[{\"name\":\"Name\",\"type\":\"text\",\"value\":\"Video Editing\"},{\"name\":\"Account Number\",\"type\":\"text\",\"value\":\"HDFFH55@#%00\"},{\"name\":\"Mobile\",\"type\":\"text\",\"value\":\"02542685253\"}]', '0', '', 'SCA5NB1MRUT6', 0, 1, 0, NULL, '2025-05-29 14:49:31', '2025-05-29 14:51:07'),
(3, 2, 8, 2, 1000, 230.00000000, 'BDT', 3.30000000, 110.00000000, 25663.00000000, '[{\"name\":\"Name\",\"type\":\"text\",\"value\":\"Basic\"},{\"name\":\"Account Number\",\"type\":\"text\",\"value\":\"32522AS44\"},{\"name\":\"Mobile\",\"type\":\"text\",\"value\":\"02542685253\"}]', '0', '', '22WVAWNYD9JM', 0, 1, 0, NULL, '2025-05-29 14:57:19', '2025-05-29 14:57:33'),
(4, 2, 9, 2, 1000, 230.00000000, 'BDT', 3.30000000, 110.00000000, 25663.00000000, '[{\"name\":\"Name\",\"type\":\"text\",\"value\":\"Education\"},{\"name\":\"Account Number\",\"type\":\"text\",\"value\":\"32522AS44\"},{\"name\":\"Mobile\",\"type\":\"text\",\"value\":\"2542685253\"}]', '0', '', 'JDUU3N8FDGAQ', 0, 1, 0, NULL, '2025-05-29 14:58:45', '2025-05-29 14:59:08'),
(5, 2, 12, 2, 1000, 200.00000000, 'BDT', 3.00000000, 110.00000000, 22330.00000000, '[{\"name\":\"Name\",\"type\":\"text\",\"value\":\"Education\"},{\"name\":\"Account Number\",\"type\":\"text\",\"value\":\"HDFFH55@#%00\"},{\"name\":\"Mobile\",\"type\":\"text\",\"value\":\"2542685253\"}]', '0', '', 'MCMFGTBD2RBJ', 0, 1, 0, NULL, '2025-05-31 12:40:37', '2025-05-31 12:40:59'),
(6, 2, 13, 2, 1000, 200.00000000, 'BDT', 3.00000000, 110.00000000, 22330.00000000, '[{\"name\":\"Name\",\"type\":\"text\",\"value\":\"Basic\"},{\"name\":\"Account Number\",\"type\":\"text\",\"value\":\"HDFFH55@#%00\"},{\"name\":\"Mobile\",\"type\":\"text\",\"value\":\"2542685253\"}]', '0', '', '4AT4W5194NAC', 0, 3, 0, 'xvcbhxfghbfg', '2025-05-31 12:42:04', '2025-05-31 12:42:45'),
(7, 2, 14, 2, 101, 50.00000000, 'USD', 0.00000000, 1.00000000, 50.00000000, NULL, '0', '', '42AYQDKA7A94', 0, 0, 0, NULL, '2025-06-05 06:53:54', '2025-06-05 06:53:54'),
(8, 2, 15, 2, 1000, 50.00000000, 'BDT', 1.50000000, 110.00000000, 5665.00000000, NULL, '0', '', 'YYRUO8QT46AR', 0, 0, 0, NULL, '2025-06-05 06:54:04', '2025-06-05 06:54:04'),
(9, 3, 18, 2, 1000, 200.00000000, 'BDT', 3.00000000, 110.00000000, 22330.00000000, '[{\"name\":\"Name\",\"type\":\"text\",\"value\":\"Basic\"},{\"name\":\"Account Number\",\"type\":\"text\",\"value\":\"32522AS44\"},{\"name\":\"Mobile\",\"type\":\"text\",\"value\":\"2542685253\"}]', '0', '', 'PDZ9FDBZCETV', 0, 1, 0, NULL, '2025-06-17 20:52:21', '2025-06-17 20:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `script` text DEFAULT NULL,
  `shortcode` text DEFAULT NULL COMMENT 'object',
  `support` text DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Live Chat(Tawk.to)', 'Key location is shown bellow', 'chat-png.png', '<script>\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\n                        (function(){\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\n                        s1.async=true;\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\n                        s1.charset=\"UTF-8\";\n                        s1.setAttribute(\"crossorigin\",\"*\");\n                        s0.parentNode.insertBefore(s1,s0);\n                        })();\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"55\"}}', 'twak.png', 0, NULL, '2019-10-18 23:16:05', '2023-03-22 06:04:56'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha2.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}', 'recaptcha.png', 0, NULL, '2019-10-18 23:16:05', '2022-05-08 04:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `form_data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `act`, `form_data`, `created_at`, `updated_at`) VALUES
(2, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"nid_number_22\":{\"name\":\"NID Number 22\",\"label\":\"nid_number_22\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"textarea\"},\"sadfg\":{\"name\":\"sadfg\",\"label\":\"sadfg\",\"is_required\":\"optional\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"asdf\":{\"name\":\"asdf\",\"label\":\"asdf\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Test\",\"Test2\",\"Test3\"],\"type\":\"select\"},\"nid_number_226985\":{\"name\":\"NID Number 226985\",\"label\":\"nid_number_226985\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Test\",\"Test 2\",\"Test 3\"],\"type\":\"checkbox\"},\"nid_number_3333\":{\"name\":\"NID Number 3333\",\"label\":\"nid_number_3333\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Test\",\"asdf\"],\"type\":\"radio\"},\"nid_number_3333587\":{\"name\":\"NID Number 3333587\",\"label\":\"nid_number_3333587\",\"is_required\":\"optional\",\"extensions\":\"jpg,bmp,png,pdf\",\"options\":[],\"type\":\"file\"}}', '2022-03-16 01:09:49', '2022-03-17 00:02:54'),
(3, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"nid_number_226985\":{\"name\":\"NID Number 226985\",\"label\":\"nid_number_226985\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"textarea\"}}', '2022-03-16 04:32:29', '2022-03-16 04:35:32'),
(5, 'withdraw_method', '{\"nid_number_33\":{\"name\":\"NID Number 33\",\"label\":\"nid_number_33\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"textarea\"}}', '2022-03-17 00:45:35', '2022-03-17 00:53:17'),
(6, 'withdraw_method', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"textarea\"}}', '2022-03-17 00:47:04', '2022-03-17 00:47:04'),
(7, 'kyc', '{\"full_name\":{\"name\":\"Full Name\",\"label\":\"full_name\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"gender\":{\"name\":\"Gender\",\"label\":\"gender\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Male\",\"Female\",\"Others\"],\"type\":\"select\"},\"you_hobby\":{\"name\":\"You Hobby\",\"label\":\"you_hobby\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Programming\",\"Gardening\",\"Traveling\",\"Others\"],\"type\":\"checkbox\"},\"nid_photo\":{\"name\":\"NID Photo\",\"label\":\"nid_photo\",\"is_required\":\"required\",\"extensions\":\"jpg,png\",\"options\":[],\"type\":\"file\"}}', '2022-03-17 02:56:14', '2022-04-11 03:23:40'),
(8, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2022-03-21 07:53:25', '2022-03-21 07:53:25'),
(9, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2022-03-21 07:54:15', '2022-03-21 07:54:15'),
(10, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"textarea\"}}', '2022-03-21 07:55:15', '2022-03-21 07:55:22'),
(11, 'withdraw_method', '{\"nid_number_2658\":{\"name\":\"NID Number 2658\",\"label\":\"nid_number_2658\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[\"asdf\"],\"type\":\"checkbox\"}}', '2022-03-22 00:14:09', '2022-03-22 00:14:18'),
(12, 'withdraw_method', '[]', '2022-03-30 09:03:12', '2022-03-30 09:03:12'),
(13, 'withdraw_method', '{\"bank_name\":{\"name\":\"Bank Name\",\"label\":\"bank_name\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"account_name\":{\"name\":\"Account Name\",\"label\":\"account_name\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"account_number\":{\"name\":\"Account Number\",\"label\":\"account_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"}}', '2022-03-30 09:09:11', '2022-09-28 04:05:20'),
(14, 'withdraw_method', '{\"mobile_number\":{\"name\":\"Mobile Number\",\"label\":\"mobile_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"}}', '2022-03-30 09:10:12', '2022-09-29 09:55:20'),
(15, 'manual_deposit', '{\"send_from_number\":{\"name\":\"Send From Number\",\"label\":\"send_from_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"transaction_number\":{\"name\":\"Transaction Number\",\"label\":\"transaction_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"screenshot\":{\"name\":\"Screenshot\",\"label\":\"screenshot\",\"is_required\":\"required\",\"extensions\":\"jpg,jpeg,png\",\"options\":[],\"type\":\"file\"}}', '2022-03-30 09:15:27', '2022-03-30 09:15:27'),
(16, 'manual_deposit', '{\"transaction_number\":{\"name\":\"Transaction Number\",\"label\":\"transaction_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"screenshot\":{\"name\":\"Screenshot\",\"label\":\"screenshot\",\"is_required\":\"required\",\"extensions\":\"jpg,pdf,docx\",\"options\":[],\"type\":\"file\"}}', '2022-03-30 09:16:43', '2022-04-11 03:19:54'),
(17, 'manual_deposit', '[]', '2022-03-30 09:21:19', '2022-03-30 09:21:19'),
(18, 'manual_deposit', '{\"asdfasddf\":{\"name\":\"asdfasddf\",\"label\":\"asdfasddf\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2022-09-28 04:50:55', '2022-09-28 04:50:55'),
(19, 'manual_deposit', '{\"sadf\":{\"name\":\"sadf\",\"label\":\"sadf\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"textarea\"}}', '2022-09-28 05:13:04', '2022-09-28 05:13:59'),
(20, 'manual_deposit', '{\"transaction_id\":{\"name\":\"Transaction ID\",\"label\":\"transaction_id\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2023-05-27 02:50:43', '2023-05-27 02:50:43'),
(21, 'manual_deposit', '{\"name\":{\"name\":\"Name\",\"label\":\"name\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"account_number\":{\"name\":\"Account Number\",\"label\":\"account_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"mobile\":{\"name\":\"Mobile\",\"label\":\"mobile\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"}}', '2023-12-19 12:23:31', '2023-12-19 12:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_keys` varchar(40) DEFAULT NULL,
  `data_values` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"website\",\"services\",\"photostack\",\"photosell\",\"premiumphoto\"],\"description\":\"Find and purchase beautiful stock photos for any occasion. From business to personal use, discover premium images that elevate your work. Easy download, affordable pricing. Looking for the perfect photo? Browse our extensive library of stock images for sale. High-quality, affordable, and ready for immediate download!\",\"social_title\":\"PhotoStack\",\"social_description\":\"Looking for high-quality stock images? We\\u2019ve got a vast collection of premium photos for every project. Download beautiful, royalty-free images today! #StockPhotography #CreativeAssets #BuyStockPhotos. Find the perfect image for your project! Our collection of high-quality stock photos is ready to download. Whether it\\u2019s for business, blogging, or personal use, we\\u2019ve got you covered. Start browsing now! #StockPhotos #Photography #BuyPhotos\",\"image\":\"67f4f636d70da1744107062.png\"}', '2020-07-04 23:42:52', '2025-04-08 10:11:03'),
(24, 'about.content', '{\"has_image\":\"1\",\"heading\":\"Latest Newsddd\",\"subheading\":\"dddd\",\"description\":\"fdg sdfgsdf g gggddd\",\"about_icon\":\"<i class=\\\"fab fa-accusoft\\\"><\\/i>\",\"background_image\":\"60951a84abd141620384388.png\",\"about_image\":\"5f9914e907ace1603867881.jpg\"}', '2020-10-28 00:51:20', '2023-05-10 02:06:51'),
(25, 'blog.content', '{\"heading\":\"Latest News\",\"subheading\":\"------ddd\"}', '2020-10-28 00:51:34', '2023-03-21 08:44:54'),
(26, 'blog.element', '{\"has_image\":[\"1\",\"1\"],\"title\":\"This is a Blog Post\",\"description\":\"This is a Blog Post\",\"description_nic\":\"<p>This is a Blog Post<\\/p>\",\"blog_icon\":\"<i class=\\\"fab fa-accusoft\\\"><\\/i>\",\"blog_image_1\":\"5f99164f1baec1603868239.jpg\",\"blog_image_2\":\"5ff2e146346d21609752902.jpg\"}', '2020-10-28 00:57:19', '2022-09-29 10:05:34'),
(27, 'contact_us.content', '{\"title\":\"Get In Touch With Us.\",\"latitude\":\"25.197197\",\"longitude\":\"55.274376\",\"footer_short_description\":\"Explore a world of creativity with Photostock\'s vast collection of high-quality images, videos, and music.\",\"website_footer\":\"<p>2024 \\u00a9 All rights reserved by wstacks.<\\/p>\"}', '2020-10-28 00:59:19', '2024-01-11 09:07:35'),
(28, 'counter.content', '{\"heading\":\"Clients\",\"subheading\":\"Auctor gravida vestibulu\"}', '2020-10-28 01:04:02', '2022-09-28 14:02:14'),
(31, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"fab fa-facebook-f\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}', '2020-11-12 04:07:30', '2023-12-18 06:12:40'),
(33, 'feature.content', '{\"heading\":\"asdf\",\"sub_heading\":\"asdf\"}', '2021-01-03 23:40:54', '2021-01-03 23:40:55'),
(34, 'feature.element', '{\"title\":\"asdf\",\"description\":\"asdf\",\"feature_icon\":\"asdf\"}', '2021-01-03 23:41:02', '2021-01-03 23:41:02'),
(35, 'service.element', '{\"trx_type\":\"withdraw\",\"service_icon\":\"<i class=\\\"las la-highlighter\\\"><\\/i>\",\"title\":\"asdfasdf\",\"description\":\"asdfasdfasdfasdf\"}', '2021-03-06 01:12:10', '2021-03-06 01:12:10'),
(36, 'service.content', '{\"trx_type\":\"deposit\",\"heading\":\"asdf fffff\",\"subheading\":\"555\"}', '2021-03-06 01:27:34', '2022-03-30 08:07:06'),
(39, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"Elevating Real Estate Listing with Visual Excellence\",\"subheading\":\"Enhance your LISTINGS presence with stunning, consistent images in just a few clicks!\",\"button_one\":\"Get Started\",\"button_two\":\"View Pricing\",\"button_one_link\":\"#\",\"button_two_link\":\"#\",\"theme_one_banner\":\"65706b2d02f851701866285.png\",\"theme_one_shape\":\"6573fedaebd3b1702100698.png\",\"theme_two_banner\":\"6840ada9b924b1749069225.jpg\"}', '2021-05-02 06:09:30', '2025-06-05 06:35:22'),
(41, 'cookie.data', '{\"short_desc\":\"We use cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking \\\"Accept\\\", you consent to our use of cookies.\",\"description\":\"<h4><strong>GDPR, cookies and compliance&nbsp;<\\/strong><\\/h4><p>Even though cookies are mentioned only once in the GDPR,&nbsp;cookie consent&nbsp;is nonetheless a cornerstone of compliance for websites with EU-located users.<\\/p><p>This is because&nbsp;one of the most common ways for personal data to be collected and shared online is through website cookies. The GDPR sets out specific rules for the use of cookies.<\\/p><p>That\\u2019s why end-user consent to cookies is the GDPR\\u2019s most used legal basis that allows websites to process personal data and use cookies.&nbsp;<\\/p><p>&nbsp;<\\/p><p><strong>Cookie Consent Banner:<\\/strong> Implement a cookie consent banner that informs users about the use of cookies on your website. This banner should allow users to either accept or reject cookies and provide them with the option to learn more about the types of cookies used.<br><br><strong>Cookie Categories<\\/strong>: Categorize cookies used in your application. Common categories include essential, functional, analytical, and marketing cookies. This classification helps users make informed choices about which cookies they want to accept.<\\/p><p>&nbsp;<\\/p><p><strong>Consent Management<\\/strong>: Store user consent preferences in a secure manner. If a user consents to certain types of cookies, set a cookie or store the preference in your database. Make it easy for users to change their preferences at any time.<\\/p><p>&nbsp;<\\/p><p><strong>Cookie Documentation<\\/strong>: Maintain a clear and accessible cookie policy or documentation explaining the purpose of each type of cookie used, their duration, and any third-party services involved. Keep this information up-to-date.<\\/p><p>&nbsp;<\\/p><p><strong>Anonymize IP Addresses<\\/strong>: If you\'re using Google Analytics or similar tools, configure them to anonymize IP addresses. This helps protect user privacy.<\\/p><p>&nbsp;<\\/p><p><strong>Data Retention<\\/strong>: Ensure that your application doesn\'t retain user data longer than necessary. Implement automated data deletion processes to comply with GDPR\'s data minimization principle.<br><br><strong>Data Access and Portability<\\/strong>: Provide users with the ability to access their data and, if requested, export it in a machine-readable format.<\\/p><p>&nbsp;<\\/p><p><strong>Data Protection Impact Assessment (DPIA)<\\/strong>: Perform DPIAs for data processing activities that present a high risk to user privacy.<\\/p><p>&nbsp;<\\/p><p><strong>Third-Party Services<\\/strong>: Review and document the use of third-party services and their GDPR compliance. Ensure that their data processing aligns with GDPR requirements.<\\/p><p>&nbsp;<\\/p><p><strong>User Education<\\/strong>: Educate your users about their rights and your data protection practices. This could include creating a privacy policy and including links to it in your application.<\\/p>\",\"status\":1}', '2020-07-04 23:42:52', '2024-01-06 11:34:23'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<h4><strong>Introduction<\\/strong><\\/h4><p>Meticulous selection process ensures each hotel meets stringent quality standards. Whether you\\u2019re visiting for business or leisure, trust us to provide you with a stay that combines the utmost security and exceptional service.It waspopularised in the with the release of Letraset sheets containing Lorem Ipsum passages, and more recently consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam sagittis. Suspendisse pulvinar, augue ac venenatis.<\\/p><p>\\u00a0<\\/p><h4><strong>Data controller<\\/strong><\\/h4><p>Nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,condimentum, sem libero volutpat nibh, nec pellentesque velit pede quis nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce id purus.<\\/p><p>\\u00a0<\\/p><h4><strong>Data Security<\\/strong><\\/h4><p>Elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam sagittis. Suspendisse pulvinar, augue ac venenatis.<\\/p><p>\\u00a0<\\/p><p><strong>1. Usage : <\\/strong>Info commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit.<\\/p><p><strong>2. Security : <\\/strong>In enim justo,condimentum, sem libero volutpat nibh, nec pellentesque velit pede quis nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce id purus.<\\/p><p><strong>3. Purposes : <\\/strong>Tree planting is the act of planting young trees, shrubs, or other woody plants into the ground to establish new forests or enhance existing ones. It is a crucial component of environmental.<\\/p><p><strong>4. Information : <\\/strong>Commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit.<\\/p><p>\\u00a0<\\/p><h4><strong>Terms and Conditions<\\/strong><\\/h4><p>Meticulous selection process ensures each hotel meets stringent quality standards. Whether you\\u2019re visiting for business or leisure, trust us to provide you with a stay that combines the utmost security and exceptional service.It waspopularised in the with the release of Letraset sheets containing Lorem Ipsum passages, and more recently consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam sagittis. Suspendisse pulvinar, augue ac venenatis.<\\/p><p>\\u00a0<\\/p><h4><strong>Data update<\\/strong><\\/h4><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.<\\/p><p>\\u00a0<\\/p><p><strong>1. Commodo : <\\/strong>ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit.<\\/p><p><strong>2. In enim : <\\/strong>justo,condimentum, sem libero volutpat nibh, nec pellentesque velit pede quis nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce id purus.<\\/p><p><strong>3. Tree : <\\/strong>planting is the act of planting young trees, shrubs, or other woody plants into the ground to establish new forests or enhance existing ones. It is a crucial component of environmental.<\\/p><p><strong>4. Commodo : <\\/strong>ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit.<\\/p>\"}', '2021-06-09 08:50:42', '2024-01-06 11:18:28'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<h4><strong>Introduction<\\/strong><\\/h4><p>Meticulous selection process ensures each hotel meets stringent quality standards. Whether you\\u2019re visiting for business or leisure, trust us to provide you with a stay that combines the utmost security and exceptional service.It waspopularised in the with the release of Letraset sheets containing Lorem Ipsum passages, and more recently consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam sagittis. Suspendisse pulvinar, augue ac venenatis.<\\/p><p>\\u00a0<\\/p><h4><strong>Data controller<\\/strong><\\/h4><p>Nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,condimentum, sem libero volutpat nibh, nec pellentesque velit pede quis nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce id purus.<\\/p><p>\\u00a0<\\/p><h4><strong>Data Security<\\/strong><\\/h4><p>Elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam sagittis. Suspendisse pulvinar, augue ac venenatis.<\\/p><p>\\u00a0<\\/p><p><strong>1. Usage : <\\/strong>Info commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit.<\\/p><p><strong>2. Security : <\\/strong>In enim justo,condimentum, sem libero volutpat nibh, nec pellentesque velit pede quis nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce id purus.<\\/p><p><strong>3. Purposes : <\\/strong>Tree planting is the act of planting young trees, shrubs, or other woody plants into the ground to establish new forests or enhance existing ones. It is a crucial component of environmental.<\\/p><p><strong>4. Information : <\\/strong>Commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit.<\\/p><p>\\u00a0<\\/p><h4><strong>Terms and Conditions<\\/strong><\\/h4><p>Meticulous selection process ensures each hotel meets stringent quality standards. Whether you\\u2019re visiting for business or leisure, trust us to provide you with a stay that combines the utmost security and exceptional service.It waspopularised in the with the release of Letraset sheets containing Lorem Ipsum passages, and more recently consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam sagittis. Suspendisse pulvinar, augue ac venenatis.<\\/p><p>\\u00a0<\\/p><h4><strong>Data update<\\/strong><\\/h4><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.<\\/p><p>\\u00a0<\\/p><p><strong>1. Commodo : <\\/strong>ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit.<\\/p><p><strong>2. In enim : <\\/strong>justo,condimentum, sem libero volutpat nibh, nec pellentesque velit pede quis nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce id purus.<\\/p><p><strong>3. Tree : <\\/strong>planting is the act of planting young trees, shrubs, or other woody plants into the ground to establish new forests or enhance existing ones. It is a crucial component of environmental.<\\/p><p><strong>4. Commodo : <\\/strong>ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus. Donec elit.<\\/p>\"}', '2021-06-09 08:51:18', '2024-01-06 11:17:52'),
(44, 'maintenance.data', '{\"description\":\"<div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"text-align: center; font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"text-align: center; margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div>\"}', '2020-07-04 23:42:52', '2022-05-11 03:57:17'),
(45, 'feature.element', '{\"title\":\"sytry\",\"description\":\"ertyerty\",\"feature_icon\":\"<i class=\\\"fas fa-address-book\\\"><\\/i>\"}', '2022-10-17 10:23:22', '2022-10-17 10:23:22'),
(46, 'feature.element', '{\"title\":\"sytry\",\"description\":\"ertyerty\",\"feature_icon\":\"<i class=\\\"fas fa-address-book\\\"><\\/i>\"}', '2022-10-17 10:23:22', '2022-10-17 10:23:22'),
(51, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"dd\",\"description\":\"<p>ffaa<\\/p>\",\"blog_image\":\"641991bc922611679397308.png\"}', '2023-03-21 08:45:08', '2023-03-21 08:45:08'),
(52, 'category.content', '{\"heading\":\"Check Out The Top Trending Categories\",\"subheading\":\"what\\u2019s popular on Photostock and make your project look professional.\"}', '2023-12-13 07:26:23', '2023-12-13 07:28:20'),
(53, 'work_process.content', '{\"heading\":\"How To Work Photostock\",\"subheading\":\"Photostock is a great resource for both downloaders and contributors. It is easy to use and offers a wide variety of high-quality resources\"}', '2023-12-13 08:34:48', '2023-12-13 08:38:53'),
(54, 'work_process.element', '{\"has_image\":\"1\",\"title\":\"Download\",\"description\":\"<p>Click on the \\\"Download\\\" button to download the resource.<\\/p>\",\"image\":\"657972864bbf91702457990.png\"}', '2023-12-13 08:49:11', '2023-12-13 08:59:50'),
(55, 'work_process.element', '{\"has_image\":\"1\",\"title\":\"Search resources\",\"description\":\"<p>Search for the resources you need (images, vectors, videos, etc.)<\\/p>\",\"image\":\"6579728cca6df1702457996.png\"}', '2023-12-13 08:50:13', '2023-12-13 08:59:56'),
(56, 'work_process.element', '{\"has_image\":\"1\",\"title\":\"Create an account\",\"description\":\"<p>Go to the Photostock website and create an account<\\/p>\",\"image\":\"65797293d91251702458003.png\"}', '2023-12-13 08:50:39', '2023-12-13 09:00:03'),
(57, 'creative_resource.content', '{\"has_image\":\"1\",\"heading\":\"Make Your Work More Professional\",\"subheading\":\"Free accessories that allow you to organize, create and save time on your designs\",\"image\":\"657eb3a378eac1702802339.png\"}', '2023-12-17 08:38:59', '2023-12-17 08:38:59'),
(58, 'creative_resource.element', '{\"icon\":\"<i class=\\\"fas fa-piggy-bank\\\"><\\/i>\",\"title\":\"Affordable Pricing\",\"description\":\"<p>This is a very competitive price, especially when compared to other stock image<\\/p>\"}', '2023-12-17 08:42:29', '2023-12-17 08:43:14'),
(59, 'creative_resource.element', '{\"icon\":\"<i class=\\\"fas fa-folder-plus\\\"><\\/i>\",\"title\":\"Add to Collection\",\"description\":\"<p>Collections are a great way to organize your favorite resources and to find them quickly<\\/p>\"}', '2023-12-17 08:42:58', '2023-12-17 08:42:58'),
(60, 'creative_resource.element', '{\"icon\":\"<i class=\\\"fas fa-image\\\"><\\/i>\",\"title\":\"Exclusive Videos and Images\",\"description\":\"<p>Visuals you won\'t find elsewhere, from global artists who work only with us.<\\/p>\"}', '2023-12-17 08:43:54', '2023-12-17 08:43:54'),
(61, 'pricing_plan.content', '{\"heading\":\"Create Your Best Work, With The Best Royalty Content\",\"subheading\":\"224 million stock photos, world\'s largest stock community, 51 million users\"}', '2023-12-17 08:59:11', '2023-12-17 08:59:11'),
(62, 'faq.content', '{\"heading\":\"Frequently Asked Questions\",\"subheading\":\"Free accessories that allow you to organize, create and save time on your designs\",\"button_name\":\"Explore collections\",\"button_link\":\"http:\\/\\/localhost\\/photostack\\/explore\"}', '2023-12-17 09:05:47', '2025-03-03 10:01:26'),
(63, 'faq.element', '{\"question\":\"How can I get stock images to make them my own?\",\"answer\":\"<p>The cost of stock images varies depending on the website, the quality of the image, and the licensing terms. Some websites offer free stock images, while others charge a fee for individual images or subscriptions.<\\/p>\"}', '2023-12-17 09:06:33', '2023-12-17 09:09:24'),
(64, 'faq.element', '{\"question\":\"What are the benefits of using stock images?\",\"answer\":\"<p>The cost of stock images varies depending on the website, the quality of the image, and the licensing terms. Some websites offer free stock images, while others charge a fee for individual images or subscriptions.<\\/p>\"}', '2023-12-17 09:07:12', '2023-12-17 09:07:12'),
(65, 'faq.element', '{\"question\":\"Can I use stock images for commercial purposes?\",\"answer\":\"<p>The cost of stock images varies depending on the website, the quality of the image, and the licensing terms. Some websites offer free stock images, while others charge a fee for individual images or subscriptions.<\\/p>\"}', '2023-12-17 09:07:39', '2023-12-17 09:07:39'),
(66, 'faq.element', '{\"question\":\"How much do stock images cost?\",\"answer\":\"<p>The cost of stock images varies depending on the website, the quality of the image, and the licensing terms. Some websites offer free stock images, while others charge a fee for individual images or subscriptions.<\\/p>\"}', '2023-12-17 09:08:04', '2023-12-17 09:08:04'),
(67, 'faq.element', '{\"question\":\"How can I get AI generated images for free?\",\"answer\":\"<p>The cost of stock images varies depending on the website, the quality of the image, and the licensing terms. Some websites offer free stock images, while others charge a fee for individual images or subscriptions.<\\/p>\"}', '2023-12-17 09:08:30', '2023-12-17 09:08:30'),
(68, 'social_icon.element', '{\"title\":\"Twitter\",\"social_icon\":\"<i class=\\\"fab fa-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/twitter.com\\/\"}', '2023-12-18 06:14:15', '2023-12-18 06:14:15'),
(69, 'social_icon.element', '{\"title\":\"LinkedIn\",\"social_icon\":\"<i class=\\\"fab fa-linkedin-in\\\"><\\/i>\",\"url\":\"https:\\/\\/www.linkedin.com\\/\"}', '2023-12-18 06:15:57', '2023-12-18 06:15:57'),
(70, 'social_icon.element', '{\"title\":\"Instagram\",\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}', '2023-12-18 06:16:48', '2023-12-18 06:16:48'),
(71, 'visual_compilation.content', '{\"heading\":\"Create Your Best Work, With The Best Royalty Content\",\"subheading\":\"224 million stock photos, world\'s largest stock community, 51 million users\"}', '2024-01-03 04:55:20', '2024-01-03 04:55:20'),
(72, 'photo_collection.content', '{\"heading\":\"Must-See Collections To Boost Your Ideas\",\"subheading\":\"Explore Photostock trendiest collections and find the perfect visual.\"}', '2024-01-03 05:24:47', '2024-01-03 05:24:47'),
(73, 'footer_company_links.element', '{\"title\":\"Latest Fashion\",\"url\":\"https:\\/\\/preview.wstacks.com\\/photostack\\/category\\/23\"}', '2024-01-05 15:55:00', '2024-01-11 12:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `code` int(11) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `alias` varchar(40) NOT NULL DEFAULT 'NULL',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text DEFAULT NULL,
  `supported_currencies` text DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-58ira22618401@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2022-11-26 08:03:45'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"---------------------\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2022-11-26 07:50:01'),
(3, 0, 105, 'PayTM', 'Paytm', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"-----------\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"--------------------\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"example.com\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2022-11-26 08:10:37'),
(4, 0, 107, 'PayStack', 'Paystack', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"--------\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"----------------\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2022-11-26 07:49:18'),
(5, 0, 108, 'VoguePay', 'Voguepay', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"-------------------\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2022-11-26 07:50:14'),
(6, 0, 109, 'Flutterwave', 'Flutterwave', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-06-05 11:37:45'),
(7, 0, 110, 'RazorPay', 'Razorpay', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"------------\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"--------\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:51:32'),
(8, 0, 112, 'Instamojo', 'Instamojo', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"------------\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"---------\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"-------\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2022-11-26 08:00:15'),
(9, 0, 503, 'CoinPayments', 'Coinpayments', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"----------------\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2022-10-29 07:29:51'),
(10, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"---------\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"----------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2022-10-29 07:29:48'),
(11, 0, 113, 'Paypal Express', 'PaypalSdk', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"------------\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"-----------\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-20 23:01:08'),
(12, 0, 114, 'Stripe Checkout', 'StripeV3', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51M8Ks2CL65BWuH7eCBcWsLP2yPfWaLtfJVxG3zfii7cCWJE1izM4jkhucmBSm6izmVtSGZyp0JDYYCVmx9E4WmQY004gfnctzD\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51M8Ks2CL65BWuH7eju6khGxJMpeeFuw2Rwrjr8UYCz6ZnQ3PiFxb1gVu1i1dBto9MQrnjkBimHkFJgNcqsrJHTak0010kCY41h\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"abcd\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2022-12-18 08:28:03'),
(49, 21, 1000, 'ABC Bank', 'abc_bank', 1, '[]', '[]', 0, NULL, '<p>Fill Carefully</p>', '2023-12-19 12:23:31', '2023-12-19 12:23:40'),
(50, 0, 115, 'Mercado Pago', 'MercadoPago', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.MercadoPago\"}}', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `currency` varchar(40) DEFAULT NULL,
  `symbol` varchar(40) DEFAULT NULL,
  `method_code` int(11) DEFAULT NULL,
  `gateway_alias` varchar(40) DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(255) DEFAULT NULL,
  `gateway_parameter` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gateway_currencies`
--

INSERT INTO `gateway_currencies` (`id`, `name`, `currency`, `symbol`, `method_code`, `gateway_alias`, `min_amount`, `max_amount`, `percent_charge`, `fixed_charge`, `rate`, `image`, `gateway_parameter`, `created_at`, `updated_at`) VALUES
(3, 'Paypal - USD', 'USD', '$', 101, 'Paypal', 10.00000000, 1000.00000000, 0.00, 0.00000000, 1.00000000, NULL, '{\"paypal_email\":\"sb-58ira22618401@business.example.com\"}', '2023-05-27 02:54:30', '2023-05-27 02:54:30'),
(4, 'ABC Bank', 'BDT', '', 1000, 'abc_bank', 1.00000000, 10000.00000000, 1.00, 1.00000000, 110.00000000, NULL, NULL, '2023-12-19 12:23:31', '2023-12-19 12:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(40) DEFAULT NULL,
  `theme` tinyint(4) DEFAULT NULL,
  `cur_text` varchar(40) DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) DEFAULT NULL COMMENT 'currency symbol',
  `building_commission` decimal(28,2) DEFAULT NULL,
  `listing_commission` decimal(28,2) DEFAULT NULL,
  `email_from` varchar(40) DEFAULT NULL,
  `email_template` text DEFAULT NULL,
  `sms_body` varchar(255) DEFAULT NULL,
  `sms_from` varchar(255) DEFAULT NULL,
  `base_color` varchar(40) DEFAULT NULL,
  `secondary_color` varchar(40) DEFAULT NULL,
  `mail_config` text DEFAULT NULL COMMENT 'email configuration',
  `sms_config` text DEFAULT NULL,
  `global_shortcodes` text DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0,
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `force_ssl` tinyint(1) NOT NULL DEFAULT 0,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `secure_password` tinyint(1) NOT NULL DEFAULT 0,
  `agree` tinyint(1) NOT NULL DEFAULT 0,
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) DEFAULT NULL,
  `system_info` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `theme`, `cur_text`, `cur_sym`, `building_commission`, `listing_commission`, `email_from`, `email_template`, `sms_body`, `sms_from`, `base_color`, `secondary_color`, `mail_config`, `sms_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `force_ssl`, `maintenance_mode`, `secure_password`, `agree`, `registration`, `active_template`, `system_info`, `created_at`, `updated_at`) VALUES
(1, 'Photostock', 2, 'USD', '$', 5.00, 5.00, 'notify@wstacks.com', '<p>Hi {{fullname}} ({{username}}),&nbsp;</p><p>{{message}}</p>', 'Hi {{fullname}} ({{username}}), \r\n{{message}}', 'Minstack', '4ca0b6', '66b5ca', '{\"name\":\"php\"}', '{\"name\":\"messageBird\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 'default', '[]', NULL, '2025-07-11 01:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `image_categories`
--

CREATE TABLE `image_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image_categories`
--

INSERT INTO `image_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Lobby', '2025-05-03 14:02:49', '2025-06-05 06:03:07'),
(2, 'Frontage', '2025-05-05 15:45:11', '2025-06-05 06:03:01'),
(3, 'Amenities', '2025-05-08 08:19:05', '2025-06-05 06:02:54'),
(5, 'Drone Aerial', '2025-06-05 06:03:21', '2025-06-05 06:03:21'),
(6, 'Social Media', '2025-06-05 06:03:39', '2025-06-05 06:03:39'),
(7, 'Renderings', '2025-06-05 06:03:45', '2025-06-05 06:03:45'),
(8, 'Floor Plan', '2025-06-12 07:41:04', '2025-06-12 07:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `image_category_descriptions`
--

CREATE TABLE `image_category_descriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED NOT NULL,
  `image_category_id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image_category_descriptions`
--

INSERT INTO `image_category_descriptions` (`id`, `building_id`, `image_category_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>', '2025-05-29 06:09:54', '2025-05-29 07:53:39'),
(2, 2, 2, '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>', '2025-05-29 06:59:33', '2025-05-29 07:53:39'),
(3, 2, 3, '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>', '2025-05-29 06:59:33', '2025-05-31 09:50:27'),
(7, 4, 3, '<p>zfgzfdg</p>', '2025-05-29 08:13:47', '2025-05-29 09:30:20'),
(8, 4, 1, '', '2025-05-29 09:30:20', '2025-05-29 09:30:20'),
(9, 4, 2, '', '2025-05-29 09:30:20', '2025-05-29 09:30:20'),
(10, 5, 1, '', '2025-05-29 09:31:07', '2025-05-29 09:31:07'),
(11, 5, 2, '', '2025-05-29 09:31:07', '2025-05-29 09:31:07'),
(12, 5, 3, '<p>sfgjhdjghj</p>', '2025-05-29 09:31:07', '2025-05-29 09:31:07'),
(13, 3, 1, '<p>shggs</p>', '2025-05-29 14:52:25', '2025-05-29 14:52:25'),
(14, 3, 2, '', '2025-05-29 14:52:25', '2025-05-29 14:52:25'),
(15, 3, 3, '', '2025-05-29 14:52:25', '2025-05-29 14:52:25'),
(16, 7, 1, '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '2025-05-31 12:18:21', '2025-05-31 12:18:21'),
(17, 7, 2, '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '2025-05-31 12:18:21', '2025-05-31 12:18:21'),
(18, 7, 3, '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '2025-05-31 12:18:21', '2025-05-31 12:18:21'),
(19, 12, 1, '', '2025-06-05 06:16:56', '2025-06-05 06:16:56'),
(20, 12, 2, '', '2025-06-05 06:16:56', '2025-06-05 06:16:56'),
(21, 12, 3, '', '2025-06-05 06:16:56', '2025-06-05 06:16:56'),
(22, 12, 5, '', '2025-06-05 06:16:56', '2025-06-05 06:16:56'),
(23, 12, 6, '', '2025-06-05 06:16:56', '2025-06-05 06:16:56'),
(24, 12, 7, '', '2025-06-05 06:16:56', '2025-06-05 06:16:56'),
(25, 13, 1, '', '2025-07-08 09:16:36', '2025-07-08 09:16:36'),
(26, 13, 2, '', '2025-07-08 09:16:36', '2025-07-08 09:16:36'),
(27, 13, 3, '', '2025-07-08 09:16:36', '2025-07-08 09:16:36'),
(28, 13, 5, '', '2025-07-08 09:16:36', '2025-07-08 09:16:36'),
(29, 13, 6, '', '2025-07-08 09:16:36', '2025-07-08 09:16:36'),
(30, 13, 7, '', '2025-07-08 09:16:36', '2025-07-08 09:16:36'),
(31, 13, 8, '', '2025-07-08 09:16:36', '2025-07-08 09:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `code` varchar(40) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `text_align` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: left to right text align, 1: right to left text align',
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `icon`, `text_align`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '5f15968db08911595250317.png', 0, 1, '2020-07-06 03:47:55', '2022-09-29 10:36:14'),
(14, 'Spanish', 'es', NULL, 0, 0, '2023-02-15 11:06:57', '2023-02-15 11:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `listing_images`
--

CREATE TABLE `listing_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `listing_unit_id` int(10) UNSIGNED NOT NULL,
  `userable_id` int(11) NOT NULL,
  `userable_type` varchar(5) NOT NULL,
  `storage` varchar(20) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listing_images`
--

INSERT INTO `listing_images` (`id`, `listing_unit_id`, `userable_id`, `userable_type`, `storage`, `image`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 'admin', 'local', '68382438c4d101748509752.jpg', '2025-05-29 09:09:13', '2025-05-29 09:09:13'),
(6, 2, 1, 'user', 'local', '68382b1b355b71748511515.jpg', '2025-05-29 09:38:35', '2025-05-29 09:38:35'),
(18, 4, 1, 'admin', 'local', '683ad242def811748685378.jpg', '2025-05-31 09:56:19', '2025-05-31 09:56:19'),
(19, 4, 1, 'admin', 'local', '683ad24f15bd91748685391.jpg', '2025-05-31 09:56:31', '2025-05-31 09:56:31'),
(20, 5, 1, 'admin', 'local', '683af3eab64921748693994.jpg', '2025-05-31 12:19:54', '2025-05-31 12:19:54'),
(21, 5, 1, 'admin', 'local', '683af3eab75051748693994.jpg', '2025-05-31 12:19:54', '2025-05-31 12:19:54'),
(22, 5, 1, 'admin', 'local', '683af3eb176f01748693995.jpg', '2025-05-31 12:19:55', '2025-05-31 12:19:55'),
(23, 5, 1, 'admin', 'local', '683af3ef6c2c51748693999.jpg', '2025-05-31 12:19:59', '2025-05-31 12:19:59'),
(24, 5, 1, 'admin', 'local', '683af3ef8aa951748693999.jpg', '2025-05-31 12:19:59', '2025-05-31 12:19:59'),
(25, 5, 1, 'admin', 'local', '683af3efe74da1748693999.jpg', '2025-05-31 12:20:00', '2025-05-31 12:20:00'),
(26, 5, 1, 'admin', 'local', '683af3f00f9d41748694000.jpg', '2025-05-31 12:20:00', '2025-05-31 12:20:00'),
(27, 5, 1, 'admin', 'local', '683af3f0a33f21748694000.jpg', '2025-05-31 12:20:00', '2025-05-31 12:20:00'),
(28, 5, 1, 'admin', 'local', '683af3f0c09281748694000.jpg', '2025-05-31 12:20:00', '2025-05-31 12:20:00'),
(29, 6, 1, 'admin', 'local', '683af464bcd151748694116.jpg', '2025-05-31 12:21:56', '2025-05-31 12:21:56'),
(30, 6, 1, 'admin', 'local', '683af464d8ccd1748694116.jpg', '2025-05-31 12:21:57', '2025-05-31 12:21:57'),
(31, 6, 1, 'admin', 'local', '683af4656a6911748694117.jpg', '2025-05-31 12:21:57', '2025-05-31 12:21:57'),
(32, 6, 1, 'admin', 'local', '683af465e7a5a1748694117.jpg', '2025-05-31 12:21:58', '2025-05-31 12:21:58'),
(33, 6, 1, 'admin', 'local', '683af466b3e841748694118.jpg', '2025-05-31 12:21:58', '2025-05-31 12:21:58'),
(34, 6, 1, 'admin', 'local', '683af46725c7b1748694119.jpg', '2025-05-31 12:21:59', '2025-05-31 12:21:59'),
(35, 6, 1, 'admin', 'local', '683af467608221748694119.jpg', '2025-05-31 12:21:59', '2025-05-31 12:21:59'),
(36, 6, 1, 'admin', 'local', '683af467d27541748694119.jpg', '2025-05-31 12:22:00', '2025-05-31 12:22:00'),
(37, 7, 1, 'admin', 'local', '683af4e07bfcb1748694240.jpg', '2025-05-31 12:24:00', '2025-05-31 12:24:00'),
(38, 7, 1, 'admin', 'local', '683af4e07d66a1748694240.jpg', '2025-05-31 12:24:00', '2025-05-31 12:24:00'),
(39, 7, 1, 'admin', 'local', '683af4e0de8431748694240.jpg', '2025-05-31 12:24:01', '2025-05-31 12:24:01'),
(40, 7, 1, 'admin', 'local', '683af4e1694871748694241.jpg', '2025-05-31 12:24:01', '2025-05-31 12:24:01'),
(41, 7, 1, 'admin', 'local', '683af4e1dca771748694241.jpg', '2025-05-31 12:24:02', '2025-05-31 12:24:02'),
(42, 7, 1, 'admin', 'local', '683af4e2608a71748694242.jpg', '2025-05-31 12:24:02', '2025-05-31 12:24:02'),
(43, 7, 1, 'admin', 'local', '683af4e2d9ef41748694242.jpg', '2025-05-31 12:24:03', '2025-05-31 12:24:03'),
(44, 7, 1, 'admin', 'local', '683af4e2f3e6e1748694242.jpg', '2025-05-31 12:24:03', '2025-05-31 12:24:03'),
(45, 7, 1, 'admin', 'local', '683af4e35d26c1748694243.jpg', '2025-05-31 12:24:03', '2025-05-31 12:24:03'),
(46, 7, 1, 'admin', 'local', '683af4e3d731d1748694243.jpg', '2025-05-31 12:24:04', '2025-05-31 12:24:04'),
(47, 1, 1, 'admin', 'local', '683af5c9d550e1748694473.jpg', '2025-05-31 12:27:54', '2025-05-31 12:27:54'),
(48, 1, 1, 'admin', 'local', '683af5c9d22dc1748694473.jpg', '2025-05-31 12:27:54', '2025-05-31 12:27:54'),
(49, 1, 1, 'admin', 'local', '683af5ca559541748694474.jpg', '2025-05-31 12:27:54', '2025-05-31 12:27:54'),
(50, 1, 1, 'admin', 'local', '683af5ca56f721748694474.jpg', '2025-05-31 12:27:54', '2025-05-31 12:27:54'),
(51, 1, 1, 'admin', 'local', '683af5cb0ef2b1748694475.jpg', '2025-05-31 12:27:55', '2025-05-31 12:27:55'),
(52, 1, 1, 'admin', 'local', '683af5cb4815f1748694475.jpg', '2025-05-31 12:27:55', '2025-05-31 12:27:55'),
(53, 1, 1, 'admin', 'local', '683af5cb7b7181748694475.jpg', '2025-05-31 12:27:55', '2025-05-31 12:27:55'),
(54, 1, 1, 'admin', 'local', '683af5cbde1d11748694475.jpg', '2025-05-31 12:27:56', '2025-05-31 12:27:56'),
(55, 1, 1, 'admin', 'local', '683af5cc52d5c1748694476.jpg', '2025-05-31 12:27:56', '2025-05-31 12:27:56'),
(56, 1, 1, 'admin', 'local', '683af5cc961761748694476.jpg', '2025-05-31 12:27:56', '2025-05-31 12:27:56'),
(59, 3, 1, 'admin', 'local', '6840b0facc4e51749070074.jpg', '2025-06-05 06:47:55', '2025-06-05 06:47:55'),
(60, 3, 1, 'admin', 'local', '6840b13754c971749070135.jpg', '2025-06-05 06:48:55', '2025-06-05 06:48:55'),
(61, 3, 1, 'admin', 'local', '6840b13794b6b1749070135.jpg', '2025-06-05 06:48:56', '2025-06-05 06:48:56'),
(62, 3, 1, 'admin', 'local', '6840b139618a91749070137.jpg', '2025-06-05 06:48:57', '2025-06-05 06:48:57'),
(63, 3, 1, 'admin', 'local', '6840b139959f51749070137.jpg', '2025-06-05 06:48:58', '2025-06-05 06:48:58'),
(64, 3, 1, 'admin', 'local', '6840b13aaefc41749070138.jpg', '2025-06-05 06:48:59', '2025-06-05 06:48:59'),
(65, 8, 1, 'admin', 'local', '68513aa8b78461750153896.jpg', '2025-06-17 19:51:36', '2025-06-17 19:51:36'),
(66, 8, 1, 'admin', 'local', '68513aa94b1631750153897.jpg', '2025-06-17 19:51:37', '2025-06-17 19:51:37'),
(67, 8, 1, 'admin', 'local', '68513ab346c4d1750153907.jpg', '2025-06-17 19:51:47', '2025-06-17 19:51:47'),
(68, 8, 1, 'admin', 'local', '68513ab3c48dd1750153907.png', '2025-06-17 19:51:47', '2025-06-17 19:51:47'),
(69, 8, 1, 'admin', 'local', '68513ab44a4771750153908.jpg', '2025-06-17 19:51:48', '2025-06-17 19:51:48'),
(70, 9, 1, 'admin', 'local', '686fe306bb05e1752163078.jpg', '2025-07-11 01:57:59', '2025-07-11 01:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `listing_units`
--

CREATE TABLE `listing_units` (
  `id` int(10) UNSIGNED NOT NULL,
  `building_id` int(10) UNSIGNED NOT NULL,
  `userable_id` int(10) UNSIGNED NOT NULL COMMENT 'admin, user	',
  `userable_type` varchar(5) NOT NULL,
  `unit_number` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `zip_url` varchar(255) DEFAULT NULL,
  `description` longtext NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2 COMMENT ' 1 = active , 2 = Deactivated',
  `step` int(11) NOT NULL COMMENT ' 1 = first step,\r\n2 = second step',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listing_units`
--

INSERT INTO `listing_units` (`id`, `building_id`, `userable_id`, `userable_type`, `unit_number`, `image`, `price`, `zip_url`, `description`, `status`, `step`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'admin', '#235AE', '6838226872c171748509288.jpg', 100.00, 'http://localhost/custom_photostack_2/zip_1748509288_He9ymi8B_#235AE.zip', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 1, 1, '2025-05-29 09:01:28', '2025-05-29 09:01:28'),
(2, 12, 1, 'user', '#1313', '6840b1c4845241749070276.jpg', 50.00, 'http://localhost/custom_photostack_2/zip_1748511341_zGhwGz3A_#235AE.zip', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 1, 1, '2025-05-29 09:35:42', '2025-06-05 06:51:34'),
(3, 12, 1, 'admin', '#2012', '6840b11983c6a1749070105.jpg', 50.00, 'http://localhost/custom_photostack_2/zip_1748685061_WHkjn29N_#235AE.zip', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>', 1, 1, '2025-05-31 09:51:01', '2025-06-05 06:50:12'),
(4, 2, 1, 'admin', '#235A45', '683ad235b31fe1748685365.jpg', 120.00, 'http://localhost/custom_photostack_2/zip_1748685365_xQeWBo9X_#235A45.zip', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>', 1, 1, '2025-05-31 09:56:05', '2025-05-31 09:56:05'),
(5, 3, 1, 'admin', '#573', '683af3df53ed21748693983.jpg', 59.00, 'http://localhost/custom_photostack_2/zip_1748693983_ZUZyb8x3_#573.zip', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 1, 1, '2025-05-31 12:19:43', '2025-05-31 12:19:43'),
(6, 2, 1, 'admin', '#232225', '683af45ecb41f1748694110.jpg', 100.00, 'http://localhost/custom_photostack_2/zip_1748694110_niF8oT8J_#232225.zip', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 1, 1, '2025-05-31 12:21:51', '2025-05-31 12:21:51'),
(7, 2, 1, 'admin', '#6743AD', '683af494839061748694164.jpg', 200.00, 'http://localhost/custom_photostack_2/zip_1748694164_JwVmpyLB_#6743AD.zip', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 1, 1, '2025-05-31 12:22:44', '2025-05-31 12:22:44'),
(8, 2, 1, 'admin', '#QIQ2352', '68513a944c60a1750153876.jpg', 500.00, 'https://saed.wstacks.com/custom_photostack/zip_1750153876_pPXCXsiP_#QIQ2352.zip', '<p>zfdhgsfghnsxtrfjhfgxjhfg</p>', 1, 1, '2025-06-17 19:51:16', '2025-06-17 19:51:16'),
(9, 13, 1, 'admin', '10', '686fe3005ab361752163072.jpg', 10.00, 'https://saed.wstacks.com/custom_photostack/zip_1752163072_E93JLrSJ_10.zip', '<p>10</p>', 1, 1, '2025-07-11 01:57:52', '2025-07-11 01:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_12_26_144608_create_media_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `neighborhoods`
--

CREATE TABLE `neighborhoods` (
  `id` int(11) NOT NULL,
  `county_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `neighborhoods`
--

INSERT INTO `neighborhoods` (`id`, `county_id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Antia', '68371a4e9d0f31748441678.jpg', 1, '2025-05-28 14:14:38', '2025-05-28 14:14:38'),
(2, 2, 'Solara', '68371a64c8a451748441700.jpg', 1, '2025-05-28 14:15:00', '2025-05-28 14:15:00'),
(3, 11, 'Habibo', '68371a80f248b1748441728.jpg', 1, '2025-05-28 14:15:29', '2025-05-28 14:15:29'),
(4, 8, 'Chabur', '68371aa681d621748441766.jpg', 1, '2025-05-28 14:16:06', '2025-05-28 14:16:06'),
(5, 10, 'Duido', '68371acb2c7081748441803.jpg', 1, '2025-05-28 14:16:43', '2025-05-28 14:16:43'),
(6, 6, 'Walve', '68371b3867aa61748441912.jpg', 1, '2025-05-28 14:18:32', '2025-05-28 14:18:32'),
(7, 4, 'Optre', '68371b58e857f1748441944.jpg', 1, '2025-05-28 14:19:05', '2025-05-28 14:19:05'),
(8, 1, 'Mosle', '68371b80378b31748441984.jpg', 1, '2025-05-28 14:19:44', '2025-05-28 14:19:44'),
(9, 7, 'Sansa', '68371cf557c691748442357.jpg', 1, '2025-05-28 14:25:57', '2025-05-28 14:25:57'),
(10, 5, 'Pion', '68371d07323e91748442375.jpg', 1, '2025-05-28 14:26:15', '2025-05-28 14:26:15'),
(11, 9, 'Nitopas', '68371d4feab781748442447.jpg', 1, '2025-05-28 14:27:28', '2025-05-28 14:27:28'),
(12, 2, 'Bahlarsa', '68371dd508a461748442581.jpg', 1, '2025-05-28 14:29:41', '2025-05-28 14:29:41'),
(13, 10, 'Crasreqra', '68371df9739f11748442617.jpg', 1, '2025-05-28 14:30:17', '2025-05-28 14:30:17'),
(14, 5, 'Opsan', '68371e0c618f31748442636.jpg', 1, '2025-05-28 14:30:36', '2025-05-28 14:30:36'),
(15, 12, 'Brickell', '6840a6dbd6a941749067483.jpg', 1, '2025-06-05 06:04:43', '2025-06-05 06:04:43'),
(16, 12, 'Bay Harbor Island', '6840a6edb7d521749067501.jpg', 1, '2025-06-05 06:05:01', '2025-06-05 06:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sender` varchar(40) DEFAULT NULL,
  `sent_from` varchar(40) DEFAULT NULL,
  `sent_to` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `notification_type` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_logs`
--

INSERT INTO `notification_logs` (`id`, `user_id`, `sender`, `sent_from`, `sent_to`, `subject`, `message`, `notification_type`, `created_at`, `updated_at`) VALUES
(1, 0, 'smtp', 'info@example.com', 'riasadrion@gmail.com', 'SMTP Configuration Success', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">System Mail</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.imgur.com/K2fIRda.png\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello riasadrion (riasadrion@gmail.com)</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">Your email notification setting is configured successfully for MinStack</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2022&nbsp;<a href=\"#\">MinStack</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'email', '2023-01-21 07:41:43', '2023-01-21 07:41:43'),
(2, 33, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Please verify your email address', '<p>Hi @testuser (testuser),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;560475</span></font></div></div></p>', 'email', '2023-12-06 07:55:36', '2023-12-06 07:55:36'),
(3, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Please verify your email address', '<p>Hi @testuser (testuser),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;702445</span></font></div></div></p>', 'email', '2023-12-18 10:58:04', '2023-12-18 10:58:04'),
(4, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Withdraw Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">Tranfer from Bank&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 100.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 1.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: 97.00 USD<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; Tranfer from Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 51FYD6MF1X4P</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">0.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div></p>', 'email', '2023-12-19 09:44:08', '2023-12-19 09:44:08'),
(5, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Withdraw Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">Tranfer from Bank&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 100.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 1.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: 97.00 USD<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; Tranfer from Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : O6ZBXP41KKWJ</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div></p>', 'email', '2023-12-19 10:19:36', '2023-12-19 10:19:36'),
(6, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">1,000.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 1,000.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">11.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 111,210.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 7YS94S8UYMZA</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2023-12-19 12:24:47', '2023-12-19 12:24:47'),
(7, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">130.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 130.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">2.30 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 14,553.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 43PPNYESF3JG</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2023-12-19 12:25:50', '2023-12-19 12:25:50'),
(8, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">130.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 130.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">2.30 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 14,553.00 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 43PPNYESF3JG</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">230.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2023-12-19 12:30:08', '2023-12-19 12:30:08'),
(9, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 03:18:35 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">194296</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 09:18:37', '2023-12-20 09:18:37'),
(10, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'You have reset your password', '<p>Hi Test User (testuser),&nbsp;</p><p><p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 03:20:17 PM</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p></p>', 'email', '2023-12-20 09:20:19', '2023-12-20 09:20:19'),
(11, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 03:31:42 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">232756</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 09:31:44', '2023-12-20 09:31:44'),
(12, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:18:23 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">913387</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:18:25', '2023-12-20 10:18:25'),
(13, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:21:35 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">288247</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:21:37', '2023-12-20 10:21:37'),
(14, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:21:42 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">899411</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:21:44', '2023-12-20 10:21:44'),
(15, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:26:01 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">749902</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:26:03', '2023-12-20 10:26:03'),
(16, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'You have reset your password', '<p>Hi Test User (testuser),&nbsp;</p><p><p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:27:43 PM</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p></p>', 'email', '2023-12-20 10:27:45', '2023-12-20 10:27:45'),
(17, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:28:39 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">969489</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:28:41', '2023-12-20 10:28:41'),
(18, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:33:44 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">615321</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:33:46', '2023-12-20 10:33:46'),
(19, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:36:07 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">831227</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:36:09', '2023-12-20 10:36:09'),
(20, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:37:05 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">257057</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:37:07', '2023-12-20 10:37:07'),
(21, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'You have reset your password', '<p>Hi Test User (testuser),&nbsp;</p><p><p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:38:02 PM</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p></p>', 'email', '2023-12-20 10:38:04', '2023-12-20 10:38:04'),
(22, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:38:14 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">300588</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:38:16', '2023-12-20 10:38:16'),
(23, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:39:31 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">237160</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:39:33', '2023-12-20 10:39:33'),
(24, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:43:25 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">353624</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:43:27', '2023-12-20 10:43:27'),
(25, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:44:15 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">557646</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 10:44:17', '2023-12-20 10:44:17'),
(26, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'You have reset your password', '<p>Hi Test User (testuser),&nbsp;</p><p><p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 04:44:37 PM</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p></p>', 'email', '2023-12-20 10:44:39', '2023-12-20 10:44:39'),
(27, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 05:03:25 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">590198</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 11:03:27', '2023-12-20 11:03:27'),
(28, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 05:05:51 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">745160</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 11:05:53', '2023-12-20 11:05:53'),
(29, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 05:07:38 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">918948</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-20 11:07:40', '2023-12-20 11:07:40'),
(30, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'You have reset your password', '<p>Hi Test User (testuser),&nbsp;</p><p><p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">2023-12-20 05:08:12 PM</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p></p>', 'email', '2023-12-20 11:08:14', '2023-12-20 11:08:14'),
(31, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2023-12-21 04:49:27 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">764240</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2023-12-21 10:49:29', '2023-12-21 10:49:29'),
(32, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Reply Support Ticket', '<p>Hi Test User (testuser),&nbsp;</p><p><div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#217745] asdfa<br><br>Click here to reply:&nbsp; http://localhost/photostock/ticket/view/217745</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>asdf<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2023-12-21 12:28:46', '2023-12-21 12:28:46'),
(33, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Reply Support Ticket', '<p>Hi Test User (testuser),&nbsp;</p><p><div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#217745] asdfa<br><br>Click here to reply:&nbsp; http://localhost/photostock/ticket/view/217745</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>asdf<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2023-12-21 12:42:05', '2023-12-21 12:42:05'),
(34, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Withdraw Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">10.00 USD</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">Mobile Banking&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 10.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">0.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 1.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: 10.00 USD<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; Mobile Banking</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 6A4HSGET9JFR</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">220.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div></p>', 'email', '2024-01-03 10:01:15', '2024-01-03 10:01:15'),
(35, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Withdraw Request has been Processed and your money is sent', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">10.00 USD</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">Mobile Banking&nbsp;</span>has been Processed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 10.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">0.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 1.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: 10.00 USD<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; Mobile Banking</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 6A4HSGET9JFR</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Processed Payment :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">okey</span></font></div></p>', 'email', '2024-01-03 10:02:26', '2024-01-03 10:02:26');
INSERT INTO `notification_logs` (`id`, `user_id`, `sender`, `sent_from`, `sent_to`, `subject`, `message`, `notification_type`, `created_at`, `updated_at`) VALUES
(36, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : WXTO719WXJMT</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 11:19:24', '2024-01-03 11:19:24'),
(37, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 36.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 4,109.60 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : TWFEKFYVNQ1J</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 11:20:14', '2024-01-03 11:20:14'),
(38, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : D4WJ8XE2B5DO</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 11:23:32', '2024-01-03 11:23:32'),
(39, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 36.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 4,109.60 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : OSJGB2R8ZXXN</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 11:23:57', '2024-01-03 11:23:57'),
(40, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 13FYQ7DQHV4W</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 15:11:24', '2024-01-03 15:11:24'),
(41, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 36.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 4,109.60 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : NAQHYCHGR2AT</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 15:12:43', '2024-01-03 15:12:43'),
(42, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 100.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">2.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 11,220.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : A5KOKRE8KJQQ</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 15:15:02', '2024-01-03 15:15:02'),
(43, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 100.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">2.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 11,220.00 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : A5KOKRE8KJQQ</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-03 15:19:21', '2024-01-03 15:19:21'),
(44, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 100.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">2.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 11,220.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 4UNZ67YCTJQ6</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 15:56:45', '2024-01-03 15:56:45'),
(45, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 100.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">2.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 11,220.00 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 4UNZ67YCTJQ6</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-03 15:57:53', '2024-01-03 15:57:53'),
(46, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : C6Z8U1QESE83</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 16:03:24', '2024-01-03 16:03:24'),
(47, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : WBT988V5OYEP</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 16:13:35', '2024-01-03 16:13:35'),
(48, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : CUFYK5CF122W</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 16:23:56', '2024-01-03 16:23:56'),
(49, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 9.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 1,109.90 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : CUFYK5CF122W</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-03 16:24:41', '2024-01-03 16:24:41'),
(50, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 2VN7N3YPNV3C</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 16:30:54', '2024-01-03 16:30:54'),
(51, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 9.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 1,109.90 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 2VN7N3YPNV3C</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-03 16:31:22', '2024-01-03 16:31:22'),
(52, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 36.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 4,109.60 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : F1EMY66FCZHD</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-03 16:57:43', '2024-01-03 16:57:43'),
(53, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 36.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 4,109.60 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : F1EMY66FCZHD</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-03 17:08:20', '2024-01-03 17:08:20'),
(54, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Please verify your email address', '<p>Hi @testuser2 (testuser2),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;727212</span></font></div></div></p>', 'email', '2024-01-04 04:30:13', '2024-01-04 04:30:13'),
(55, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Please verify your email address', '<p>Hi @testuser2 (testuser2),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;228330</span></font></div></div></p>', 'email', '2024-01-04 04:32:24', '2024-01-04 04:32:24'),
(56, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Please verify your email address', '<p>Hi @testuser2 (testuser2),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;469824</span></font></div></div></p>', 'email', '2024-01-04 04:34:28', '2024-01-04 04:34:28'),
(57, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : SN6PQGE75NEN</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-04 04:44:47', '2024-01-04 04:44:47'),
(58, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : CYTYEQPF1RJB</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-04 04:51:55', '2024-01-04 04:51:55'),
(59, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 2KSEKHCM4DTW</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-04 05:08:07', '2024-01-04 05:08:07'),
(60, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 9.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 1,109.90 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 2KSEKHCM4DTW</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">0.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-04 05:08:49', '2024-01-04 05:08:49'),
(61, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 36.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 4,109.60 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : PMM8HAG7Q8SA</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-04 05:16:44', '2024-01-04 05:16:44'),
(62, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 36.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 4,109.60 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : PMM8HAG7Q8SA</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">0.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-04 05:17:29', '2024-01-04 05:17:29'),
(63, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2024-01-05 05:02:39 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">510750</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2024-01-05 11:02:41', '2024-01-05 11:02:41'),
(64, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2024-01-05 05:04:18 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">431050</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2024-01-05 11:04:20', '2024-01-05 11:04:20'),
(65, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Password Reset', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">2024-01-06 02:30:56 PM .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">127.0.0.1</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">Chrome</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">Windows 10&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">776513</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div></p>', 'email', '2024-01-06 08:30:58', '2024-01-06 08:30:58'),
(66, 36, 'php', 'notify@wstacks.com', 'testuser3@gmail.com', 'Please verify your email address', '<p>Hi @testuser3 (testuser3),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;128231</span></font></div></div></p>', 'email', '2024-01-06 10:46:02', '2024-01-06 10:46:02'),
(67, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : S2QK7X3O77GE</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-08 10:01:59', '2024-01-08 10:01:59'),
(68, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 9.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 1,109.90 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : S2QK7X3O77GE</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">7.91 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-08 10:02:43', '2024-01-08 10:02:43'),
(69, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : YN4FNDVTFYDU</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-08 10:06:43', '2024-01-08 10:06:43'),
(70, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 9.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 1,109.90 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : YN4FNDVTFYDU</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">7.91 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-08 10:07:00', '2024-01-08 10:07:00'),
(71, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 445AG8ZU2NY9</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-08 10:12:30', '2024-01-08 10:12:30'),
(72, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 9.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 1,109.90 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 445AG8ZU2NY9</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">153.91 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-08 10:13:34', '2024-01-08 10:13:34'),
(73, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 36.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 4,109.60 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : AESXUMKMZE7F</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2024-01-11 09:10:21', '2024-01-11 09:10:21'),
(74, 35, 'php', 'notify@wstacks.com', 'testuse2r@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User 2 (testuser2),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">36.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 36.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.36 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 4,109.60 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : AESXUMKMZE7F</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">153.91 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2024-01-11 09:10:56', '2024-01-11 09:10:56'),
(75, 37, 'php', 'notify@wstacks.com', 'testuser5@gmail.com', 'Please verify your email address', '<p>Hi @testuser5 (testuser5),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;473675</span></font></div></div></p>', 'email', '2025-03-01 12:33:49', '2025-03-01 12:33:49'),
(76, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Deposit Request Submitted Successfully', '<p>Hi Test User (testuser),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 9.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 1,109.90 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : QFDM1HM9R2OH</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-03-03 10:12:54', '2025-03-03 10:12:54');
INSERT INTO `notification_logs` (`id`, `user_id`, `sender`, `sent_from`, `sent_to`, `subject`, `message`, `notification_type`, `created_at`, `updated_at`) VALUES
(77, 34, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Deposit is Approved', '<p>Hi Test User (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">9.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 9.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">1.09 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 1,109.90 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : QFDM1HM9R2OH</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">6.82 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-03-03 10:13:29', '2025-03-03 10:13:29'),
(78, 1, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Please verify your email address', '<p>Hi @testuser (testuser),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;297218</span></font></div></div></p>', 'email', '2025-03-03 11:01:59', '2025-03-03 11:01:59'),
(79, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Please verify your email address', '<p>Hi @sasovo (sasovo),&nbsp;</p><p><br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;419856</span></font></div></div></p>', 'email', '2025-05-07 08:46:18', '2025-05-07 08:46:18'),
(80, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 63WW3JFN49MM</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-20 07:24:18', '2025-05-20 07:24:18'),
(81, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 200.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 22,330.00 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 63WW3JFN49MM</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">600.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 09:16:19', '2025-05-20 09:16:19'),
(82, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : VT6GZ39WB4UW</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-20 09:30:40', '2025-05-20 09:30:40'),
(83, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 200.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 22,330.00 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : VT6GZ39WB4UW</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">1,600.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 09:31:13', '2025-05-20 09:31:13'),
(84, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">278.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 278.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.78 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 30,995.80 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : GAGO9OWY6YHA</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-20 09:34:31', '2025-05-20 09:34:31'),
(85, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">278.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 278.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.78 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 30,995.80 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : GAGO9OWY6YHA</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">1,322.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 09:34:56', '2025-05-20 09:34:56'),
(86, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">278.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 278.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.78 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 30,995.80 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : P2YR6F26YEWB</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-20 09:37:40', '2025-05-20 09:37:40'),
(87, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">278.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 278.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.78 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 30,995.80 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : P2YR6F26YEWB</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">1,322.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 09:38:25', '2025-05-20 09:38:25'),
(88, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">278.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 278.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.78 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 30,995.80 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : P2YR6F26YEWB</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">1,322.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 09:38:52', '2025-05-20 09:38:52'),
(89, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">278.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 278.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.78 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 30,995.80 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : P2YR6F26YEWB</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">1,322.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 09:40:40', '2025-05-20 09:40:40'),
(90, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">250.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 250.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.50 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 27,885.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : KTC9R2VHDK9P</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-20 09:43:24', '2025-05-20 09:43:24'),
(91, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">250.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 250.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.50 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 27,885.00 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : KTC9R2VHDK9P</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">1,072.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 09:43:56', '2025-05-20 09:43:56'),
(92, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">250.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 250.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.50 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 27,885.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 6O5GDGTYS88R</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-20 10:32:27', '2025-05-20 10:32:27'),
(93, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">250.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 250.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">3.50 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 27,885.00 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 6O5GDGTYS88R</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">822.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 10:33:30', '2025-05-20 10:33:30'),
(94, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">100.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 100.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">2.00 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 11,220.00 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 5RAZSYC53GUD</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">922.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 10:41:40', '2025-05-20 10:41:40'),
(95, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">177.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 177.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">2.77 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 19,774.70 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 756KCJ1W8O8H</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-20 11:42:45', '2025-05-20 11:42:45'),
(96, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Deposit is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">177.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 177.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">2.77 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 110.00 BDT</div><div style=\"font-family: Montserrat, sans-serif;\">Received : 19,774.70 BDT<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; ABC Bank</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : 756KCJ1W8O8H</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">568.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div></p>', 'email', '2025-05-20 11:46:23', '2025-05-20 11:46:23'),
(97, 1, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Withdraw Request Submitted Successfully', '<p>Hi test user (testuser),&nbsp;</p><p><div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">Mobile Banking&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : 200.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">0.02 USD</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 USD = 1.00 USD</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: 199.98 USD<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; Mobile Banking</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : ZYK31J4KJQA1</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">831.00 USD</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div></p>', 'email', '2025-05-20 15:55:31', '2025-05-20 15:55:31'),
(98, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : KDD3MBEAQANZ</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-29 14:04:55', '2025-05-29 14:04:55'),
(99, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : P25ASP1HRMOQ</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-29 14:10:52', '2025-05-29 14:10:52'),
(100, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : QE2GU7HKP7Z5</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-29 14:13:06', '2025-05-29 14:13:06'),
(101, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : TPP7EHZGUSRV</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-29 14:47:30', '2025-05-29 14:47:30'),
(102, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Payment is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><p>Your payment request of&nbsp;200.00 USD&nbsp;is via&nbsp; ABC Bank&nbsp;is Approved .<br>&nbsp;</p><p><br>&nbsp;</p><p>Details of your Payment:<br>&nbsp;</p><p>Amount : 200.00 USD</p><p>Charge:&nbsp;3.00 USD</p><p>Conversion Rate : 1 USD = 110.00 BDT</p><p>Received : 22,330.00 BDT<br>&nbsp;</p><p>Paid via :&nbsp; ABC Bank</p><p>Transaction Number : TPP7EHZGUSRV</p><p><br>&nbsp;</p><p>Your current Balance is&nbsp;568.00 USD</p></p>', 'email', '2025-05-29 14:47:41', '2025-05-29 14:47:41'),
(103, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : SCA5NB1MRUT6</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-29 14:49:39', '2025-05-29 14:49:39'),
(104, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Payment is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><p>Your payment request of&nbsp;200.00 USD&nbsp;is via&nbsp; ABC Bank&nbsp;is Approved .<br>&nbsp;</p><p><br>&nbsp;</p><p>Details of your Payment:<br>&nbsp;</p><p>Amount : 200.00 USD</p><p>Charge:&nbsp;3.00 USD</p><p>Conversion Rate : 1 USD = 110.00 BDT</p><p>Received : 22,330.00 BDT<br>&nbsp;</p><p>Paid via :&nbsp; ABC Bank</p><p>Transaction Number : SCA5NB1MRUT6</p><p><br>&nbsp;</p><p>Your current Balance is&nbsp;568.00 USD</p></p>', 'email', '2025-05-29 14:51:07', '2025-05-29 14:51:07'),
(105, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">230.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 230.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.30 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 25,663.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 22WVAWNYD9JM</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-29 14:57:24', '2025-05-29 14:57:24'),
(106, 1, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Payment is Approved', '<p>Hi test user (testuser),&nbsp;</p><p><p>Your payment request of&nbsp;230.00 USD&nbsp;is via&nbsp; ABC Bank&nbsp;is Approved .<br>&nbsp;</p><p><br>&nbsp;</p><p>Details of your Payment:<br>&nbsp;</p><p>Amount : 230.00 USD</p><p>Charge:&nbsp;3.30 USD</p><p>Conversion Rate : 1 USD = 110.00 BDT</p><p>Received : 25,663.00 BDT<br>&nbsp;</p><p>Paid via :&nbsp; ABC Bank</p><p>Transaction Number : 22WVAWNYD9JM</p><p><br>&nbsp;</p><p>Your current Balance is&nbsp;842.50 USD</p></p>', 'email', '2025-05-29 14:57:33', '2025-05-29 14:57:33'),
(107, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">230.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 230.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.30 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 25,663.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : JDUU3N8FDGAQ</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-29 14:58:53', '2025-05-29 14:58:53'),
(108, 1, 'php', 'notify@wstacks.com', 'testuser@gmail.com', 'Your Payment is Approved', '<p>Hi test user (testuser),&nbsp;</p><p><p>Your payment request of&nbsp;230.00 USD&nbsp;is via&nbsp; ABC Bank&nbsp;is Approved .<br>&nbsp;</p><p><br>&nbsp;</p><p>Details of your Payment:<br>&nbsp;</p><p>Amount : 230.00 USD</p><p>Charge:&nbsp;3.30 USD</p><p>Conversion Rate : 1 USD = 110.00 BDT</p><p>Received : 25,663.00 BDT<br>&nbsp;</p><p>Paid via :&nbsp; ABC Bank</p><p>Transaction Number : JDUU3N8FDGAQ</p><p><br>&nbsp;</p><p>Your current Balance is&nbsp;854.00 USD</p></p>', 'email', '2025-05-29 14:59:08', '2025-05-29 14:59:08'),
(109, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : MCMFGTBD2RBJ</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-31 12:40:47', '2025-05-31 12:40:47'),
(110, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Payment is Approved', '<p>Hi test user (sasovo),&nbsp;</p><p><p>Your payment request of&nbsp;200.00 USD&nbsp;is via&nbsp; ABC Bank&nbsp;is Approved .<br>&nbsp;</p><p><br>&nbsp;</p><p>Details of your Payment:<br>&nbsp;</p><p>Amount : 200.00 USD</p><p>Charge:&nbsp;3.00 USD</p><p>Conversion Rate : 1 USD = 110.00 BDT</p><p>Received : 22,330.00 BDT<br>&nbsp;</p><p>Paid via :&nbsp; ABC Bank</p><p>Transaction Number : MCMFGTBD2RBJ</p><p><br>&nbsp;</p><p>Your current Balance is&nbsp;244.00 USD</p></p>', 'email', '2025-05-31 12:41:00', '2025-05-31 12:41:00'),
(111, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi test user (sasovo),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : 4AT4W5194NAC</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-05-31 12:42:13', '2025-05-31 12:42:13'),
(112, 2, 'php', 'notify@wstacks.com', 'sasovo@mailinator.com', 'Your Payment Request is Rejected', '<p>Hi test user (sasovo),&nbsp;</p><p><p>Your payment request of&nbsp;200.00 USD&nbsp;is via&nbsp; ABC Bank has been rejected.<br>&nbsp;</p><p>Conversion Rate : 1 USD = 110.00 BDT</p><p>Received : 22,330.00 BDT<br>&nbsp;</p><p>Paid via :&nbsp; ABC Bank</p><p>Charge: 3.00</p><p>Transaction Number was : 4AT4W5194NAC</p><p>if you have any queries, feel free to contact us.<br>&nbsp;</p><p><br>&nbsp;</p><p><br><br>&nbsp;</p><p>xvcbhxfghbfg<br>&nbsp;</p></p>', 'email', '2025-05-31 12:42:45', '2025-05-31 12:42:45'),
(113, 3, 'php', 'notify@wstacks.com', 'naira@mailinator.com', 'Deposit Request Submitted Successfully', '<p>Hi naira user (naira),&nbsp;</p><p><div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">200.00 USD</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">ABC Bank&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : 200.00 USD</div><div>Charge:&nbsp;<font color=\"#FF0000\">3.00 USD</font></div><div><br></div><div>Conversion Rate : 1 USD = 110.00 BDT</div><div>Payable : 22,330.00 BDT<br></div><div>Pay via :&nbsp; ABC Bank</div><div><br></div><div>Transaction Number : PDZ9FDBZCETV</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div></p>', 'email', '2025-06-17 20:52:28', '2025-06-17 20:52:28'),
(114, 3, 'php', 'notify@wstacks.com', 'naira@mailinator.com', 'Your Payment is Approved', '<p>Hi naira user (naira),&nbsp;</p><p><p>Your payment request of&nbsp;200.00 USD&nbsp;is via&nbsp; ABC Bank&nbsp;is Approved .<br>&nbsp;</p><p><br>&nbsp;</p><p>Details of your Payment:<br>&nbsp;</p><p>Amount : 200.00 USD</p><p>Charge:&nbsp;3.00 USD</p><p>Conversion Rate : 1 USD = 110.00 BDT</p><p>Received : 22,330.00 BDT<br>&nbsp;</p><p>Paid via :&nbsp; ABC Bank</p><p>Transaction Number : PDZ9FDBZCETV</p><p><br>&nbsp;</p><p>Your current Balance is&nbsp;568.00 USD</p></p>', 'email', '2025-06-17 20:53:18', '2025-06-17 20:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `subj` varchar(255) DEFAULT NULL,
  `email_body` text DEFAULT NULL,
  `sms_body` text DEFAULT NULL,
  `shortcodes` text DEFAULT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 1,
  `sms_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', '<div><div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been added to your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}&nbsp;</span></font><br></div><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin note:&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap; text-align: var(--bs-body-text-align);\">{{remark}}</span></div>', '{{amount}} {{site_currency}} credited in your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin note is \"{{remark}}\"', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 0, '2021-11-03 12:00:00', '2022-09-21 13:04:13'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', '<div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been subtracted from your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}</span></font><br><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin Note: {{remark}}</div>', '{{amount}} {{site_currency}} debited from your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin Note is {{remark}}', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-03 02:24:11'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', '<div>Your deposit of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been completed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#000000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Received : {{method_amount}} {{method_currency}}<br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit successfully by {{method_name}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-03 02:25:43'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Your Deposit is Approved', '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Admin Approve Your {{amount}} {{site_currency}} payment request by {{method_name}} transaction : {{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-03 02:26:07'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Your Deposit Request is Rejected', '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}} has been rejected</span>.<span style=\"font-weight: bolder;\"><br></span></div><div><br></div><div><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge: {{charge}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number was : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">if you have any queries, feel free to contact us.<br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><br><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">{{rejection_message}}</span><br>', 'Admin Rejected Your {{amount}} {{site_currency}} payment request by {{method_name}}\r\n\r\n{{rejection_message}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-05 03:45:27'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', '<div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit requested by {{method_name}}. Charge: {{charge}} . Trx: {{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-03 02:29:19'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '<div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">{{time}} .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">{{code}}</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div>', 'Your account recovery code is: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 0, '2021-11-03 12:00:00', '2022-03-20 20:47:05'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'You have reset your password', '<p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{time}}</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p>', 'Your password has been changed successfully', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-05 03:46:35'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Reply Support Ticket', '<div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>{{reply}}<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-20 20:47:51'),
(10, 'EVER_CODE', 'Verification - Email', 'Please verify your email address', '<br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;{{code}}</span></font></div></div>', '---', '{\"code\":\"Email verification code\"}', 1, 0, '2021-11-03 12:00:00', '2022-04-03 02:32:07'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', '---', 'Your phone verification code is: {{code}}', '{\"code\":\"SMS Verification Code\"}', 0, 1, '2021-11-03 12:00:00', '2022-03-20 19:24:37'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdraw Request has been Processed and your money is sent', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Processed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Processed Payment :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div>', 'Admin Approve Your {{amount}} {{site_currency}} withdraw request by {{method_name}}. Transaction {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-20 20:50:16'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdraw Request has been Rejected and your money is refunded to your account', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Rejected.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You should get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">----</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><br></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\">{{amount}} {{currency}} has been&nbsp;<span style=\"font-weight: bolder;\">refunded&nbsp;</span>to your account and your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}}</span><span style=\"font-weight: bolder;\">&nbsp;{{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Rejection :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br><br><br></div><div></div><div></div>', 'Admin Rejected Your {{amount}} {{site_currency}} withdraw request. Your Main Balance {{post_balance}}  {{method_name}} , Transaction {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-20 20:57:46'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdraw Request Submitted Successfully', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div>', '{{amount}} {{site_currency}} withdraw requested by {{method_name}}. You will get {{method_amount}} {{method_currency}} Trx: {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-21 04:39:03'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, 1, '2019-09-14 13:14:22', '2021-11-04 09:38:55'),
(18, 'PAYMENT_COMPLETE', 'Payment- Automated - Successful', 'Payment Completed Successfully', '<p>Your payment of&nbsp;{{amount}} {{site_currency}}&nbsp;is via&nbsp; {{method_name}}&nbsp;has been completed Successfully.<br>&nbsp;</p><p><br>&nbsp;</p><p>Details of your Payment :<br>&nbsp;</p><p>Amount : {{amount}} {{site_currency}}</p><p>Charge:&nbsp;{{charge}} {{site_currency}}</p><p>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</p><p>Received : {{method_amount}} {{method_currency}}<br>&nbsp;</p><p>Paid via :&nbsp; {{method_name}}</p><p>Transaction Number : {{trx}}</p><p><br>&nbsp;</p><p>Your current Balance is&nbsp;{{post_balance}} {{site_currency}}</p>', '{{amount}} {{site_currency}} Payment successfully by {{method_name}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2025-05-20 12:12:00'),
(19, 'PAYMENT_APPROVE', 'Payment- Manual - Approved', 'Your Payment is Approved', '<p>Your payment request of&nbsp;{{amount}} {{site_currency}}&nbsp;is via&nbsp; {{method_name}}&nbsp;is Approved .<br>&nbsp;</p><p><br>&nbsp;</p><p>Details of your Payment:<br>&nbsp;</p><p>Amount : {{amount}} {{site_currency}}</p><p>Charge:&nbsp;{{charge}} {{site_currency}}</p><p>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</p><p>Received : {{method_amount}} {{method_currency}}<br>&nbsp;</p><p>Paid via :&nbsp; {{method_name}}</p><p>Transaction Number : {{trx}}</p><p><br>&nbsp;</p><p>Your current Balance is&nbsp;{{post_balance}} {{site_currency}}</p>', 'Admin Approve Your {{amount}} {{site_currency}} payment request by {{method_name}} transaction : {{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2025-05-20 12:18:30'),
(20, 'PAYMENT_REJECT', 'Payment- Manual - Rejected', 'Your Payment Request is Rejected', '<p>Your payment request of&nbsp;{{amount}} {{site_currency}}&nbsp;is via&nbsp; {{method_name}} has been rejected.<br>&nbsp;</p><p>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</p><p>Received : {{method_amount}} {{method_currency}}<br>&nbsp;</p><p>Paid via :&nbsp; {{method_name}}</p><p>Charge: {{charge}}</p><p>Transaction Number was : {{trx}}</p><p>if you have any queries, feel free to contact us.<br>&nbsp;</p><p><br>&nbsp;</p><p><br><br>&nbsp;</p><p>{{rejection_message}}<br>&nbsp;</p>', 'Admin Rejected Your {{amount}} {{site_currency}} payment request by {{method_name}}\r\n\r\n{{rejection_message}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, 1, '2021-11-03 12:00:00', '2025-05-20 12:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `building_id` bigint(20) NOT NULL DEFAULT 0,
  `listing_unit_id` int(11) NOT NULL DEFAULT 0,
  `building_type` tinyint(4) NOT NULL COMMENT ' 1 = building , 2 = listing',
  `amount` decimal(8,2) NOT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT 'initials= 0,\r\napproved = 1,\r\npending = 2,',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `building_id`, `listing_unit_id`, `building_type`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 0, 1, 200.00, 2, '2025-05-29 14:02:42', '2025-05-29 14:04:54'),
(2, 2, 2, 0, 1, 200.00, 0, '2025-05-29 14:09:04', '2025-05-29 14:09:04'),
(3, 2, 2, 0, 1, 200.00, 2, '2025-05-29 14:10:44', '2025-05-29 14:10:52'),
(4, 2, 2, 0, 1, 200.00, 1, '2025-05-29 14:12:55', '2025-05-29 14:16:15'),
(5, 2, 2, 0, 1, 200.00, 0, '2025-05-29 14:14:41', '2025-05-29 14:14:41'),
(6, 2, 2, 0, 1, 200.00, 1, '2025-05-29 14:47:24', '2025-05-29 14:47:41'),
(7, 2, 2, 0, 1, 200.00, 1, '2025-05-29 14:49:31', '2025-05-29 14:51:07'),
(8, 2, 3, 0, 1, 230.00, 1, '2025-05-29 14:57:19', '2025-05-29 14:57:33'),
(9, 2, 3, 0, 1, 230.00, 1, '2025-05-29 14:58:45', '2025-05-29 14:59:08'),
(10, 2, 4, 0, 1, 124.00, 1, '2025-05-31 09:08:09', '2025-05-31 09:08:09'),
(11, 2, 2, 0, 1, 200.00, 1, '2025-05-31 12:38:14', '2025-05-31 12:38:14'),
(12, 2, 2, 0, 1, 200.00, 1, '2025-05-31 12:40:37', '2025-05-31 12:40:59'),
(13, 2, 2, 0, 1, 200.00, 2, '2025-05-31 12:42:04', '2025-05-31 12:42:13'),
(14, 2, 0, 3, 2, 50.00, 0, '2025-06-05 06:53:54', '2025-06-05 06:53:54'),
(15, 2, 0, 3, 2, 50.00, 0, '2025-06-05 06:54:04', '2025-06-05 06:54:04'),
(16, 2, 0, 3, 2, 50.00, 1, '2025-06-05 06:54:15', '2025-06-05 06:54:15'),
(17, 2, 13, 0, 1, 49.99, 1, '2025-06-12 07:49:34', '2025-06-12 07:49:34'),
(18, 3, 2, 0, 1, 200.00, 1, '2025-06-17 20:52:21', '2025-06-17 20:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `slug` varchar(40) DEFAULT NULL,
  `tempname` varchar(40) DEFAULT NULL COMMENT 'template name',
  `secs` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Home', '/', 'presets.default.', '[\"banner\",\"category\",\"work_process\",\"creative_resource\",\"visual_compilation\",\"faq\"]', 1, '2020-07-11 06:23:58', '2025-05-20 16:10:28'),
(2, 'FAQ', 'faq', 'presets.default.', '[\"faq\"]', 0, '2024-01-05 16:12:13', '2024-01-05 16:12:37'),
(3, 'Contact', 'contact', 'presets.default.', NULL, 1, '2020-10-22 01:14:53', '2020-10-22 01:14:53'),
(4, 'Neighborhood', 'neighborhood', 'presets.default.', NULL, 1, '2025-05-11 11:52:07', '2025-05-11 15:44:02'),
(5, 'Condo Building', 'condo-building', 'presets.default.', NULL, 1, '2025-05-14 09:17:32', '2025-05-14 09:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ronnie@gmail.com', '100375', '2020-07-07 05:44:47'),
('user@site.comfff', '988862', '2021-05-07 07:31:28'),
('mosta@gmail.com', '865544', '2021-06-10 09:21:05'),
('user@site.com', '532560', '2022-04-04 03:52:27'),
('testuser@gmail.com', '776513', '2024-01-06 08:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(29, 'App\\Models\\User', 22, 'MyApp', '5da1bfd64a5d95722d5c085185f0787323270c5cf12d09c5a69e4f950f4d8420', '[\"*\"]', NULL, '2021-05-19 05:47:02', '2021-05-19 05:47:02'),
(46, 'App\\Models\\User', 25, 'auth_token', 'bc7288b4e2082a0475639d6e2f29483a35abd11f55110df12244d9142f7ca54a', '[\"*\"]', NULL, '2021-06-10 05:35:17', '2021-06-10 05:35:17'),
(47, 'App\\Models\\User', 25, 'auth_token', '2bcdbee9ab110af212b02516a602ba52cf27a6aa844901acbb2fbfc09c95bb34', '[\"*\"]', NULL, '2021-06-10 06:31:50', '2021-06-10 06:31:50'),
(51, 'App\\Models\\User', 26, 'auth_token', 'c792344d1730dde4e418f6380309b24767062dc5e9c6757fce88675f7bbff9f3', '[\"*\"]', NULL, '2021-06-10 08:38:29', '2021-06-10 08:38:29'),
(53, 'App\\Models\\User', 24, 'auth_token', '36c0eb2f6065deb315bd996e158aed1d6c06f4a04879317bcf1961ea786a675c', '[\"*\"]', '2021-06-10 13:04:13', '2021-06-10 09:36:52', '2021-06-10 13:04:13'),
(54, 'App\\Models\\User', 24, 'auth_token', 'ddcfe3a5d501093c86a0a376a125099517199ea17ee9d4d78be12e476e413b40', '[\"*\"]', '2021-06-10 10:05:35', '2021-06-10 10:05:22', '2021-06-10 10:05:35'),
(55, 'App\\Models\\User', 24, 'auth_token', 'ecf248b74ee8bff942c22b299ccb3afe840a589b7dbd62b9897cbe46ea6c8941', '[\"*\"]', NULL, '2021-06-10 11:56:06', '2021-06-10 11:56:06'),
(58, 'App\\Models\\User', 8, 'auth_token', 'e572eaf82d8c9849394bb7790486730ab529e6ab53d9e4abc14dd69bd70bbd3f', '[\"*\"]', NULL, '2022-03-22 10:47:56', '2022-03-22 10:47:56'),
(59, 'App\\Models\\User', 8, 'auth_token', '21b0d071e22f45a7520c36b825b4f2582037004ee019e67707a4c6cabcbc9375', '[\"*\"]', '2022-04-05 05:13:26', '2022-03-22 10:48:33', '2022-04-05 05:13:26'),
(60, 'App\\Models\\User', 31, 'auth_token', '29647be4a8b5510c717c50b8279d168717ebcc25b3d0155fcc840cd315527112', '[\"*\"]', NULL, '2022-03-22 11:22:57', '2022-03-22 11:22:57'),
(61, 'App\\Models\\User', 8, 'auth_token', '9b103d59a6f148c7153e4c411fac11bf46e8ebeb886835c967a3f3896476da29', '[\"*\"]', '2022-04-16 06:29:21', '2022-03-29 08:05:49', '2022-04-16 06:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `reviewers`
--

CREATE TABLE `reviewers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviewers`
--

INSERT INTO `reviewers` (`id`, `name`, `email`, `username`, `mobile`, `image`, `password`, `created_at`, `updated_at`) VALUES
(2, 'Test Reviewer', 'testreviewer@gmail.com', 'reviewer', '880112233445566', '659298b5571201704106165.jpg', '$2y$10$qhDtHc4xhuSstAnepJMVle8LJjvOobHYUHzTd.hFZMfuQGl6c354G', '2023-12-30 11:08:58', '2024-01-01 10:54:57'),
(3, 'Test Review 2', 'testreviewer2@gmail.com', 'reviewer2', '880123456789', '658ffad94756e1703934681.jpg', '$2y$10$CeDWSnR/a0vJplTyKfjOJu07xlL8dhmhTqb2u91gDZu8.IfForFfG', '2023-12-30 11:11:22', '2024-01-05 16:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Italy', 1, '2025-05-03 08:32:46', '2025-05-28 13:40:46'),
(2, 'United States', 1, '2025-05-07 12:48:24', '2025-05-28 13:40:20'),
(3, 'Florida', 1, '2025-05-13 09:32:30', '2025-05-28 13:39:22'),
(4, 'Spain', 1, '2025-05-28 13:41:37', '2025-05-28 13:41:37'),
(5, 'Germany', 1, '2025-05-28 13:42:02', '2025-05-28 13:42:02'),
(6, 'Singapore', 1, '2025-05-28 13:42:27', '2025-05-28 13:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `storage_providers`
--

CREATE TABLE `storage_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `handler` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `credentials` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:Disabled 1:Enabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage_providers`
--

INSERT INTO `storage_providers` (`id`, `name`, `alias`, `handler`, `logo`, `credentials`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Local Storage', 'local', 'App\\Http\\Controllers\\Storage\\LocalController', '668bb046004c61720430662.png', NULL, 1, '2022-02-20 21:13:06', '2025-05-27 16:01:34'),
(2, 'Amazon S3', 's3', 'App\\Http\\Controllers\\Storage\\AmazonController', '67c31635c72b21740838453.png', '{\"access_key_id\":\"AKIAU43BSAYIO5ZEZLXO\",\"secret_access_key\":\"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\",\"default_region\":\"us-east-1\",\"bucket\":\"maldivesstockphotos\",\"url\":\"https:\\/\\/s3.ap-southeast-1.wasabisys.com\\/\",\"endpoint\":\"https:\\/\\/s3.ap-southeast-1.wasabisys.com\\/\"}', 0, '2022-02-20 21:12:55', '2025-05-27 16:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `created_at`, `updated_at`) VALUES
(4, 'mahadi@gmail.com', '2023-12-18 06:39:31', '2023-12-18 06:39:31'),
(5, 'redwan@gmail.com', '2023-12-18 06:40:03', '2023-12-18 06:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(10) UNSIGNED DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_attachments`
--

INSERT INTO `support_attachments` (`id`, `support_message_id`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 6, '5ff1cd83c827a1609682307.jpg', '2021-01-03 07:58:27', '2021-01-03 07:58:27'),
(2, 8, '5ff1d3c9a3c591609683913.jpg', '2021-01-03 08:25:13', '2021-01-03 08:25:13'),
(3, 9, '5ff1d3d69ab511609683926.png', '2021-01-03 08:25:26', '2021-01-03 08:25:26'),
(4, 10, '5ff2a60b733881609737739.jpg', '2021-01-03 23:22:19', '2021-01-03 23:22:19'),
(5, 11, '5ff2a61b5e0241609737755.jpg', '2021-01-03 23:22:35', '2021-01-03 23:22:35'),
(6, 12, '5ff2a62da8a951609737773.jpg', '2021-01-03 23:22:53', '2021-01-03 23:22:53'),
(7, 21, '5ff2bbbb6897b1609743291.docx', '2021-01-04 00:54:51', '2021-01-04 00:54:51'),
(8, 35, '5ff2bea23c7991609744034.docx', '2021-01-04 01:07:14', '2021-01-04 01:07:14'),
(9, 35, '5ff2bea23d8fa1609744034.docx', '2021-01-04 01:07:14', '2021-01-04 01:07:14'),
(10, 38, '5ff2bfbf2f9481609744319.docx', '2021-01-04 01:11:59', '2021-01-04 01:11:59'),
(11, 43, '5ff2dac6e521a1609751238.docx', '2021-01-04 03:07:18', '2021-01-04 03:07:18'),
(14, 53, '6094f795dfa401620375445.png', '2021-05-07 07:47:25', '2021-05-07 07:47:25'),
(15, 54, '6094f830810e01620375600.png', '2021-05-07 07:50:00', '2021-05-07 07:50:00'),
(16, 58, '6098ce4aa0f8a1620627018.png', '2021-05-10 05:40:18', '2021-05-10 05:40:18'),
(17, 59, '6098ce5f55e341620627039.png', '2021-05-10 05:40:39', '2021-05-10 05:40:39'),
(18, 59, '6098ce5f5a8e61620627039.png', '2021-05-10 05:40:39', '2021-05-10 05:40:39'),
(20, 66, '60a638a1cc01f1621506209.docx', '2021-05-20 09:53:29', '2021-05-20 09:53:29'),
(21, 68, '60bb580fc47f71622890511.png', '2021-06-05 10:25:11', '2021-06-05 10:25:11'),
(22, 69, '60bb581a0ff221622890522.docx', '2021-06-05 10:25:22', '2021-06-05 10:25:22'),
(23, 100, '62383bec3d82d1647852524.png', '2022-03-21 02:48:44', '2022-03-21 02:48:44'),
(24, 107, '6239a78108aec1647945601.png', '2022-03-22 09:10:02', '2022-03-22 09:10:02'),
(25, 110, '6239ab121e9221647946514.jpeg', '2022-03-22 09:25:14', '2022-03-22 09:25:14'),
(26, 110, '6239ab12402461647946514.jpeg', '2022-03-22 09:25:14', '2022-03-22 09:25:14'),
(29, 119, '624938901eab21648965776.pdf', '2022-04-03 04:32:56', '2022-04-03 04:32:56'),
(30, 119, '6249389030f681648965776.pdf', '2022-04-03 04:32:56', '2022-04-03 04:32:56'),
(31, 119, '624938905867d1648965776.pdf', '2022-04-03 04:32:56', '2022-04-03 04:32:56'),
(32, 119, '624938906b5621648965776.pdf', '2022-04-03 04:32:56', '2022-04-03 04:32:56'),
(33, 119, '62493890778f91648965776.pdf', '2022-04-03 04:32:56', '2022-04-03 04:32:56'),
(34, 121, '624a8a4eaa9911649052238.pdf', '2022-04-04 04:33:58', '2022-04-04 04:33:58'),
(35, 121, '624a8a4eb21b21649052238.pdf', '2022-04-04 04:33:58', '2022-04-04 04:33:58'),
(36, 121, '624a8a4eb7ff01649052238.pdf', '2022-04-04 04:33:58', '2022-04-04 04:33:58'),
(37, 121, '624a8a4ebe4e91649052238.pdf', '2022-04-04 04:33:58', '2022-04-04 04:33:58'),
(38, 121, '624a8a4ec435b1649052238.pdf', '2022-04-04 04:33:58', '2022-04-04 04:33:58'),
(39, 122, '624bd7bd9f77b1649137597.pdf', '2022-04-05 04:16:37', '2022-04-05 04:16:37'),
(40, 123, '624ea914315121649322260.png', '2022-04-07 07:34:20', '2022-04-07 07:34:20'),
(41, 123, '624ea9147c6e51649322260.png', '2022-04-07 07:34:20', '2022-04-07 07:34:20'),
(42, 123, '624ea914851b41649322260.png', '2022-04-07 07:34:20', '2022-04-07 07:34:20'),
(43, 123, '624ea914a995e1649322260.png', '2022-04-07 07:34:20', '2022-04-07 07:34:20'),
(44, 123, '624ea914b3cfa1649322260.png', '2022-04-07 07:34:20', '2022-04-07 07:34:20'),
(45, 136, '624eab9c85d3f1649322908.png', '2022-04-07 07:45:08', '2022-04-07 07:45:08'),
(46, 147, '65843282ef1f01703162498.jpg', '2023-12-21 12:41:39', '2023-12-21 12:41:39'),
(47, 147, '65843283c11881703162499.jpg', '2023-12-21 12:41:40', '2023-12-21 12:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_messages`
--

INSERT INTO `support_messages` (`id`, `support_ticket_id`, `admin_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'sdfgsfdsdfg', '2021-01-03 06:14:26', '2021-01-03 06:14:26'),
(2, 1, 1, 'asdfasdf asdfasdf', '2021-01-03 06:16:15', '2021-01-03 06:16:15'),
(3, 1, 0, 'dsfgdfghdfg dgfhdf dgh', '2021-01-03 06:46:03', '2021-01-03 06:46:03'),
(4, 1, 0, 'sdf aesgsdfg', '2021-01-03 06:46:34', '2021-01-03 06:46:34'),
(5, 1, 1, 'asdfasdfattachment', '2021-01-03 07:58:23', '2021-01-03 07:58:23'),
(6, 1, 1, 'asdfasdfattachment', '2021-01-03 07:58:27', '2021-01-03 07:58:27'),
(7, 2, 0, 'sdfg', '2021-01-03 08:24:45', '2021-01-03 08:24:45'),
(8, 2, 0, 'asdfasdf', '2021-01-03 08:25:13', '2021-01-03 08:25:13'),
(9, 3, 0, 'ffddffdff', '2021-01-03 08:25:26', '2021-01-03 08:25:26'),
(10, 2, 1, 'ff', '2021-01-03 23:22:19', '2021-01-03 23:22:19'),
(11, 2, 1, 'fff', '2021-01-03 23:22:35', '2021-01-03 23:22:35'),
(12, 1, 1, 'ffff', '2021-01-03 23:22:53', '2021-01-03 23:22:53'),
(13, 4, 0, 'asdfasdf', '2021-01-04 00:27:08', '2021-01-04 00:27:08'),
(14, 5, 0, 'asdfasdf', '2021-01-04 00:27:51', '2021-01-04 00:27:51'),
(15, 6, 0, 'asdfasdf', '2021-01-04 00:28:04', '2021-01-04 00:28:04'),
(16, 7, 0, 'asdfasdf', '2021-01-04 00:29:37', '2021-01-04 00:29:37'),
(17, 8, 0, 'asdfasdf', '2021-01-04 00:30:23', '2021-01-04 00:30:23'),
(19, 10, 0, 'asdf', '2021-01-04 00:54:35', '2021-01-04 00:54:35'),
(20, 11, 0, 'asdf', '2021-01-04 00:54:41', '2021-01-04 00:54:41'),
(21, 12, 0, 'asdf', '2021-01-04 00:54:51', '2021-01-04 00:54:51'),
(22, 12, 0, 'asdf', '2021-01-04 01:01:07', '2021-01-04 01:01:07'),
(23, 12, 0, 'asdf', '2021-01-04 01:01:31', '2021-01-04 01:01:31'),
(24, 12, 0, 'sdfg', '2021-01-04 01:02:18', '2021-01-04 01:02:18'),
(25, 12, 0, 'asdfasdf', '2021-01-04 01:02:49', '2021-01-04 01:02:49'),
(26, 12, 0, 'asdfasdf', '2021-01-04 01:02:55', '2021-01-04 01:02:55'),
(27, 12, 0, 'asdf', '2021-01-04 01:03:24', '2021-01-04 01:03:24'),
(28, 12, 0, 'asdf', '2021-01-04 01:03:33', '2021-01-04 01:03:33'),
(29, 12, 0, 'asdf', '2021-01-04 01:03:41', '2021-01-04 01:03:41'),
(30, 12, 0, 'asdf', '2021-01-04 01:03:51', '2021-01-04 01:03:51'),
(31, 12, 0, 'asdf', '2021-01-04 01:04:09', '2021-01-04 01:04:09'),
(32, 12, 0, 'asdf', '2021-01-04 01:04:29', '2021-01-04 01:04:29'),
(33, 12, 0, 'asdf', '2021-01-04 01:04:34', '2021-01-04 01:04:34'),
(34, 12, 0, 'ghdgh', '2021-01-04 01:06:45', '2021-01-04 01:06:45'),
(35, 12, 0, 'asdfasd', '2021-01-04 01:07:14', '2021-01-04 01:07:14'),
(36, 11, 1, 'asdfasdf', '2021-01-04 01:09:58', '2021-01-04 01:09:58'),
(37, 11, 1, 'asdfasdf', '2021-01-04 01:10:13', '2021-01-04 01:10:13'),
(38, 12, 0, 'asdfsfg sdfgdsfg hdfghdfghdfghdfghdfghdfghdfgh', '2021-01-04 01:11:59', '2021-01-04 01:11:59'),
(39, 12, 1, 'dfghfgj', '2021-01-04 03:05:42', '2021-01-04 03:05:42'),
(40, 12, 1, 'asdf', '2021-01-04 03:06:01', '2021-01-04 03:06:01'),
(41, 12, 1, 'asdf', '2021-01-04 03:06:15', '2021-01-04 03:06:15'),
(42, 12, 1, 'asdf', '2021-01-04 03:06:24', '2021-01-04 03:06:24'),
(43, 12, 1, 'asdf', '2021-01-04 03:07:18', '2021-01-04 03:07:18'),
(44, 13, 0, 'sdfsadfsdfg', '2021-03-06 01:03:48', '2021-03-06 01:03:48'),
(45, 13, 1, 'dfasdfasdfasdf', '2021-03-06 01:03:59', '2021-03-06 01:03:59'),
(46, 14, 0, 'asdasdfasdf', '2021-03-15 04:30:17', '2021-03-15 04:30:17'),
(47, 17, 0, 'asdf', '2021-03-15 04:32:52', '2021-03-15 04:32:52'),
(48, 18, 0, 'asdfasdf', '2021-05-03 10:39:08', '2021-05-03 10:39:08'),
(49, 19, 0, 'sdfgsdfg', '2021-05-07 07:40:50', '2021-05-07 07:40:50'),
(50, 19, 0, 'adsfadsf', '2021-05-07 07:43:15', '2021-05-07 07:43:15'),
(53, 20, 0, 'asdf', '2021-05-07 07:47:25', '2021-05-07 07:47:25'),
(54, 20, 0, 'asdf', '2021-05-07 07:50:00', '2021-05-07 07:50:00'),
(55, 21, 0, 'asdfasdf', '2021-05-08 04:20:10', '2021-05-08 04:20:10'),
(56, 22, 0, 'sdfgsdfg', '2021-05-09 04:48:46', '2021-05-09 04:48:46'),
(57, 23, 0, 'dfgsdfgsdfg', '2021-05-09 04:52:37', '2021-05-09 04:52:37'),
(58, 24, 0, 'sdfgsdfgsfdg', '2021-05-10 05:40:18', '2021-05-10 05:40:18'),
(59, 24, 0, 'asdfasdf', '2021-05-10 05:40:39', '2021-05-10 05:40:39'),
(60, 25, 0, 'sdfgsdfg', '2021-05-10 05:44:39', '2021-05-10 05:44:39'),
(61, 25, 1, 'asdfasdf', '2021-05-12 04:34:37', '2021-05-12 04:34:37'),
(63, 26, 0, 'asdfgsadfgasdfasdf', '2021-05-18 05:13:17', '2021-05-18 05:13:17'),
(64, 26, 0, 'dfgsdfgsdfgsdfg', '2021-05-18 05:15:37', '2021-05-18 05:15:37'),
(65, 26, 1, 'asdfasdfasdf', '2021-05-18 05:19:15', '2021-05-18 05:19:15'),
(66, 24, 1, 'ZXCZXC', '2021-05-20 09:53:29', '2021-05-20 09:53:29'),
(67, 24, 0, 'gfsdfgsdfg', '2021-05-30 11:42:17', '2021-05-30 11:42:17'),
(68, 27, 0, 'sdfgsdfg', '2021-06-05 10:25:11', '2021-06-05 10:25:11'),
(69, 27, 0, 'sdfgsdfg', '2021-06-05 10:25:22', '2021-06-05 10:25:22'),
(70, 27, 1, 'asdfasdfasdf', '2021-06-05 13:18:55', '2021-06-05 13:18:55'),
(71, 21, 1, 'rftghdfghdfgh', '2021-06-05 13:28:57', '2021-06-05 13:28:57'),
(72, 21, 1, 'rftghdfghdfgh', '2021-06-05 13:29:15', '2021-06-05 13:29:15'),
(73, 28, 0, 'rgtsdfgsdfg', '2021-06-17 12:19:16', '2021-06-17 12:19:16'),
(74, 29, 0, 'asdfasdf', '2021-06-17 12:20:26', '2021-06-17 12:20:26'),
(75, 30, 0, 'asdfasdf', '2021-06-17 12:22:10', '2021-06-17 12:22:10'),
(76, 31, 0, 'Sed tenetur voluptat', '2022-02-23 00:57:45', '2022-02-23 00:57:45'),
(77, 32, 0, 'Sint doloremque aut', '2022-02-23 00:58:05', '2022-02-23 00:58:05'),
(78, 33, 0, 'Aperiam lorem cupidi', '2022-02-23 01:12:51', '2022-02-23 01:12:51'),
(79, 34, 0, 'Aperiam lorem cupidi', '2022-02-23 01:12:59', '2022-02-23 01:12:59'),
(80, 35, 0, 'Consectetur in qui', '2022-02-23 01:13:10', '2022-02-23 01:13:10'),
(81, 36, 0, 'Consectetur in qui', '2022-02-23 01:13:21', '2022-02-23 01:13:21'),
(82, 37, 0, 'Atque magnam exercit', '2022-02-23 01:13:33', '2022-02-23 01:13:33'),
(83, 38, 0, 'Quidem aut accusanti', '2022-02-23 01:15:29', '2022-02-23 01:15:29'),
(84, 39, 0, 'Possimus excepteur', '2022-02-23 01:16:40', '2022-02-23 01:16:40'),
(85, 40, 0, 'Ea molestiae aut eni', '2022-02-23 01:17:29', '2022-02-23 01:17:29'),
(86, 41, 0, 'In qui nulla ullamco', '2022-02-23 01:17:42', '2022-02-23 01:17:42'),
(87, 42, 0, 'Quia natus voluptati', '2022-02-23 01:19:12', '2022-02-23 01:19:12'),
(88, 43, 0, 'Quia natus voluptati', '2022-02-23 01:19:20', '2022-02-23 01:19:20'),
(89, 44, 0, 'Nostrud itaque reici', '2022-02-23 01:58:43', '2022-02-23 01:58:43'),
(90, 45, 0, 'sdfg', '2022-02-23 07:50:09', '2022-02-23 07:50:09'),
(91, 46, 0, 'sdfg', '2022-02-23 07:50:59', '2022-02-23 07:50:59'),
(92, 47, 0, 'Natus adipisicing qu', '2022-03-05 06:32:42', '2022-03-05 06:32:42'),
(94, 30, 0, 'ff', '2022-03-19 05:57:32', '2022-03-19 05:57:32'),
(95, 30, 0, '0000000000', '2022-03-19 06:01:04', '2022-03-19 06:01:04'),
(96, 30, 0, 'ggggg', '2022-03-19 06:01:21', '2022-03-19 06:01:21'),
(97, 30, 0, 'ff', '2022-03-19 06:01:54', '2022-03-19 06:01:54'),
(98, 30, 0, 'sdfsdf', '2022-03-19 06:02:50', '2022-03-19 06:02:50'),
(99, 30, 0, 'asdf', '2022-03-21 00:35:33', '2022-03-21 00:35:33'),
(100, 47, 1, 'asdfasdf', '2022-03-21 02:48:44', '2022-03-21 02:48:44'),
(101, 48, 0, 'Explicabo Dignissim', '2022-03-22 08:30:31', '2022-03-22 08:30:31'),
(102, 48, 0, 'asdfgsdfg', '2022-03-22 08:32:54', '2022-03-22 08:32:54'),
(103, 49, 0, 'Dignissimos eos et t', '2022-03-22 08:58:43', '2022-03-22 08:58:43'),
(104, 49, 0, 'asdfasdf', '2022-03-22 09:07:03', '2022-03-22 09:07:03'),
(105, 49, 1, 'fffffff', '2022-03-22 09:07:47', '2022-03-22 09:07:47'),
(107, 49, 0, 'sdrgsdfg', '2022-03-22 09:10:00', '2022-03-22 09:10:00'),
(108, 49, 1, 'sdfggggggggggggggggggggggggg  dddddddddddddd', '2022-03-22 09:17:28', '2022-03-22 09:17:28'),
(109, 49, 1, 'sdfgsfg', '2022-03-22 09:18:35', '2022-03-22 09:18:35'),
(110, 49, 1, 'asdfasdfadsf', '2022-03-22 09:25:14', '2022-03-22 09:25:14'),
(112, 49, 1, 'gg', '2022-03-30 09:42:35', '2022-03-30 09:42:35'),
(113, 49, 1, 'gg', '2022-03-30 09:43:24', '2022-03-30 09:43:24'),
(114, 49, 1, 'gg', '2022-03-30 09:44:19', '2022-03-30 09:44:19'),
(115, 49, 1, 'gg', '2022-03-30 09:50:10', '2022-03-30 09:50:10'),
(116, 49, 1, 'gg', '2022-03-30 09:50:30', '2022-03-30 09:50:30'),
(118, 50, 0, 'Quo tempor doloremqu', '2022-04-03 03:39:13', '2022-04-03 03:39:13'),
(119, 36, 1, 'ff', '2022-04-03 04:32:56', '2022-04-03 04:32:56'),
(120, 51, 0, 'In in totam nobis om', '2022-04-03 07:52:21', '2022-04-03 07:52:21'),
(121, 51, 1, 'h', '2022-04-04 04:33:58', '2022-04-04 04:33:58'),
(122, 51, 1, 'sdfg', '2022-04-05 04:16:37', '2022-04-05 04:16:37'),
(123, 51, 1, 'dfgsdfg sdfg sd', '2022-04-07 07:34:20', '2022-04-07 07:34:20'),
(124, 51, 1, 'sadfasdf asdfasdfasdf', '2022-04-07 07:34:31', '2022-04-07 07:34:31'),
(125, 49, 1, 'sdfg sfgsfg', '2022-04-07 07:35:03', '2022-04-07 07:35:03'),
(126, 51, 1, 'adsfasdf', '2022-04-07 07:37:11', '2022-04-07 07:37:11'),
(127, 51, 1, 'adsfasdf', '2022-04-07 07:37:48', '2022-04-07 07:37:48'),
(128, 51, 1, 'adsfasdf', '2022-04-07 07:37:58', '2022-04-07 07:37:58'),
(129, 51, 1, 'adsfasdf', '2022-04-07 07:38:07', '2022-04-07 07:38:07'),
(130, 51, 1, 'adsfasdf', '2022-04-07 07:38:36', '2022-04-07 07:38:36'),
(131, 51, 1, 'adsfasdf', '2022-04-07 07:38:43', '2022-04-07 07:38:43'),
(132, 51, 1, 'adsfasdf', '2022-04-07 07:38:55', '2022-04-07 07:38:55'),
(133, 51, 1, 'adsfasdf', '2022-04-07 07:40:28', '2022-04-07 07:40:28'),
(134, 51, 1, 'adsfasdf', '2022-04-07 07:40:45', '2022-04-07 07:40:45'),
(135, 51, 1, 'asdfsadfsdf', '2022-04-07 07:42:34', '2022-04-07 07:42:34'),
(136, 51, 1, 'j', '2022-04-07 07:45:08', '2022-04-07 07:45:08'),
(137, 52, 0, 'Quia lorem iusto in', '2022-04-09 02:12:51', '2022-04-09 02:12:51'),
(138, 52, 0, 'asdfasdf asdfasdf', '2022-04-09 02:12:57', '2022-04-09 02:12:57'),
(139, 52, 0, 'asdfadsf', '2022-04-09 02:13:26', '2022-04-09 02:13:26'),
(140, 52, 0, 'asdf', '2022-04-09 02:14:33', '2022-04-09 02:14:33'),
(141, 52, 1, 'dfsdfgsdfg', '2022-09-26 14:01:26', '2022-09-26 14:01:26'),
(142, 53, 0, 'In sit consequat Te', '2023-12-20 05:40:50', '2023-12-20 05:40:50'),
(143, 54, 0, 'asdf', '2023-12-20 12:06:19', '2023-12-20 12:06:19'),
(144, 55, 0, 'fasdf', '2023-12-20 12:54:23', '2023-12-20 12:54:23'),
(145, 55, 1, 'asdf', '2023-12-21 12:28:44', '2023-12-21 12:28:44'),
(146, 55, 0, 'hello', '2023-12-21 12:41:08', '2023-12-21 12:41:08'),
(147, 55, 0, 'asdf', '2023-12-21 12:41:38', '2023-12-21 12:41:38'),
(148, 55, 1, 'asdf', '2023-12-21 12:42:03', '2023-12-21 12:42:03'),
(149, 56, 0, 'asdf', '2023-12-21 12:43:51', '2023-12-21 12:43:51'),
(150, 57, 0, 'asdfasdf', '2023-12-21 12:46:35', '2023-12-21 12:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `ticket` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT 'enable:1, disable:0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'People', 1, '2022-10-03 17:23:55', '2023-12-28 06:27:24'),
(2, 'Warehouse', 1, '2022-11-28 07:09:23', '2022-11-28 07:09:23'),
(3, 'Building', 1, '2022-11-28 07:09:32', '2022-11-28 07:09:32'),
(4, 'Duplex', 1, '2022-11-28 07:09:40', '2022-11-28 07:09:40'),
(5, 'Nature', 1, '2022-11-28 07:09:49', '2023-12-28 06:27:07'),
(6, 'Plazza', 1, '2022-11-28 07:09:58', '2022-11-28 07:11:37'),
(8, 'Animal', 1, '2023-11-22 06:39:17', '2023-12-28 06:26:29'),
(9, 'Sports', 1, '2023-11-22 06:45:59', '2023-12-28 06:24:31'),
(10, 'Food', 1, '2023-12-28 06:22:47', '2023-12-28 06:24:22'),
(11, 'Testy', 1, '2024-01-09 11:31:55', '2024-01-09 11:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(40) DEFAULT NULL,
  `trx` varchar(40) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `amount`, `charge`, `post_balance`, `trx_type`, `trx`, `details`, `remark`, `created_at`, `updated_at`) VALUES
(1, 2, 200.00000000, 3.00000000, 600.00000000, '+', '63WW3JFN49MM', 'Deposit Via ABC Bank', 'deposit', '2025-05-20 09:16:19', '2025-05-20 09:16:19'),
(2, 2, 200.00000000, 3.00000000, 1600.00000000, '+', 'VT6GZ39WB4UW', 'Deposit Via ABC Bank', 'deposit', '2025-05-20 09:31:13', '2025-05-20 09:31:13'),
(3, 2, 278.00000000, 3.78000000, 1322.00000000, '+', 'GAGO9OWY6YHA', 'Deposit Via ABC Bank', 'deposit', '2025-05-20 09:34:56', '2025-05-20 09:34:56'),
(4, 2, 278.00000000, 3.78000000, 1322.00000000, '+', 'P2YR6F26YEWB', 'Deposit Via ABC Bank', 'deposit', '2025-05-20 09:38:25', '2025-05-20 09:38:25'),
(5, 2, 278.00000000, 3.78000000, 1322.00000000, '+', 'P2YR6F26YEWB', 'Deposit Via ABC Bank', 'deposit', '2025-05-20 09:38:52', '2025-05-20 09:38:52'),
(6, 2, 278.00000000, 3.78000000, 1322.00000000, '+', 'P2YR6F26YEWB', 'Deposit Via ABC Bank', 'deposit', '2025-05-20 09:40:40', '2025-05-20 09:40:40'),
(7, 2, 250.00000000, 3.50000000, 1072.00000000, '+', 'KTC9R2VHDK9P', 'Deposit Via ABC Bank', 'deposit', '2025-05-20 09:43:56', '2025-05-20 09:43:56'),
(8, 2, 250.00000000, 3.50000000, 822.00000000, '+', '6O5GDGTYS88R', 'PaymentABC Bank', 'payment', '2025-05-20 10:33:30', '2025-05-20 10:33:30'),
(9, 2, 100.00000000, 2.00000000, 922.00000000, '+', '5RAZSYC53GUD', 'DepositABC Bank', 'balance', '2025-05-20 10:41:40', '2025-05-20 10:41:40'),
(10, 2, 177.00000000, 2.77000000, 568.00000000, '+', '756KCJ1W8O8H', 'Payment ABC Bank', 'payment', '2025-05-20 11:46:23', '2025-05-20 11:46:23'),
(11, 1, 200.00000000, 0.02000000, 831.00000000, '-', 'ZYK31J4KJQA1', '199.98 USD Withdraw Via Mobile Banking', 'withdraw', '2025-05-20 15:55:30', '2025-05-20 15:55:30'),
(12, 2, 200.00000000, 3.00000000, 568.00000000, '+', 'TPP7EHZGUSRV', 'Payment ABC Bank', 'payment', '2025-05-29 14:47:41', '2025-05-29 14:47:41'),
(13, 2, 200.00000000, 3.00000000, 568.00000000, '+', 'SCA5NB1MRUT6', 'Payment ABC Bank', 'payment', '2025-05-29 14:51:07', '2025-05-29 14:51:07'),
(14, 2, 230.00000000, 3.30000000, 842.50000000, '+', '22WVAWNYD9JM', 'Payment ABC Bank', 'payment', '2025-05-29 14:57:33', '2025-05-29 14:57:33'),
(15, 2, 230.00000000, 3.30000000, 854.00000000, '+', 'JDUU3N8FDGAQ', 'Payment ABC Bank', 'payment', '2025-05-29 14:59:08', '2025-05-29 14:59:08'),
(16, 2, 200.00000000, 3.00000000, 244.00000000, '+', 'MCMFGTBD2RBJ', 'Payment ABC Bank', 'payment', '2025-05-31 12:40:59', '2025-05-31 12:40:59'),
(17, 3, 200.00000000, 3.00000000, 568.00000000, '+', 'PDZ9FDBZCETV', 'Payment ABC Bank', 'payment', '2025-06-17 20:53:18', '2025-06-17 20:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` tinyint(4) NOT NULL COMMENT '	1 = user , 2 = contributor',
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `ref_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_count` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `kyc_data` text DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: mobile unverified, 1: mobile verified',
  `reg_step` tinyint(1) NOT NULL DEFAULT 0,
  `ver_code` varchar(40) DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) DEFAULT NULL,
  `ban_reason` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `firstname`, `lastname`, `username`, `email`, `country_code`, `mobile`, `ref_by`, `balance`, `password`, `image`, `image_count`, `address`, `status`, `kyc_data`, `kv`, `ev`, `sv`, `reg_step`, `ver_code`, `ver_code_send_at`, `ts`, `tv`, `tsc`, `ban_reason`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 2, 'Contributor User', 'user', 'testuser', 'testuser@gmail.com', 'GB', '4402542685253', 0, 854.00000000, '$2y$10$CMDwilpB6uyA6cXV2ERz7.mSuq4vktVewXETz5LjtdSzd950JFHpm', '67f5099d2323e1744112029.png', NULL, '{\"address\":\"America,USA\",\"state\":\"America\",\"zip\":\"1230\",\"country\":\"United Kingdom\",\"city\":\"America\"}', 1, NULL, 1, 1, 1, 1, NULL, NULL, 0, 1, NULL, NULL, NULL, '2025-03-03 11:01:58', '2025-06-05 06:44:21'),
(2, 1, 'Buyer', 'User', 'sasovo', 'sasovo@mailinator.com', 'EG', '2078', 0, 144.01000000, '$2y$10$CMDwilpB6uyA6cXV2ERz7.mSuq4vktVewXETz5LjtdSzd950JFHpm', NULL, NULL, '{\"address\":\"America,USA\",\"state\":\"America\",\"zip\":\"1230\",\"country\":\"Egypt\",\"city\":\"America\"}', 1, NULL, 1, 1, 1, 1, NULL, NULL, 0, 1, NULL, NULL, NULL, '2025-05-07 08:46:16', '2025-06-12 07:49:34'),
(3, 1, 'naira', 'user', 'naira', 'naira@mailinator.com', 'EG', '2078', 0, 568.00000000, '$2y$10$CMDwilpB6uyA6cXV2ERz7.mSuq4vktVewXETz5LjtdSzd950JFHpm', NULL, NULL, '{\"country\":\"Egypt\",\"address\":\"America,USA\",\"state\":\"America\",\"zip\":\"1230\",\"city\":\"America\"}', 1, NULL, 1, 1, 1, 1, NULL, NULL, 0, 1, NULL, NULL, NULL, '2025-05-07 08:46:16', '2025-05-20 11:26:02'),
(4, 2, 'tes2', 'user2', 'testuser2', 'testuser2@gmail.com', 'GB', '44025426852534441', 0, 0.00000000, '$2y$10$CMDwilpB6uyA6cXV2ERz7.mSuq4vktVewXETz5LjtdSzd950JFHpm', '67f5099d2323e1744112029.png', NULL, '{\"address\":\"America,USA\",\"city\":\"America\",\"state\":\"America\",\"zip\":\"1230\",\"country\":\"United Kingdom\"}', 1, NULL, 1, 1, 1, 1, NULL, NULL, 0, 1, NULL, NULL, NULL, '2025-03-03 11:01:58', '2025-05-20 15:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_ip` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `longitude` varchar(40) DEFAULT NULL,
  `latitude` varchar(40) DEFAULT NULL,
  `browser` varchar(40) DEFAULT NULL,
  `os` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logins`
--

INSERT INTO `user_logins` (`id`, `user_id`, `user_ip`, `city`, `country`, `country_code`, `longitude`, `latitude`, `browser`, `os`, `created_at`, `updated_at`) VALUES
(1, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-03-03 11:01:58', '2025-03-03 11:01:58'),
(2, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-04-08 09:58:31', '2025-04-08 09:58:31'),
(3, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-04-30 13:31:54', '2025-04-30 13:31:54'),
(4, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-01 05:50:13', '2025-05-01 05:50:13'),
(5, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-07 06:32:39', '2025-05-07 06:32:39'),
(6, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-07 08:46:16', '2025-05-07 08:46:16'),
(7, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-07 09:11:07', '2025-05-07 09:11:07'),
(8, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-08 06:58:18', '2025-05-08 06:58:18'),
(9, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-08 07:25:10', '2025-05-08 07:25:10'),
(10, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-10 06:15:57', '2025-05-10 06:15:57'),
(11, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-12 14:00:01', '2025-05-12 14:00:01'),
(12, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-12 14:01:10', '2025-05-12 14:01:10'),
(13, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-13 14:30:43', '2025-05-13 14:30:43'),
(14, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-17 06:29:28', '2025-05-17 06:29:28'),
(15, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-19 07:15:55', '2025-05-19 07:15:55'),
(16, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-19 07:20:14', '2025-05-19 07:20:14'),
(17, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-19 09:02:57', '2025-05-19 09:02:57'),
(18, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-19 09:19:19', '2025-05-19 09:19:19'),
(19, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-19 10:24:40', '2025-05-19 10:24:40'),
(20, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-20 05:33:18', '2025-05-20 05:33:18'),
(21, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-20 06:07:21', '2025-05-20 06:07:21'),
(22, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-20 06:30:46', '2025-05-20 06:30:46'),
(23, 3, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-20 15:45:58', '2025-05-20 15:45:58'),
(24, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-20 15:47:47', '2025-05-20 15:47:47'),
(25, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-21 07:44:14', '2025-05-21 07:44:14'),
(26, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-21 09:32:15', '2025-05-21 09:32:15'),
(27, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-27 10:05:46', '2025-05-27 10:05:46'),
(28, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-28 10:25:57', '2025-05-28 10:25:57'),
(29, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-28 11:33:59', '2025-05-28 11:33:59'),
(30, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-29 09:10:10', '2025-05-29 09:10:10'),
(31, 4, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-29 10:52:01', '2025-05-29 10:52:01'),
(32, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-29 13:57:12', '2025-05-29 13:57:12'),
(33, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-31 08:36:39', '2025-05-31 08:36:39'),
(34, 2, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-31 08:46:27', '2025-05-31 08:46:27'),
(35, 1, '127.0.0.1', '', '', '', '', '', 'Chrome', 'Windows 10', '2025-05-31 13:55:12', '2025-05-31 13:55:12'),
(36, 1, '103.54.148.98', 'Dhaka', 'Bangladesh', 'BD', '90.4135', '23.7278', 'Handheld Browser', 'Android', '2025-06-04 19:31:56', '2025-06-04 19:31:56'),
(37, 2, '198.105.83.70', 'Palm Beach Gardens', 'United States', 'US', '-80.1407', '26.8238', 'Chrome', 'Windows 10', '2025-06-05 06:42:31', '2025-06-05 06:42:31'),
(38, 1, '198.105.83.70', 'Palm Beach Gardens', 'United States', 'US', '-80.1407', '26.8238', 'Chrome', 'Windows 10', '2025-06-05 06:43:57', '2025-06-05 06:43:57'),
(39, 1, '198.105.83.70', 'Palm Beach Gardens', 'United States', 'US', '-80.1407', '26.8238', 'Chrome', 'Windows 10', '2025-06-05 06:50:48', '2025-06-05 06:50:48'),
(40, 2, '198.105.83.70', 'Palm Beach Gardens', 'United States', 'US', '-80.1407', '26.8238', 'Chrome', 'Windows 10', '2025-06-05 06:52:47', '2025-06-05 06:52:47'),
(41, 2, '108.236.223.38', 'Miami Gardens', 'United States', 'US', '-80.2453', '25.9409', 'Chrome', 'Windows 10', '2025-06-12 07:48:57', '2025-06-12 07:48:57'),
(42, 1, '103.54.148.98', 'Dhaka', 'Bangladesh', 'BD', '90.4135', '23.7278', 'Chrome', 'Windows 10', '2025-06-17 19:53:45', '2025-06-17 19:53:45'),
(43, 1, '103.54.148.98', 'Dhaka', 'Bangladesh', 'BD', '90.4135', '23.7278', 'Chrome', 'Windows 10', '2025-06-17 20:35:43', '2025-06-17 20:35:43'),
(44, 3, '103.54.148.98', 'Dhaka', 'Bangladesh', 'BD', '90.4135', '23.7278', 'Chrome', 'Windows 10', '2025-06-17 20:36:39', '2025-06-17 20:36:39'),
(45, 2, '198.105.83.70', 'Palm Beach Gardens', 'United States', 'US', '-80.1407', '26.8238', 'Chrome', 'Windows 10', '2025-07-11 01:46:24', '2025-07-11 01:46:24'),
(46, 1, '198.105.83.70', 'Palm Beach Gardens', 'United States', 'US', '-80.1407', '26.8238', 'Chrome', 'Windows 10', '2025-07-11 02:01:59', '2025-07-11 02:01:59'),
(47, 1, '104.6.135.18', 'Homestead', 'United States', 'US', '-80.3973', '25.5333', 'Chrome', 'Windows 10', '2025-07-17 08:24:08', '2025-07-17 08:24:08'),
(48, 2, '104.6.135.18', 'Homestead', 'United States', 'US', '-80.3973', '25.5333', 'Chrome', 'Windows 10', '2025-07-17 08:24:52', '2025-07-17 08:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `data_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `data_id`, `type`, `created_at`, `updated_at`) VALUES
(5, 1, 2, 'listing', '2025-05-29 13:04:52', '2025-05-29 13:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `currency` varchar(40) DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(40) DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `withdraw_information` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `method_id`, `user_id`, `amount`, `currency`, `rate`, `charge`, `trx`, `final_amount`, `after_charge`, `withdraw_information`, `status`, `admin_feedback`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 200.00000000, 'USD', 1.00000000, 0.02000000, 'ZYK31J4KJQA1', 199.98000000, 199.98000000, '[{\"name\":\"Mobile Number\",\"type\":\"text\",\"value\":\"01235648\"}]', 1, NULL, '2025-05-20 15:55:26', '2025-05-20 15:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT 0.00000000,
  `max_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) DEFAULT 0.00000000,
  `rate` decimal(28,8) DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdraw_methods`
--

INSERT INTO `withdraw_methods` (`id`, `form_id`, `name`, `min_limit`, `max_limit`, `fixed_charge`, `rate`, `percent_charge`, `currency`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 'Tranfer from Bank', 1.00000000, 1000.00000000, 1.00000000, 1.00000000, 2.00, 'USD', '<p><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Please Provide The information Below:</span></p>', 1, '2022-03-30 09:09:11', '2022-09-29 09:54:58'),
(2, 14, 'Mobile Banking', 1.00000000, 1000.00000000, 0.00000000, 1.00000000, 0.01, 'USD', '<span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Please Provide The Information Below:</span><br>', 1, '2022-03-30 09:10:12', '2022-09-29 09:55:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `building_images`
--
ALTER TABLE `building_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counties`
--
ALTER TABLE `counties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_categories`
--
ALTER TABLE `image_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_category_descriptions`
--
ALTER TABLE `image_category_descriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listing_images`
--
ALTER TABLE `listing_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listing_units`
--
ALTER TABLE `listing_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage_providers`
--
ALTER TABLE `storage_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `building_images`
--
ALTER TABLE `building_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `counties`
--
ALTER TABLE `counties`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `image_categories`
--
ALTER TABLE `image_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `image_category_descriptions`
--
ALTER TABLE `image_category_descriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `listing_images`
--
ALTER TABLE `listing_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `listing_units`
--
ALTER TABLE `listing_units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `storage_providers`
--
ALTER TABLE `storage_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
