-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2022 at 05:50 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `courseannouncement`
--

CREATE TABLE `courseannouncement` (
  `announcement_id` int(20) NOT NULL,
  `heading` varchar(500) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `dates` datetime(6) NOT NULL,
  `lec_name` varchar(100) NOT NULL,
  `COU.course_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courseannouncement`
--

INSERT INTO `courseannouncement` (`announcement_id`, `heading`, `content`, `dates`, `lec_name`, `COU.course_code`) VALUES
(1, 'SCS2201_Rescheduling the lecture on 15/09/2022', '\r\nDear Students,<br>\r\n     This is to kindly inform you that the lecture at 11 am today (15/09/2022)  is rescheduled to 16/09/2022 (tomorrow) at 1 pm. I am sorry for the inconvenience that this may cause you.\r\nVenue - 4th-floor lecture hall', '2022-11-18 19:58:22.000000', 'Mr. Sirmal perera', ''),
(2, 'DSA 03 - Tutorial Session', '\nDear Students,<br>\n\nThe Tutorial Session will be held on 18th. Thursday from 5.00PM to 7.00PM. \n\nKindly note that we will upload a lab sheet(\"Activity 01\") related to greedy algorithms to the VlE. Please complete the lab sheet and upload it using the submission link. You can use today\'s tutorial hours to complete it.\n\nThank You.', '2022-11-18 20:03:05.000000', 'Dr. Nimal Silva', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(20001789, '2020cs178', 'cs178'),
(20001799, '2020cs179', 'cs179'),
(20001809, '2020cs180', 'cs180'),
(20001819, '2020cs181', 'cs181'),
(20001829, '2020cs182', 'cs182');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courseannouncement`
--
ALTER TABLE `courseannouncement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courseannouncement`
--
ALTER TABLE `courseannouncement`
  MODIFY `announcement_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20001831;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
