-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2024 at 12:23 PM
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
-- Database: `management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`UserID`, `Username`, `Password`) VALUES
(0, 'tril1', 'tril1'),
(1, 'admin1', 'admin1'),
(2, 'trilmaster', 'master');

-- --------------------------------------------------------

--
-- Table structure for table `userlogs`
--

CREATE TABLE `userlogs` (
  `LogID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Action` varchar(255) DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogs`
--

INSERT INTO `userlogs` (`LogID`, `UserID`, `Action`, `Timestamp`) VALUES
(1, 0, 'Utilization Logged', '2024-01-17 09:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Role` varchar(20) NOT NULL,
  `ID_Number` varchar(7) NOT NULL,
  `Program` varchar(10) NOT NULL,
  `FirstName` varchar(60) NOT NULL,
  `LastName` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Role`, `ID_Number`, `Program`, `FirstName`, `LastName`) VALUES
(1, 'student', '2224743', 'BSIT', 'Harry ', 'Potter'),
(2, 'student', '2224747', 'BSIT', 'Hermione', 'Granger'),
(3, 'student', '2214444', 'BSCS', 'Peter', 'Parker'),
(4, 'student', '2200123', 'BSCS', 'Ibon', 'Agila'),
(5, 'student', '2192244', 'BMMA', 'Taylor ', 'Swift'),
(6, 'student', '2211231', 'BMMA', 'Ryan', 'Reynolds'),
(7, 'student', '2192245', 'BMMA', 'Scooby', 'Doo'),
(8, 'student', '2234747', 'BSIT', 'Bon', 'apetit');

-- --------------------------------------------------------

--
-- Table structure for table `utilization`
--

CREATE TABLE `utilization` (
  `UtilizationID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `Room` varchar(255) DEFAULT NULL,
  `Purpose` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilization`
--

INSERT INTO `utilization` (`UtilizationID`, `UserID`, `Date`, `Time`, `Room`, `Purpose`) VALUES
(1, 1, '2024-01-17', '17:56:49', 'D424', 'Research'),
(2, 2, '2024-01-17', '10:30:00', 'D425', 'Lab Class'),
(3, 3, '2024-01-15', '17:59:09', 'D424', 'Research'),
(4, 5, '2024-01-11', '07:31:15', 'D425', 'Lab Class'),
(5, 4, '2024-01-17', '10:30:00', 'D425', 'Presention'),
(6, 6, '2024-01-11', '10:30:00', 'D424', 'Lab Class\r\n'),
(7, 7, '2024-01-11', '10:30:00', 'D425', 'Presentation'),
(8, 8, '2024-01-06', '18:52:22', 'D425', 'Research');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `userlogs`
--
ALTER TABLE `userlogs`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `utilization`
--
ALTER TABLE `utilization`
  ADD PRIMARY KEY (`UtilizationID`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userlogs`
--
ALTER TABLE `userlogs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `utilization`
--
ALTER TABLE `utilization`
  MODIFY `UtilizationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
