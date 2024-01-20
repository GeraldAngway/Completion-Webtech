-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 20, 2024 at 05:41 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

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

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `UserID` int NOT NULL,
  `Password` varchar(80) NOT NULL,
  `Password_Status` int NOT NULL,
  `Account_Status` varchar(12) NOT NULL,
  `User_Status` varchar(8) NOT NULL,
  KEY `user_acc` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`UserID`, `Password`, `Password_Status`, `Account_Status`, `User_Status`) VALUES
(1, '$2y$10$uDuS1bXRCNVWydmkMPdKROpmQNrsE3qzXTDcQY/tZ1N9Lgw6tYKre', 0, 'Active', 'Offline'),
(2, '$2y$10$PFEnW38HX42Ow3XtqSl5Y.daRyOXAoLUZkL.6uW3xAhvvdwHbssQq', 0, 'Active', 'Offline'),
(3, '$2y$10$rqVEXJbmEYY6q40EA6o6Lej3TMt3IvHA2nXH4T8m8Qu3WZhVBcaIe', 0, 'Active', 'Offline'),
(4, '$2y$10$9ErEld0e/UrHPWEf/QPfae2Uh/j.aZFAyscdRR6i.o7bas/cUTPsW', 0, 'Active', 'Offline'),
(5, '$2y$10$nBFuSOS4qAbZg92qb23yDevvj25cUF.UvYmzSGXUyU/ou0YWOhKti', 0, 'Active', 'Offline');

-- --------------------------------------------------------

--
-- Table structure for table `slu`
--

DROP TABLE IF EXISTS `slu`;
CREATE TABLE IF NOT EXISTS `slu` (
  `IDNumber` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `slu`
--

INSERT INTO `slu` (`IDNumber`) VALUES
(2227828),
(2222484),
(2200526),
(2221853),
(2220016),
(2220848),
(2220161),
(2227003),
(2222783);

-- --------------------------------------------------------

--
-- Table structure for table `userlogs`
--

DROP TABLE IF EXISTS `userlogs`;
CREATE TABLE IF NOT EXISTS `userlogs` (
  `LogID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `Action` varchar(250) NOT NULL,
  `Timestamp` timestamp NOT NULL,
  PRIMARY KEY (`LogID`),
  KEY `user_logs` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `IDNum` varchar(10) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Program` varchar(4) NOT NULL,
  `Role` varchar(10) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `IDNum`, `FirstName`, `LastName`, `Program`, `Role`) VALUES
(1, '2227828', 'Justin', 'Montemayor', 'BSIT', 'Student'),
(2, '2221853', 'Alkaid', 'Pading', 'BSCS', 'Student'),
(3, '2220848', 'Angela', 'Ramat', 'BMMA', 'Student'),
(4, '2222484', 'Carl', 'Pascua', 'BSIT', 'Student'),
(5, '2222783', 'Evan', 'Garcia', 'BSIT', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `utilization`
--

DROP TABLE IF EXISTS `utilization`;
CREATE TABLE IF NOT EXISTS `utilization` (
  `UtilizationID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Room` varchar(30) NOT NULL,
  `Purpose` varchar(255) NOT NULL,
  PRIMARY KEY (`UtilizationID`),
  KEY `user_util` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilization`
--

INSERT INTO `utilization` (`UtilizationID`, `UserID`, `Date`, `Time`, `Room`, `purpose`) VALUES
(3, 5, '2024-01-20', '07:29:00', 'D513', 'school');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `user_acc` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userlogs`
--
ALTER TABLE `userlogs`
  ADD CONSTRAINT `user_logs` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `utilization`
--
ALTER TABLE `utilization`
  ADD CONSTRAINT `user_util` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
