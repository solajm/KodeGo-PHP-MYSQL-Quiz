-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2023 at 07:45 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kodego_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `date_tweeted` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`id`, `content`, `date_tweeted`, `user_id`) VALUES
(11, 'Hello world!', '2023-06-24 17:31:58', 12),
(62, 'TESTING', '2023-06-26 03:29:23', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `birthdate`, `password`) VALUES
(8, 'John Matthew', 'Sola', 'johnmatsola@gmail.com', '1998-07-05', '$2y$10$jtEL0doMABEP6HVSCLJZ0OtAk3xl/9Q0vpFzzDhGBLO0V7iMDCl/i'),
(9, 'Matthew', 'Sola', 'johnmatsolas@gmail.com', '1998-07-05', '$2y$10$gXDNSViQg/0jjO15mE4S.OhYFG7T.CDu0278T1iK5eCbm65y8NUJy'),
(10, 'Mang', 'Tomas', 'mangtomas@gmail.com', '1998-07-05', '$2y$10$Oi06luzWg92444oDaWPXVu/ep1cVb.Z7CCWmxbKqPeXUaxz21kraG'),
(11, 'Matthew', 'Sola', 'testing@gmail.com', '1111-11-11', '$2y$10$1W30jYVpMt0tl6gRxtnDtOfymVYVnLZFSG/HFEMfR.VFCki2j9asy'),
(12, 'John', 'Doe', 'johndoe@gmail.com', '1111-11-11', '$2y$10$nxAyA7nw1uOTWbIqRD2B0.hg5UDbKZyEuc.83tmgKxOQDiL9P2UN.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tweets`
--
ALTER TABLE `tweets`
  ADD CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
