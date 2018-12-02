-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2018 at 06:05 PM
-- Server version: 5.7.19-log
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usc_bookingvisitors`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `contactNumber` int(11) NOT NULL,
  `purpose` varchar(1000) NOT NULL,
  `departmentTo` int(11) NOT NULL,
  `guardReceive` int(11) DEFAULT NULL,
  `guardReturn` int(11) DEFAULT NULL,
  `datevisit` date NOT NULL,
  `noofPersons` int(11) NOT NULL,
  `bookername` varchar(200) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `timein` varchar(50) DEFAULT NULL,
  `timeout` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `status`, `emailAddress`, `contactNumber`, `purpose`, `departmentTo`, `guardReceive`, `guardReturn`, `datevisit`, `noofPersons`, `bookername`, `comment`, `timein`, `timeout`) VALUES
(70, 'pending', 'theaisleznaehr@gmail.com', 2147483647, 'Seminar', 12, NULL, NULL, '2018-03-31', 3, '3', ' Hello', '', ''),
(71, 'rejected', 'rhshahhh@gmail.com', 2147483647, '.', 16, NULL, NULL, '2018-11-01', 8, '7', 'incomplete requirements', '', ''),
(72, 'arrived', 'phink.ztuff@yahoo.com', 2147483647, 'Inquire', 6, NULL, NULL, '2018-10-26', 6, '7', '', '12:21:24', '12:25:13'),
(73, 'arrived', 'rena@gmail.com', 2147483647, 'Blaa', 6, NULL, NULL, '2018-10-30', 8, '7', '', '12:15:48', '09:08:10'),
(74, 'pending', 'rj@gmail.com', 2147483647, 'Inquire', 11, NULL, NULL, '2018-11-03', 3, '7', ' What?', '', ''),
(75, 'arrived', 'yfc@gmail.com', 2147483647, 'Seminar', 15, NULL, NULL, '2018-10-26', 2, '7', '', '07:35:31', '12:25:46'),
(76, 'arrived', 'theaisleznaehr@gmail.com', 2147483647, 'Seminar', 1, NULL, NULL, '2018-10-29', 90, '7', '', '', ''),
(77, 'pending', 'renaji@gmail.com', 2147483647, 'Inquire', 16, NULL, NULL, '2018-10-30', 7, '7', ' Hello', '', ''),
(78, 'rejected', 'renalijoymata@gmail.com', 2147483647, 'Inquire', 3, NULL, NULL, '2018-10-29', 67, '7', 'Incomplete Requirements', '', ''),
(79, 'arrived', 'rena@gmail.com', 2147483647, 'Wala lang', 6, NULL, NULL, '2018-10-25', 9, '7', '', '', ''),
(80, 'arrived', 'rena@gmail.com', 2147483647, '...z', 6, NULL, NULL, '2018-10-11', 3, '9', '', '', ''),
(83, 'pending', 'theaisleznaehr@gmail.com', 2147483647, '.', 6, NULL, NULL, '2018-10-25', 5, '7', ' What?', '', ''),
(84, 'arrived', 'asdasd@gmail.com', 2147483647, 'Seminar', 16, NULL, NULL, '2018-10-25', 5, '1111', '', '', ''),
(86, 'new', 'asdasd@gmail.com', 2147483647, 'Seminar', 16, NULL, NULL, '0000-00-00', 8, 'Renali', '', '', ''),
(88, 'rejected', 'renalijy.mata@gmail.com', 2147483647, 'Inquire', 17, NULL, NULL, '0000-00-00', 4, 'rhean', 'reject opnly', '', ''),
(89, 'pending', 'theaisleznaehr@gmail.com', 2147483647, 'Inquire', 19, NULL, NULL, '0000-00-00', 6, 'RheanJy', 'message here', '', ''),
(91, 'pending', 'theaisleznaehr@gmail.com', 2147483647, 'Submit Forms', 17, NULL, NULL, '0000-00-00', 7, 'RJ', ' Whatttt?', '', ''),
(92, 'approved', 'theaisleznaehr@gmail.com', 2147483647, 'Seminar', 20, NULL, NULL, '0000-00-00', 7, 'Renali', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `buildingId` int(11) NOT NULL,
  `buildingName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`buildingId`, `buildingName`) VALUES
(1, 'Lawrence Bunzel'),
(2, 'Arnoldus Science'),
(3, 'SMED'),
(4, 'Philip Van Engelen'),
(5, 'Robert Hoeppener'),
(6, 'Michael Richartz'),
(7, 'CAFA'),
(8, 'Church of St.Janssen & St. Freinademetz');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentId` int(11) NOT NULL,
  `deptName` varchar(100) NOT NULL,
  `deptBuilding` int(100) NOT NULL,
  `deptFloor` int(11) NOT NULL,
  `deptRoomNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentId`, `deptName`, `deptBuilding`, `deptFloor`, `deptRoomNo`) VALUES
(1, 'Department of Civil Engineering', 1, 1, 102),
(2, 'Department of Chemical Engineering', 1, 1, 101),
(3, 'Department of Electrical Engineering ', 1, 3, 301),
(6, 'Department of Computer & Information Sciences', 1, 4, 401),
(7, 'Department of Industrial Engineering', 1, 4, 402),
(10, 'Department of Physics', 2, 2, 227),
(11, 'Department of Mathematics', 3, 3, 301),
(12, 'Department of Language & Literature', 4, 1, 14),
(15, 'Department of Sociology & Anthropology', 4, 4, 45),
(16, 'Department of Nursing', 1, 2, 206),
(17, 'Department of Pharmacy', 5, 1, 109),
(18, 'Department of Nutrition & Dietetics', 5, 4, 402),
(19, 'Department of Tourism', 6, 3, 301),
(20, 'Department of Architecture', 7, 2, 205),
(24, 'Administration', 1, 1, 102);

-- --------------------------------------------------------

--
-- Table structure for table `guard`
--

CREATE TABLE `guard` (
  `guardNumber` int(11) NOT NULL,
  `guardPass` varchar(1000) NOT NULL,
  `guardFname` varchar(1000) NOT NULL,
  `guardLname` varchar(1000) NOT NULL,
  `guardAge` int(11) NOT NULL,
  `guardAddress` varchar(1000) NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guard`
--

INSERT INTO `guard` (`guardNumber`, `guardPass`, `guardFname`, `guardLname`, `guardAge`, `guardAddress`, `isActive`) VALUES
(1111, 'headguard', 'USCguard', 'TC ', 35, 'Cebu City', 1),
(1112, 'guard', 'guard', 'Ren Ren Ren ', 22, 'Nasipit Talamban, Cebu', 1),
(1113, 'dalisay', '1113', 'guardo', 98, 'Talamban', 1),
(1116, 'guard', 'sample', 'sample', 67, 'guard address 35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userType` int(11) NOT NULL,
  `userPassword` varchar(1000) NOT NULL,
  `deptId` int(11) DEFAULT NULL,
  `userName` varchar(500) NOT NULL,
  `userPosition` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userType`, `userPassword`, `deptId`, `userName`, `userPosition`) VALUES
(1, 0, 'admin', 24, 'Administrator', 'Admin'),
(17, 1, 'vpaa', 1, 'VPAA', 'vpaa'),
(18, 2, 'dcis', 6, 'DCISsecretary', 'secretary');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `visitorID` int(11) NOT NULL,
  `cardnumber` int(11) NOT NULL,
  `idType` varchar(200) NOT NULL,
  `idNumber` bigint(255) NOT NULL,
  `dateVisited` date NOT NULL,
  `timeIn` varchar(50) DEFAULT NULL,
  `timeOut` varchar(50) DEFAULT NULL,
  `deptin` varchar(50) DEFAULT NULL,
  `deptout` varchar(50) DEFAULT NULL,
  `visitorFirstname` varchar(1000) NOT NULL,
  `visitorLastname` varchar(1000) NOT NULL,
  `BookingID` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`visitorID`, `cardnumber`, `idType`, `idNumber`, `dateVisited`, `timeIn`, `timeOut`, `deptin`, `deptout`, `visitorFirstname`, `visitorLastname`, `BookingID`) VALUES
(1, 1, 'Drivers Car', 2938031, '2018-03-21', '', '', '10:10', '', 'Mr', 'Driver', 7),
(2, 1, 'Drivers', 393812, '2018-03-21', '', '', '10:10', '', 'Ms', 'Driver', 17),
(4, 0, 'SSS', 11000, '2018-03-22', '', '', '10:10', '10:10', 'RJ', 'Mataaa', 4),
(5, 0, 'simple109', 12345598, '2018-03-23', '', '', '10:10', '10:10', 'Mr.Clean', 'Cleaner', 66),
(6, 10, 'company', 11111, '2018-10-27', '08:22', '08:34', '', '', 'renali', 'remedio', 85),
(8, 19, 'numners', 111, '2018-11-06', '02:59', '03:02', NULL, NULL, '1bookers', 'booksss', 95),
(9, 45, 'SSS45', 102, '2018-11-06', '03:09', NULL, '10:10', NULL, '1111', 'philippines', NULL),
(10, 90, 'Limitation', 28, '2018-11-08', '04:49', NULL, NULL, NULL, 'bookerss', 'booker', NULL),
(11, 40, 'limitations', 28, '2018-11-08', '04:49', NULL, '10:10', '10:20', 'bookerss', 'booker', NULL),
(12, 69, 'USC', 100000, '2018-11-08', '04:51', NULL, '10:10', '10:10', 'bookerss', 'hello', NULL),
(14, 111, 'HESM', 10292, '2018-11-09', '06:02', NULL, NULL, NULL, 'bookerss', 'book', 106),
(15, 22202, 'SIMPLE HELLLO', 110, '2018-11-09', '06:03', '04:13', NULL, NULL, '21123', 'hello', 104),
(16, 10, 'SSS', 109, '2018-11-19', '03:32', '03:33', NULL, NULL, 'mark', 'remedio', 107),
(17, 28, 'Company', 10, '2018-11-19', '03:56', '04:13', NULL, NULL, '1111', '2222', 84),
(18, 28, 'Company', 10, '2018-11-19', '03:57', '04:13', NULL, NULL, '1111', '2222', 84),
(19, 10, 'ayala', 110, '2018-11-19', '03:57', '04:09', NULL, NULL, '9', '10', 80),
(20, 10, 'ayala', 110, '2018-11-19', '03:58', '04:10', NULL, NULL, '7', '10', 79),
(21, 10, 'ayala', 110, '2018-11-19', '03:59', '04:11', NULL, NULL, '70', '10', 76),
(22, 75, 'sevenelevenfive', 75, '2018-11-19', '03:59', '04:13', NULL, NULL, '7', '5', 75),
(23, 718, 'ajdism', 902, '2018-11-19', '04:01', NULL, NULL, NULL, 'amsdkasmd', 'ajsdada', 73),
(24, 90, 'typer', 100, '2018-11-19', '04:06', '04:08', NULL, NULL, 'sample', 'hello', 72);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `departmentTo` (`departmentTo`),
  ADD KEY `guardReceived` (`guardReceive`),
  ADD KEY `guardReturn` (`guardReturn`),
  ADD KEY `bookername` (`bookername`);

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`buildingId`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentId`),
  ADD KEY `deptBuilding` (`deptBuilding`);

--
-- Indexes for table `guard`
--
ALTER TABLE `guard`
  ADD PRIMARY KEY (`guardNumber`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `deptId` (`deptId`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`visitorID`),
  ADD KEY `BookingID` (`BookingID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `buildingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `guard`
--
ALTER TABLE `guard`
  MODIFY `guardNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1117;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `visitorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`departmentTo`) REFERENCES `department` (`departmentId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`guardReceive`) REFERENCES `guard` (`guardNumber`) ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`guardReturn`) REFERENCES `guard` (`guardNumber`) ON UPDATE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`deptBuilding`) REFERENCES `building` (`buildingId`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`deptId`) REFERENCES `department` (`departmentId`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
