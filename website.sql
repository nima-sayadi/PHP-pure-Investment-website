-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jun 13, 2022 at 03:48 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `activation`
--

CREATE TABLE `activation` (
  `mail` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nav_records`
--

CREATE TABLE `nav_records` (
  `amount` varchar(255) NOT NULL,
  `inbox` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `from_who` varchar(255) NOT NULL,
  `to_who` varchar(255) NOT NULL,
  `short_msg` text NOT NULL,
  `msg` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`from_who`, `to_who`, `short_msg`, `msg`, `status`, `id`) VALUES
('سیستم', 'admins', 'شما یک درخواست <strong style=\'color:red;\'>ثبت کیف پول</strong> از کاربر <strong>نیما صیادی</strong> دریافت کردید.', 'شما یک درخواست <strong style=\'color:red;\'>ثبت کیف پول</strong> از کاربر <strong>نیما صیادی</strong> دریافت کردید.', 'seen', 3),
('سیستم', 'admins', 'شما یک درخواست <strong style=\'color:red;\'>ثبت کیف پول</strong> از کاربر <strong>نیما صیادی</strong> دریافت کردید.', 'شما یک درخواست <strong style=\'color:red;\'>ثبت کیف پول</strong> از کاربر <strong>نیما صیادی</strong> دریافت کردید.', 'seen', 4),
('سیستم', 'admins', 'شما یک <strong>درخواست خرید</strong> از <strong>نیما صیادی</strong> دریافت کردید.', 'شما یک <strong>درخواست خرید</strong> از <strong>نیما صیادی</strong> دریافت کردید.', 'seen', 5),
('سیستم', 'admins', 'شما یک <strong>درخواست خرید</strong> از <strong>نیما صیادی</strong> دریافت کردید.', 'شما یک <strong>درخواست خرید</strong> از <strong>نیما صیادی</strong> دریافت کردید.', 'seen', 6),
('سیستم', 'admins', 'شما یک <strong>درخواست خرید</strong> از <strong>نیما صیادی</strong> دریافت کردید.', 'شما یک <strong>درخواست خرید</strong> از <strong>نیما صیادی</strong> دریافت کردید.', 'seen', 7),
('سیستم', 'nimanima54@gmail.com', 'درخواست خرید شما <strong style=\'color:green;\'>تایید شد</strong>.', 'درخواست خرید شما <strong style=\'color:green;\'>تایید شد</strong>.', 'seen', 8),
('سیستم', 'nimanima54@gmail.com', 'درخواست خرید شما <strong style=\'color:green;\'>تایید شد</strong>.', 'درخواست خرید شما <strong style=\'color:green;\'>تایید شد</strong>.', 'seen', 9),
('سیستم', 'nimanima54@gmail.com', 'درخواست خرید شما <strong style=\'color:green;\'>تایید شد</strong>.', 'درخواست خرید شما <strong style=\'color:green;\'>تایید شد</strong>.', 'seen', 10),
('سیستم', 'admins', 'شما یک <strong>درخواست فروش</strong> از <strong>نیما صیادی</strong> دریافت کردید.', 'شما یک <strong>درخواست فروش</strong> از <strong>نیما صیادی</strong> دریافت کردید.', 'unseen', 11),
('سیستم', 'nimanima54@gmail.com', 'درخواست فروش شما <strong style=\'color:green;\'>تایید شد</strong>.', 'درخواست فروش شما <strong style=\'color:green;\'>تایید شد</strong>.', 'seen', 12);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `type` varchar(255) NOT NULL,
  `request_amount` varchar(255) NOT NULL,
  `nav` varchar(255) NOT NULL,
  `buy_price` varchar(255) DEFAULT NULL,
  `sell_price` varchar(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `request_date` varchar(255) NOT NULL,
  `confirm_date` varchar(255) DEFAULT NULL,
  `wallet` text NOT NULL,
  `remaining_amount` varchar(255) DEFAULT NULL,
  `inbox` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `user` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`type`, `request_amount`, `nav`, `buy_price`, `sell_price`, `tax`, `status`, `request_date`, `confirm_date`, `wallet`, `remaining_amount`, `inbox`, `other`, `url`, `pic`, `user`, `id`) VALUES
('خرید (صدور)', '5', '4000', '20000', NULL, '100', 'تایید شده', '1401/03/23', '1401/03/23', 'TRLvpaDKgj6LXxmmt6sSaw9VzB5cV3L7Dv', '2', 'inbox1', 'خرید در هر قیمتی', 'oip', 'wEnuzfhqHS.png', 'nimanima54@gmail.com', 9),
('خرید (صدور)', '5', '70000', '350000', NULL, '100', 'تایید شده', '1401/03/23', '1401/03/23', 'TRLvpaDKgj6LXxmmt6sSaw9VzB5cV3L7Dv', '5', 'inbox2', 'خرید در هر قیمتی', 'سیش', 'GKRrwCoED5.png', 'nimanima54@gmail.com', 10),
('خرید (صدور)', '2', '100000', '200000', NULL, '40', 'تایید شده', '1401/03/23', '1401/03/23', 'TRLvpaDKgj6LXxmmt6sSaw9VzB5cV3L7Dv', '2', 'inbox3', 'خرید در هر قیمتی', 'یبس', 'Dry0h3nVVb.png', 'nimanima54@gmail.com', 11),
('فروش (ابطال)', '3', '4000', NULL, '11700', NULL, 'تایید شده', '1401/03/23', '1401/03/23', 'bnb1wwushdeatgdwz5nwlxfzsy8ll8cvdkjxv5aeue', NULL, 'inbox1', 'فروش در هر قیمتی', '-', 'lkYel8dZvA.png', 'nimanima54@gmail.com', 12);

-- --------------------------------------------------------

--
-- Table structure for table `setting_inbox`
--

CREATE TABLE `setting_inbox` (
  `name` varchar(255) NOT NULL,
  `inbox` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_inbox`
--

INSERT INTO `setting_inbox` (`name`, `inbox`, `id`) VALUES
('صندوق کم ریسک', 'inbox1', 3),
('صندوق ریسک متوسط', 'inbox2', 5),
('صندوق پر ریسک', 'inbox3', 6);

-- --------------------------------------------------------

--
-- Table structure for table `setting_nav`
--

CREATE TABLE `setting_nav` (
  `amount` varchar(255) NOT NULL,
  `inbox` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_nav`
--

INSERT INTO `setting_nav` (`amount`, `inbox`, `id`) VALUES
('4000', 'inbox1', 1),
('70000', 'inbox2', 2),
('100000', 'inbox3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `setting_tax`
--

CREATE TABLE `setting_tax` (
  `tax` varchar(255) NOT NULL,
  `inbox` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_tax`
--

INSERT INTO `setting_tax` (`tax`, `inbox`, `id`) VALUES
('20', 'inbox1', 1),
('20', 'inbox2', 2),
('20', 'inbox3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `setting_wallet`
--

CREATE TABLE `setting_wallet` (
  `address` text NOT NULL,
  `inbox` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting_wallet`
--

INSERT INTO `setting_wallet` (`address`, `inbox`, `network`, `id`) VALUES
('TRLvpaDKgj6LXxmmt6sSaw9VzB5cV3L7Dv', 'inbox1', 'TRC20', 1),
('TRLvpaDKgj6LXxmmt6sSaw9VzB5cV3L7Dv', 'inbox2', 'ERC20', 2),
('TRLvpaDKgj6LXxmmt6sSaw9VzB5cV3L7Dv', 'inbox3', 'BEP20', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `user` varchar(255) NOT NULL,
  `msg` text NOT NULL,
  `from_status` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `mail` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `other` text DEFAULT NULL,
  `percentage` varchar(255) DEFAULT NULL,
  `reg_date` varchar(255) NOT NULL,
  `priv` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`mail`, `name`, `tel`, `other`, `percentage`, `reg_date`, `priv`, `id`) VALUES
('honarparvar@gmail.com', 'عماد هنرپرور', '', NULL, '', '', 'super-admin', 2),
('nimanima54@gmail.com', 'نیما صیادی', '09017991246', 'a:10:{i:0;s:3:\"sad\";i:1;s:4:\"dfgf\";i:2;s:2:\"ds\";i:3;s:4:\"5000\";i:4;s:1:\"5\";i:5;s:5:\"60000\";i:6;s:3:\"546\";i:7;s:3:\"456\";i:8;s:4:\"7657\";i:9;s:57:\"یه برند ناشناخته ارزان ولی قشنگ\";}', '10', '1651323001', 'user', 9);

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `user` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`user`, `address`, `status`, `date`, `network`, `id`) VALUES
('nimanima54@gmail.com', 'bnb1wwushdeatgdwz5nwlxfzsy8ll8cvdkjxv5aeue', 'تایید شده', '1401/02/22', 'BEP20', 10),
('nimanima54@gmail.com', 'GBDP7RQJJWQHSHIJIZS34KTEEZOSKAPDNDUCBK4', 'درانتظار', '1401/02/23', 'Bitcoin', 11),
('nimanima54@gmail.com', 'GBDP7RQJJWQHSHIJIZS34KTdeEEZOSKAPDNDUCBK4', 'درانتظار', '1401/03/23', 'ERC20', 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activation`
--
ALTER TABLE `activation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nav_records`
--
ALTER TABLE `nav_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_inbox`
--
ALTER TABLE `setting_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_nav`
--
ALTER TABLE `setting_nav`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_tax`
--
ALTER TABLE `setting_tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_wallet`
--
ALTER TABLE `setting_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activation`
--
ALTER TABLE `activation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `nav_records`
--
ALTER TABLE `nav_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `setting_inbox`
--
ALTER TABLE `setting_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting_nav`
--
ALTER TABLE `setting_nav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting_tax`
--
ALTER TABLE `setting_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting_wallet`
--
ALTER TABLE `setting_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
