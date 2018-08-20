-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2018 at 04:55 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `location`, `startDate`, `endDate`) VALUES
(2, 'Work', 'Work time', '115 Broadway, New York, New York, 10006-1600, US', '2018-08-07 10:30:00', '2018-08-07 13:30:00'),
(3, 'Dinner', 'Royal dinner in my human house', '570 Cedar Hill Rd, Far Rockaway, New York, 11691-5403, US', '2018-08-07 18:00:00', '2018-08-07 20:00:00'),
(4, 'Home', 'Go home', '570 Cedar Hill Rd, Far Rockaway, New York, 11691-5403, US', '2018-08-13 13:30:00', '2018-08-13 15:30:00'),
(5, 'Cutieland', 'Meet at my human house to go to Cutieland', '570 Cedar Hill Rd, Far Rockaway, New York, 11691-5403, US', '2018-08-20 16:00:00', '2018-08-20 16:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `invite`
--

CREATE TABLE `invite` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invite`
--

INSERT INTO `invite` (`id`, `user_id`, `event_id`, `status_id`) VALUES
(6, 1, 3, 0),
(7, 3, 3, 2),
(8, 4, 3, 1),
(9, 1, 5, 0),
(10, 2, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userevents`
--

CREATE TABLE `userevents` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userevents`
--

INSERT INTO `userevents` (`id`, `event_id`, `user_id`) VALUES
(2, 2, 1),
(3, 3, 2),
(4, 4, 1),
(5, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthday` datetime NOT NULL,
  `address` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `lastLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `birthday`, `address`, `createdAt`, `lastLogin`) VALUES
(1, 'EphraimB', '$2y$10$h8Np8hviWrGvBfO9/bSnnexCP6ZM.L7OZbxBVh89v2Yq9Ek2.wmnO', 'emb16@outlook.com', '1996-07-19 00:00:00', '570 Cedar Hill Rd, Far Rockaway, New York, 11691-5403, US', '2018-08-07 11:23:34', '2018-08-20 10:34:43'),
(2, 'Cutie', '$2y$10$v1HC6zxQXmwndVNNfErgB.dStJqHDQf6Wgc3Of7b5w85mxQGuFWey', 'cutie@cutieland.gov', '2008-06-01 00:00:00', '570 Cedar Hill Rd, Far Rockaway, New York, 11691-5403, US', '2018-08-07 11:55:08', '2018-08-16 10:25:40'),
(3, 'PinnyThePooh', '$2y$10$W1KNwSTKPGQ1aOYjFe8kluO/aDhgLUsdZWqcI2YPNoE7Epj8ADBE.', 'pinnythepooh@cutiemail.com', '2010-11-14 00:00:00', '570 Cedar Hill Rd, Far Rockaway, New York, 11691-5403, US', '2018-08-13 11:06:52', '2018-08-16 11:09:47'),
(4, 'DaveM', '$2y$10$kCMIgzTWjF2CXvYvyioZBeHgZcbTkAb4ZYwRaqx0KbIRJShJszPx2', 'dmurray@kulanukids.org', '1982-08-14 00:00:00', '981 Baeck St, Ronkonkoma, New York, 11779-6632, US', '2018-08-14 12:06:34', '2018-08-16 10:51:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `invite`
--
ALTER TABLE `invite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userevents`
--
ALTER TABLE `userevents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invite`
--
ALTER TABLE `invite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userevents`
--
ALTER TABLE `userevents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
