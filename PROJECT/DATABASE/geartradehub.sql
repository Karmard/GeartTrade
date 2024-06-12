-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2024 at 09:35 PM
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
-- Database: `geartradehub`
--

-- --------------------------------------------------------

--
-- Table structure for table `carreg`
--

CREATE TABLE `carreg` (
  `UserID` int(100) NOT NULL,
  `vinNo` varchar(20) NOT NULL,
  `carName` varchar(30) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `VehicleType` enum('SUV','Hatchback','Sedan','Station Wagon','Minivan','Coupe','Convertible','Truck','Pickup Truck','') NOT NULL,
  `transmission` enum('Manual','Automatic','Hybrid','Electric') NOT NULL,
  `carCondition` enum('New','Used') NOT NULL,
  `mileage` varchar(200) NOT NULL,
  `frontimage` blob NOT NULL,
  `sideLeftimage` blob NOT NULL,
  `sideRightimage` blob NOT NULL,
  `backimage` blob NOT NULL,
  `interiorimage` blob NOT NULL,
  `dashboardimage` blob NOT NULL,
  `price` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carreg`
--

INSERT INTO `carreg` (`UserID`, `vinNo`, `carName`, `brand`, `VehicleType`, `transmission`, `carCondition`, `mileage`, `frontimage`, `sideLeftimage`, `sideRightimage`, `backimage`, `interiorimage`, `dashboardimage`, `price`) VALUES
(8, 'WVWZZZ3BZWE689725', 'Mercedes G wagon', 'Mercedes', 'SUV', 'Automatic', 'New', '0.4km', 0x75706c6f6164732f66726f6e7420672e6a7067, 0x75706c6f6164732f6c65667420672e6a7067, 0x75706c6f6164732f726967687420672e77656270, 0x75706c6f6164732f6261636b20672e6a7067, 0x75706c6f6164732f696e746572696f727220672e6a7067, 0x75706c6f6164732f696e746572696f7220672e6a7067, 15000000);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoiceID` int(100) NOT NULL,
  `buyerUserID` int(100) NOT NULL,
  `sellerUserID` int(100) NOT NULL,
  `carVin` varchar(50) NOT NULL,
  `paymentDate` date NOT NULL,
  `price` int(100) NOT NULL,
  `paymentMethod` enum('Mobile money','Cash','Bank card','') NOT NULL,
  `PaymentStatus` enum('Completed','Pending','Failed','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` int(100) NOT NULL,
  `buyerUserID` int(100) NOT NULL,
  `sellerUserID` int(100) NOT NULL,
  `carVin` varchar(50) NOT NULL,
  `paymentDate` date NOT NULL,
  `price` int(11) NOT NULL,
  `paymentMethod` enum('Mobile Money','Cash','Bank card','') NOT NULL,
  `paymentStatus` enum('Complete','Pending','Failed','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personallog`
--

CREATE TABLE `personallog` (
  `UserID` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `wnumber` int(100) NOT NULL,
  `IDNo` varchar(50) NOT NULL,
  `IDproof` blob NOT NULL,
  `pFname` varchar(30) NOT NULL,
  `pLname` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personallog`
--

INSERT INTO `personallog` (`UserID`, `username`, `email`, `wnumber`, `IDNo`, `IDproof`, `pFname`, `pLname`, `password`) VALUES
(7, 'Karmard', 'tomkarma13@gmail.com', 2147483647, '37540071', 0x75706c6f6164732f494d472d32303137303432332d5741303030352e6a7067, 'Tom', 'Karma', '123321@@');

-- --------------------------------------------------------

--
-- Table structure for table `showroomlog`
--

CREATE TABLE `showroomlog` (
  `UserID` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `wnumber` varchar(100) NOT NULL,
  `showname` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `licence` blob NOT NULL,
  `certificate` blob NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `showroomlog`
--

INSERT INTO `showroomlog` (`UserID`, `username`, `email`, `wnumber`, `showname`, `location`, `licence`, `certificate`, `password`) VALUES
(8, 'Lanchester', 'lanchester1@gmail.com', '+25478382764', 'Lanchester Cars', 'Kilimani', 0x75706c6f6164732f32303230303631305f3132353130392e706e67, 0x75706c6f6164732f32303230303631305f3132353230382e706e67, 'qwerty');

-- --------------------------------------------------------

--
-- Table structure for table `soldcars`
--

CREATE TABLE `soldcars` (
  `saleID` int(100) NOT NULL,
  `sellerUserID` int(100) NOT NULL,
  `carVin` varchar(50) NOT NULL,
  `saleDate` datetime NOT NULL,
  `price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `wnumber` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('personal','showroom','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `username`, `email`, `wnumber`, `password`, `usertype`) VALUES
(7, 'Karmard', 'tomkarma13@gmail.com', '+254768608064', '123321@@', 'personal'),
(8, 'Lanchester', 'lanchester1@gmail.com', '+25478382764', 'qwerty', 'showroom');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carreg`
--
ALTER TABLE `carreg`
  ADD PRIMARY KEY (`vinNo`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoiceID`),
  ADD KEY `sellerUserID` (`sellerUserID`),
  ADD KEY `buyerUserID` (`buyerUserID`),
  ADD KEY `carVin` (`carVin`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `buyerUserID` (`buyerUserID`),
  ADD KEY `sellerUserID` (`sellerUserID`),
  ADD KEY `carVin` (`carVin`);

--
-- Indexes for table `personallog`
--
ALTER TABLE `personallog`
  ADD PRIMARY KEY (`IDNo`,`username`),
  ADD KEY `emp_id_fk` (`UserID`);

--
-- Indexes for table `showroomlog`
--
ALTER TABLE `showroomlog`
  ADD PRIMARY KEY (`username`,`email`),
  ADD KEY `emp_id_fk` (`UserID`);

--
-- Indexes for table `soldcars`
--
ALTER TABLE `soldcars`
  ADD PRIMARY KEY (`saleID`),
  ADD KEY `sellerUserID` (`sellerUserID`),
  ADD KEY `carVin` (`carVin`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carreg`
--
ALTER TABLE `carreg`
  ADD CONSTRAINT `carreg_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`sellerUserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`buyerUserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `invoices_ibfk_3` FOREIGN KEY (`carVin`) REFERENCES `carreg` (`vinNo`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`buyerUserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`sellerUserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`carVin`) REFERENCES `carreg` (`vinNo`);

--
-- Constraints for table `personallog`
--
ALTER TABLE `personallog`
  ADD CONSTRAINT `personallog_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `showroomlog`
--
ALTER TABLE `showroomlog`
  ADD CONSTRAINT `showroomlog_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `soldcars`
--
ALTER TABLE `soldcars`
  ADD CONSTRAINT `soldcars_ibfk_1` FOREIGN KEY (`sellerUserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `soldcars_ibfk_2` FOREIGN KEY (`carVin`) REFERENCES `carreg` (`vinNo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
