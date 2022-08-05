-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: oceania_mysql:3306
-- Generation Time: Aug 05, 2022 at 12:03 AM
-- Server version: 10.6.4-MariaDB-1:10.6.4+maria~focal
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oceania`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` float NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `value`, `fixed`, `created_at`, `updated_at`) VALUES
(1, 'admin', 5, 1, '2022-07-20 15:14:51', '2022-07-20 15:14:51'),
(2, 'bonus', 100, 0, '2022-07-20 15:14:51', '2022-07-29 12:35:14'),
(3, 'critic article', 25, 1, '2022-07-20 15:14:51', '2022-07-20 15:14:51'),
(4, 'dev external', 50, 0, '2022-07-20 15:14:51', '2022-07-20 15:14:51'),
(5, 'development', 30, 0, '2022-07-20 15:14:51', '2022-07-20 15:14:51'),
(6, 'drawing', 30, 1, '2022-07-20 15:14:51', '2022-07-29 12:34:54'),
(7, 'meeting', 20, 1, '2022-07-20 15:14:51', '2022-07-29 12:34:49'),
(8, 'report', 30, 1, '2022-07-20 15:14:51', '2022-07-29 12:34:43'),
(9, 'research', 10, 0, '2022-07-20 15:14:51', '2022-07-20 15:14:51'),
(10, 'unpaid', 0, 1, '2022-07-20 15:14:51', '2022-07-20 15:14:51'),
(11, 'writing', 20, 0, '2022-07-20 15:14:51', '2022-07-20 15:14:51'),
(12, 'writing external', 30, 0, '2022-07-20 15:14:51', '2022-07-20 15:14:51');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_desc` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `value` float NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'backlog', '2022-07-31 18:32:13', NULL),
(2, 'to do', '2022-07-31 18:32:13', NULL),
(3, 'queue', '2022-07-31 18:32:13', NULL),
(4, 'waiting', '2022-07-31 18:32:13', NULL),
(5, 'wip', '2022-07-31 18:32:13', NULL),
(6, 'done', '2022-07-31 18:32:13', NULL),
(7, 'cancelled', '2022-07-31 18:32:13', NULL),
(8, 'blocked', '2022-07-31 18:32:13', NULL),
(9, 'archived', '2022-07-31 18:32:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `epic` varchar(255) DEFAULT NULL,
  `task` varchar(255) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `urgency` int(11) DEFAULT NULL,
  `hours_estimation` int(11) DEFAULT NULL,
  `hours_spent` int(11) DEFAULT NULL,
  `hours_total` int(11) DEFAULT NULL,
  `value_expected` float DEFAULT NULL,
  `value_final` float DEFAULT NULL,
  `depends_on` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `added_on` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `active`, `created_at`, `updated_at`) VALUES
(1, 'paulovelho@paulovelho.com', 'Paulo Velho', '$2y$10$6XM.C0ZemzSs1MzIi4DTHucjwD5Lzv0iHskFbdLQBGfkTMGhtMgCC', 1, '2022-07-20 15:13:28', '2022-07-20 15:13:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
