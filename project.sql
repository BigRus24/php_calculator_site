-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2024 at 05:37 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `final_grade`
--

CREATE TABLE `final_grade` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `current_grade` float DEFAULT NULL,
  `final_weight` float DEFAULT NULL,
  `wanted_grade` float DEFAULT NULL,
  `final_grade` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `final_grade`
--

INSERT INTO `final_grade` (`id`, `user_id`, `current_grade`, `final_weight`, `wanted_grade`, `final_grade`) VALUES
(2, 3, 60, 20, 70, 110);

-- --------------------------------------------------------

--
-- Table structure for table `final_grade_advanced`
--

CREATE TABLE `final_grade_advanced` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_grade` float DEFAULT NULL,
  `final_weight` float DEFAULT NULL,
  `wanted_grade` float DEFAULT NULL,
  `final_grade` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `final_grade_advanced`
--

INSERT INTO `final_grade_advanced` (`id`, `user_id`, `current_grade`, `final_weight`, `wanted_grade`, `final_grade`) VALUES
(1, 3, 16.5, 20, 75, 284);

-- --------------------------------------------------------

--
-- Table structure for table `final_grade_advanced_row`
--

CREATE TABLE `final_grade_advanced_row` (
  `id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `assignment_exam` varchar(255) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `grade` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `final_grade_advanced_row`
--

INSERT INTO `final_grade_advanced_row` (`id`, `table_id`, `assignment_exam`, `weight`, `grade`) VALUES
(129, 1, '', 16.5, 16.5);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passw` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `salt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `username`, `email`, `passw`, `admin`, `salt`) VALUES
(2, 'test', 'test2@gmaill.com', '40c31b69c376f2b8ae29afc773fbc3fd41333cf7f348e72a04a175f1b1b93605', 0, '8760bf6ccd6328663e1828b7505d6685'),
(3, 'admin', 'admin@admin.com', '058c552dbc66f99b0dcd2797db2e491daca068965c4a6039980faff549b1d486', 1, '184a68adf6d7012b3ff2bccd67a557b6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `final_grade`
--
ALTER TABLE `final_grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `final_grade` (`user_id`);

--
-- Indexes for table `final_grade_advanced`
--
ALTER TABLE `final_grade_advanced`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `final_grade_advanced_row`
--
ALTER TABLE `final_grade_advanced_row`
  ADD PRIMARY KEY (`id`),
  ADD KEY `row` (`table_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `final_grade`
--
ALTER TABLE `final_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `final_grade_advanced`
--
ALTER TABLE `final_grade_advanced`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `final_grade_advanced_row`
--
ALTER TABLE `final_grade_advanced_row`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `final_grade`
--
ALTER TABLE `final_grade`
  ADD CONSTRAINT `final_grade` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `final_grade_advanced_row`
--
ALTER TABLE `final_grade_advanced_row`
  ADD CONSTRAINT `row` FOREIGN KEY (`table_id`) REFERENCES `final_grade_advanced` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
