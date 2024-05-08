-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 11:15 AM
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
-- Database: `phones`
--

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `stat` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `name`, `company`, `address`, `mobile`, `stat`, `fax`) VALUES
(1, 'Драгомир Манов', 'Контракс', 'София ул \"Тинтява\" 13', '+359 88 646 0622', '+359 2 960 9704', '+359 2 960 9797'),
(52, 'Драгомир Манов', 'ТУ-София', 'София бул Kл Oхридски 8', '+999 999 999', '+359 2 965 2652', ''),
(53, 'Маргарита Митова', 'Контракс', 'София ул Тинтява 13', '+359 89 7887 707', '', ''),
(54, 'Маргарита Митева', '', 'София ул Тинтява 13', '+359 88 123 4567', '+359 2 960 977', ''),
(55, 'Деница Манова', 'МГ Др Петър Берон', 'Варна', '', '+23 5326 6361', ''),
(64, 'Маргарита Митева', 'Контракс', 'София', '+359 88 643 4312', '', ''),
(65, 'Драгомир Манов', 'МГ Др Петър Берон', 'Варна', '+44 7734 13456', '+567', ''),
(66, 'Драгомир Манов', 'Контракс', 'София', '+6547', '', ''),
(78, 'Мирослав Василев', 'Контракс', 'София', '+0884898400', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
