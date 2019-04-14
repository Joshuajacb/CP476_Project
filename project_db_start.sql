-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2019 at 05:29 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cp476_projectdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `channel_details`
--

CREATE TABLE `channel_details` (
  `channel_id` int(11) NOT NULL,
  `channel_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel_details`
--

INSERT INTO `channel_details` (`channel_id`, `channel_name`) VALUES
(1, 'Joshs Channel'),
(2, 'Megans Channel'),
(3, 'Leroys Channel'),
(4, 'Neros Channel');

-- --------------------------------------------------------

--
-- Table structure for table `channel_users`
--

CREATE TABLE `channel_users` (
  `channel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ch_key` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel_users`
--

INSERT INTO `channel_users` (`channel_id`, `user_id`, `ch_key`) VALUES
(1, 2, 1),
(3, 2, 2),
(2, 3, 3),
(3, 3, 4),
(4, 2, 5),
(4, 3, 6),
(4, 1, 7),
(3, 1, 8),
(1, 4, 9),
(2, 4, 10),
(3, 4, 11),
(4, 4, 12);

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_channel_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_channel_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(1, 3, 1, 'hey', '2019-04-14 03:21:32', 1),
(3, 4, 1, 'hi', '2019-04-14 03:21:52', 1),
(4, 1, 2, 'hello', '2019-04-14 03:22:13', 1),
(5, 4, 2, 'hey', '2019-04-14 03:22:20', 1),
(6, 3, 2, 'hi', '2019-04-14 03:22:25', 1),
(7, 2, 4, 'hi', '2019-04-14 03:23:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_type` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 1, '2019-04-14 03:21:53', 'no'),
(2, 2, '2019-04-14 03:23:11', 'no'),
(3, 4, '2019-04-14 03:29:08', 'no'),
(4, 3, '2019-04-14 03:29:20', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(250) NOT NULL,
  `user_icon` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_icon`, `created_at`) VALUES
(1, 'Nero', '$2y$10$I/iYpyLE/AN06T3nnir7VeErxu3A27Yv277rhYZxRfw65.393RgOO', 'a.a@a.com', 'fas fa-poop', '2019-04-10 16:43:46'),
(2, 'Josh', '$2y$10$Z5PnpK./QRElAuGcImR6DeNVAcNETyLCRisn6kn3xg77.Q4xRvMzq', 'josh.jacob@rogers.com', 'fas fa-ghost', '2019-04-10 18:09:43'),
(3, 'Megan', '$2y$10$OOEYPkFilzhUjinQA/Atg.5LKo0jbc1dBVKmhrjd72wkj9Bu5nAK6', 'm.m@m.com', 'fas fa-cat', '2019-04-10 18:10:26'),
(4, 'Leroy', '$2y$10$jCB1FFtb3gm2H44xXUn5KOI1ofWSIPSKb8Tj7pYb9/RKbndLenuTy', 'l.l@l.com', 'fas fa-dragon', '2019-04-10 18:17:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `channel_details`
--
ALTER TABLE `channel_details`
  ADD PRIMARY KEY (`channel_id`);

--
-- Indexes for table `channel_users`
--
ALTER TABLE `channel_users`
  ADD PRIMARY KEY (`ch_key`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channel_details`
--
ALTER TABLE `channel_details`
  MODIFY `channel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `channel_users`
--
ALTER TABLE `channel_users`
  MODIFY `ch_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
