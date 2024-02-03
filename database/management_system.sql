-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 03, 2024 at 02:38 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

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
  `Password_Status` int DEFAULT NULL,
  `Account_Status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `User_Status` varchar(8) NOT NULL,
  KEY `user_acc` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`UserID`, `Password`, `Password_Status`, `Account_Status`, `User_Status`) VALUES
(1, '$2y$10$0VBaBwUYQaQyRQJpLrtkyuHucAwOBh/OYmvKg3UfxTUisjvcpISy.', NULL, NULL, 'Offline'),
(2, '$2y$10$22oCDfk2FsRQymeTtzqUxOO6lwguPx5DiPfOi/mFboLPfe7mT8Fdm', NULL, NULL, 'Offline'),
(3, '$2y$10$.rumMEnLY4cNF5WFw0dsiuWhIJ.UF17cTXg1SnYalfH/BJCihjhlu', 0, 'Active', 'Offline'),
(4, '$2y$10$9bsSfxQII3R489ji8yN3ru37KmDHPoID9af7P5XDJV9.LFv2RD/.C', 0, 'Active', 'Offline'),
(5, '$2y$10$AgIR6nSZvVBy1G4NvLEulOP1ZT8nBOeisujwX4js3giXexjXFinzG', 0, 'Active', 'Online'),
(6, '$2y$10$tGCDTYEaOkC6S4qstxOJA.W/9IwLb3WsLfZTPF9r/o1MHvcyPklGK', 0, 'Active', 'Offline'),
(7, '$2y$10$gsTtjvSvKlXukuMUtlAb1eIkLTAOhx7z0rqxUslivuh.4IrvkE2Uu', 0, 'Active', 'Offline'),
(8, '$2y$10$UNyCMDSpTwFeCV51lt7gtOzNerK53ISMD7UhPJd9KPBeUENfPMT0W', 0, 'Active', 'Offline'),
(9, '$2y$10$BkgTKFUxEcMHdlcXHkFKvOBMcF2BuFutEjrW1I130AxaWIF72MHom', 0, 'Active', 'Offline'),
(10, '$2y$10$ABAIVOrjODMEaYUXHRppIuGQ.efHjzva.PUSFnVkRSG.IX82HmdGS', 0, 'Active', 'Offline'),
(11, '$2y$10$eBVIQILzXkedDtb7qHVM..EdLj3LHQljgK6zbbzNoT1LZmqYxs9Kq', 0, 'Active', 'Offline');

-- --------------------------------------------------------

--
-- Table structure for table `slu`
--

DROP TABLE IF EXISTS `slu`;
CREATE TABLE IF NOT EXISTS `slu` (
  `IDNumber` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `slu`
--

INSERT INTO `slu` (`IDNumber`) VALUES
('2227828'),
('2222484'),
('2200526'),
('2221853'),
('2220016'),
('2220848'),
('2220161'),
('2227003'),
('2212582'),
('2194874'),
('2222783');

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
  `Program` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Role` varchar(10) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `IDNum`, `FirstName`, `LastName`, `Program`, `Role`) VALUES
(1, 'AA1234', 'Elaine', 'Reyes', 'IT/CS', 'Admin'),
(2, 'AB1234', 'Austin', 'Davis', 'IT/CS', 'Admin'),
(3, 'AC1234', 'Gerald Kyle', 'Angway', 'IT/CS', 'TRIL'),
(4, '2220848', 'Nelle', 'Ramat', 'BMMA', 'TRIL'),
(5, '2227828', 'Justin', 'Montemayor', 'BSIT', 'TRIL'),
(6, '2221853', 'Alkaid', 'Pading', 'BSCS', 'Student'),
(7, '2200526', 'Jan Russel', 'Rivera', 'BSIT', 'Student'),
(8, '2227828', 'Justin Jarret', 'Montemayor', 'BSIT', 'Student'),
(9, '2220848', 'Nelle', 'Ramat', 'BMMA', 'Student'),
(10, '2222484', 'Carl Kendrick ', 'Pascua', 'BSIT', 'Student'),
(11, '2220016', 'Leo', 'Palafox', 'BMMA', 'Student');

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
  `Purpose` int NOT NULL,
  PRIMARY KEY (`UtilizationID`),
  KEY `user_util` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
