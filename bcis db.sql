-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2018 at 06:50 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bcis`
--

-- --------------------------------------------------------

--
-- Table structure for table `aadhar`
--

CREATE TABLE `aadhar` (
  `aadharNo` bigint(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `gender` char(6) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phoneNumber` bigint(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fathersAadharNo` bigint(20) DEFAULT NULL,
  `mothersAadharNo` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aadhar`
--

INSERT INTO `aadhar` (`aadharNo`, `name`, `dob`, `gender`, `address`, `phoneNumber`, `email`, `fathersAadharNo`, `mothersAadharNo`) VALUES
(123456789000, 'Akshay', '1980-10-20', 'male', 'Udupi', 9847859666, 'akshay@gmail.com', NULL, NULL),
(123456789001, 'Anushka', '1980-12-29', 'female', 'Udupi', 9847859666, 'anushka@gmail.com', NULL, NULL),
(123456789002, 'Shahrukh Khan', '1982-11-26', 'male', 'Manipal', 9862153668, 'khan@gmail.com', NULL, NULL),
(123456789003, 'Deepika', '1982-12-12', 'female', 'Mangaluru', 9658745399, 'deepika@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `birth_details`
--

CREATE TABLE `birth_details` (
  `childID` int(11) NOT NULL,
  `gender` char(6) NOT NULL,
  `dob` varchar(30) NOT NULL,
  `time` varchar(5) NOT NULL,
  `fAadharNumber` bigint(20) NOT NULL,
  `mAadharNumber` bigint(20) NOT NULL,
  `hospital` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `birth_details`
--

INSERT INTO `birth_details` (`childID`, `gender`, `dob`, `time`, `fAadharNumber`, `mAadharNumber`, `hospital`) VALUES
(1, 'Male', '19 May, 2017', '12:00', 123456789000, 123456789001, 'kmc');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `cityID` int(11) NOT NULL,
  `cityName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`cityID`, `cityName`) VALUES
(1, 'Bangalore'),
(2, 'Bellary'),
(3, 'Bidar'),
(4, 'Bijapur'),
(5, 'Chikmagalur'),
(6, 'Chitiradurga'),
(7, 'Davangere'),
(8, 'Gulbarga'),
(9, 'Hassan'),
(10, 'Hospet'),
(11, 'Hubli'),
(12, 'Karwar'),
(13, 'Madikeri'),
(14, 'Mangalore'),
(15, 'Manipal'),
(16, 'Mysore'),
(17, 'Raichur'),
(18, 'Shimoga'),
(19, 'Sringeri'),
(20, 'Srirangapatna'),
(21, 'Tumkur'),
(22, 'Udupi');

-- --------------------------------------------------------

--
-- Table structure for table `city_admin`
--

CREATE TABLE `city_admin` (
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city_admin`
--

INSERT INTO `city_admin` (`username`, `password`, `email`, `cityID`) VALUES
('admin', '$2y$12$99deLkBJteEZnwo3/dQUPeFh4vBA2bBdrVI/QWUmUFfBDkwYUIaUu', 'admin@admin.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `cityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`username`, `email`, `password`, `cityID`) VALUES
('kmc', 'kmc@kmc.com', '$2y$12$iIP3RvaMQCpv4iVP0P3rqeT5UxCKB5rFS20LS8a3P4.Wy2AlU9uVq', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aadhar`
--
ALTER TABLE `aadhar`
  ADD PRIMARY KEY (`aadharNo`),
  ADD KEY `fathersAadharNo` (`fathersAadharNo`),
  ADD KEY `mothersAadharNo` (`mothersAadharNo`);

--
-- Indexes for table `birth_details`
--
ALTER TABLE `birth_details`
  ADD PRIMARY KEY (`childID`),
  ADD KEY `hospital` (`hospital`),
  ADD KEY `fAadharNumber` (`fAadharNumber`),
  ADD KEY `mAadharNumber` (`mAadharNumber`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`cityID`),
  ADD UNIQUE KEY `cityName` (`cityName`);

--
-- Indexes for table `city_admin`
--
ALTER TABLE `city_admin`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `cityID` (`cityID`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`username`,`cityID`),
  ADD KEY `cityID` (`cityID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aadhar`
--
ALTER TABLE `aadhar`
  ADD CONSTRAINT `aadhar_ibfk_1` FOREIGN KEY (`fathersAadharNo`) REFERENCES `aadhar` (`aadharNo`) ON DELETE SET NULL,
  ADD CONSTRAINT `aadhar_ibfk_2` FOREIGN KEY (`mothersAadharNo`) REFERENCES `aadhar` (`aadharNo`) ON DELETE SET NULL;

--
-- Constraints for table `birth_details`
--
ALTER TABLE `birth_details`
  ADD CONSTRAINT `birth_details_ibfk_1` FOREIGN KEY (`hospital`) REFERENCES `hospitals` (`username`),
  ADD CONSTRAINT `birth_details_ibfk_2` FOREIGN KEY (`fAadharNumber`) REFERENCES `aadhar` (`aadharNo`),
  ADD CONSTRAINT `birth_details_ibfk_3` FOREIGN KEY (`mAadharNumber`) REFERENCES `aadhar` (`aadharNo`);

--
-- Constraints for table `city_admin`
--
ALTER TABLE `city_admin`
  ADD CONSTRAINT `city_admin_ibfk_1` FOREIGN KEY (`cityID`) REFERENCES `city` (`cityID`);

--
-- Constraints for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD CONSTRAINT `hospitals_ibfk_1` FOREIGN KEY (`cityID`) REFERENCES `city_admin` (`cityID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
