-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 01:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `systembsdh`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment_inventory`
--

CREATE TABLE `equipment_inventory` (
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('active','for replacement') NOT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_inventory`
--

INSERT INTO `equipment_inventory` (`equipment_id`, `equipment_name`, `is_available`, `status`, `assigned_to`, `date_added`) VALUES
(1, 'X-Ray Machine', 1, 'active', NULL, '2025-02-21 22:51:07'),
(2, 'MRI Scanner', 0, 'active', 'Dr. Smith', '2025-02-21 22:51:07'),
(3, 'Supersonic Brain Sigma', 0, 'active', '', '2025-02-21 22:51:07'),
(4, 'CT Scanner', 0, 'for replacement', NULL, '2025-02-21 22:51:07'),
(5, 'Defibrillator A', 1, 'active', 'Dr.Pines', '2025-02-21 23:13:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('master','admin') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `id_number`, `password`, `role`, `is_active`) VALUES
(1, 'masacc', '$2y$10$ncZWO4AdQ/tOEI/kUFYbi.56THtjBhBmIZa7u5R5Q/HdwrhwCprW2', 'master', 1),
(3, 'admin2', 'ad2123', 'admin', 1),
(4, 'admin3', '$2y$10$U4kqUMTZ1OynvUPijWQuiei.kl2w2IXAz74xM1djA6zomrVSeDLga', 'admin', 1),
(5, 'admin4', '$2y$10$Su.0H2JLC1TWJ8riux6nO.Cz8VV8a0bZnW1Q5pvWAu4brhvizcHf.', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment_inventory`
--
ALTER TABLE `equipment_inventory`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `id_number` (`id_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment_inventory`
--
ALTER TABLE `equipment_inventory`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
