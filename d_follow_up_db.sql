-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 07:37 AM
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
-- Database: `d_follow_up_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `detail` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `completed_time` datetime DEFAULT NULL,
  `namec` varchar(255) DEFAULT NULL,
  `telc` varchar(255) DEFAULT NULL,
  `rolec` varchar(255) NOT NULL,
  `addressc` varchar(255) NOT NULL,
  `agec` varchar(255) NOT NULL,
  `buyc` varchar(255) NOT NULL,
  `symptomc` varchar(255) DEFAULT NULL,
  `wherec` varchar(255) NOT NULL,
  `whenc` varchar(255) NOT NULL,
  `hispillc` varchar(255) NOT NULL,
  `hisdefpillc` varchar(255) NOT NULL,
  `diagnosec` varchar(255) NOT NULL,
  `healc` varchar(255) NOT NULL,
  `detailheal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `email` mediumtext NOT NULL,
  `password` mediumtext NOT NULL,
  `role` mediumtext NOT NULL,
  `tel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `tel`) VALUES
(42, 'สมพร ใจดี', 'admin', 'admin', 'ผู้ดูแลระบบ', '0912345678'),
(43, 'สมชาย มั่งมี', 'staff', '111111', 'พนักงาน', '0966666666'),
(59, 'แพทย์ A', '111111', '111111', 'แพทย์', '0987654321'),
(60, 'ญาติ AA', '222222', '222222', 'ญาติ', '0987890987');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `report`
--
ALTER TABLE `report`
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
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
