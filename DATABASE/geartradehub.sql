-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 07:01 PM
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
-- Database: `geartradehub`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlog`
--

CREATE TABLE `adminlog` (
  `UserID` varchar(255) DEFAULT NULL,
  `unique_id` int(11) NOT NULL,
  `Fname` varchar(255) DEFAULT NULL,
  `Lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `wnumber` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminlog`
--

INSERT INTO `adminlog` (`UserID`, `unique_id`, `Fname`, `Lname`, `email`, `wnumber`, `password`, `status`, `img`) VALUES
('A001A', 1, 'Mary', 'Shamte', 'maryshamte@gmail.com', '+254768608064', '123321@@', 'Active Now', 'uploads/image1.JPG\n'),
('A001B', 2, 'Rashid', 'Shamte', 'rashid@gmail.com', '+254764825636', '123321@@', 'Active Now', 'uploads/image1.JPG\r\n'),
('A001C', 1576232171, 'Ben', 'Achieng', 'ben@gmail.com', '+254765387625', '123321@@', 'Active Now', 'uploads/image1.JPG\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `audit_id` int(11) NOT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE') DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_data`)),
  `new_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_data`)),
  `changed_by` varchar(100) DEFAULT NULL,
  `change_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`audit_id`, `table_name`, `action_type`, `record_id`, `old_data`, `new_data`, `changed_by`, `change_time`, `UserID`) VALUES
(1, 'carreg', 'UPDATE', 0, '{\"UserID\": 1, \"carName\": \"Volkswagen golf r mk7\", \"brand\": \"Volkswagen\", \"VehicleType\": \"Hatchback\", \"transmission\": \"Automatic\", \"carCondition\": \"Used\", \"mileage\": \"9800\", \"frontimage\": \"uploads/vwfront.webp\", \"sideLeftimage\": \"uploads/vwleft.webp\", \"sideRightimage\": \"uploads/vwright.webp\", \"backimage\": \"uploads/vwback.webp\", \"interiorimage\": \"uploads/VW INTERIOR.webp\", \"dashboardimage\": \"uploads/vw dash.jpg\", \"price\": 2587655, \"registrationDate\": \"2024-05-13 12:12:54\", \"carStatus\": null}', '{\"UserID\": 1, \"carName\": \"Volkswagen golf r mk7\", \"brand\": \"Volkswagen\", \"VehicleType\": \"Hatchback\", \"transmission\": \"Automatic\", \"carCondition\": \"Used\", \"mileage\": \"9800\", \"frontimage\": \"uploads/vwfront.webp\", \"sideLeftimage\": \"uploads/vwleft.webp\", \"sideRightimage\": \"uploads/vwright.webp\", \"backimage\": \"uploads/vwback.webp\", \"interiorimage\": \"uploads/VW INTERIOR.webp\", \"dashboardimage\": \"uploads/vw dash.jpg\", \"price\": 2587650, \"registrationDate\": \"2024-05-13 12:12:54\", \"carStatus\": null}', 'Any@localhost', '2024-05-13 15:47:07', NULL),
(2, 'carreg', 'UPDATE', 0, '{\"UserID\": 1, \"carName\": \"Mercedes G wagon Mansory\", \"brand\": \"Mercedes\", \"VehicleType\": \"SUV\", \"transmission\": \"Automatic\", \"carCondition\": \"New\", \"mileage\": \"0.3\", \"frontimage\": \"uploads/mans front.jpg\", \"sideLeftimage\": \"uploads/mans left.jpeg\", \"sideRightimage\": \"uploads/mans right.jpg\", \"backimage\": \"uploads/mans back.jpg\", \"interiorimage\": \"uploads/mans interior.jpeg\", \"dashboardimage\": \"uploads/mans dash.jpeg\", \"price\": 45788653, \"registrationDate\": \"2024-05-05 16:50:43\", \"carStatus\": null}', '{\"UserID\": 1, \"carName\": \"Mercedes G wagon Mansory\", \"brand\": \"Mercedes\", \"VehicleType\": \"SUV\", \"transmission\": \"Automatic\", \"carCondition\": \"New\", \"mileage\": \"0.3\", \"frontimage\": \"uploads/mans front.jpg\", \"sideLeftimage\": \"uploads/mans left.jpeg\", \"sideRightimage\": \"uploads/mans right.jpg\", \"backimage\": \"uploads/mans back.jpg\", \"interiorimage\": \"uploads/mans interior.jpeg\", \"dashboardimage\": \"uploads/mans dash.jpeg\", \"price\": 45788652, \"registrationDate\": \"2024-05-05 16:50:43\", \"carStatus\": null}', 'Any@localhost', '2024-05-13 15:51:51', NULL),
(3, 'carreg', 'UPDATE', 0, '{\"UserID\": 1, \"carName\": \"Mercedes G wagon Mansory\", \"brand\": \"Mercedes\", \"VehicleType\": \"SUV\", \"transmission\": \"Automatic\", \"carCondition\": \"New\", \"mileage\": \"0.3\", \"frontimage\": \"uploads/mans front.jpg\", \"sideLeftimage\": \"uploads/mans left.jpeg\", \"sideRightimage\": \"uploads/mans right.jpg\", \"backimage\": \"uploads/mans back.jpg\", \"interiorimage\": \"uploads/mans interior.jpeg\", \"dashboardimage\": \"uploads/mans dash.jpeg\", \"price\": 45788652, \"registrationDate\": \"2024-05-05 16:50:43\", \"carStatus\": null}', '{\"UserID\": 1, \"carName\": \"Mercedes G wagon Mansory\", \"brand\": \"Mercedes\", \"VehicleType\": \"SUV\", \"transmission\": \"Automatic\", \"carCondition\": \"New\", \"mileage\": \"0.3\", \"frontimage\": \"uploads/mans front.jpg\", \"sideLeftimage\": \"uploads/mans left.jpeg\", \"sideRightimage\": \"uploads/mans right.jpg\", \"backimage\": \"uploads/mans back.jpg\", \"interiorimage\": \"uploads/mans interior.jpeg\", \"dashboardimage\": \"uploads/mans dash.jpeg\", \"price\": 45788656, \"registrationDate\": \"2024-05-05 16:50:43\", \"carStatus\": null}', 'Any@localhost', '2024-05-13 15:57:00', NULL),
(4, 'carreg', 'UPDATE', 0, '{\"UserID\": 1, \"carName\": \"Mercedes G wagon Mansory\", \"brand\": \"Mercedes\", \"VehicleType\": \"SUV\", \"transmission\": \"Automatic\", \"carCondition\": \"New\", \"mileage\": \"0.3\", \"frontimage\": \"uploads/mans front.jpg\", \"sideLeftimage\": \"uploads/mans left.jpeg\", \"sideRightimage\": \"uploads/mans right.jpg\", \"backimage\": \"uploads/mans back.jpg\", \"interiorimage\": \"uploads/mans interior.jpeg\", \"dashboardimage\": \"uploads/mans dash.jpeg\", \"price\": 45788656, \"registrationDate\": \"2024-05-05 16:50:43\", \"carStatus\": null}', '{\"UserID\": 1, \"carName\": \"Mercedes G-wagon Mansory\", \"brand\": \"Mercedes\", \"VehicleType\": \"SUV\", \"transmission\": \"Automatic\", \"carCondition\": \"New\", \"mileage\": \"0.3\", \"frontimage\": \"uploads/mans front.jpg\", \"sideLeftimage\": \"uploads/mans left.jpeg\", \"sideRightimage\": \"uploads/mans right.jpg\", \"backimage\": \"uploads/mans back.jpg\", \"interiorimage\": \"uploads/mans interior.jpeg\", \"dashboardimage\": \"uploads/mans dash.jpeg\", \"price\": 45788656, \"registrationDate\": \"2024-05-05 16:50:43\", \"carStatus\": null}', 'Any@localhost', '2024-05-13 16:33:16', NULL),
(5, 'carreg', 'UPDATE', 0, '{\"UserID\": 1, \"carName\": \"Volkswagen golf r mk7\", \"brand\": \"Volkswagen\", \"VehicleType\": \"Hatchback\", \"transmission\": \"Automatic\", \"carCondition\": \"Used\", \"mileage\": \"9800\", \"frontimage\": \"uploads/vwfront.webp\", \"sideLeftimage\": \"uploads/vwleft.webp\", \"sideRightimage\": \"uploads/vwright.webp\", \"backimage\": \"uploads/vwback.webp\", \"interiorimage\": \"uploads/VW INTERIOR.webp\", \"dashboardimage\": \"uploads/vw dash.jpg\", \"price\": 2587650, \"registrationDate\": \"2024-05-13 12:12:54\", \"carStatus\": null}', '{\"UserID\": 1, \"carName\": \"Volkswagen golf R mk7\", \"brand\": \"Volkswagen\", \"VehicleType\": \"Hatchback\", \"transmission\": \"Automatic\", \"carCondition\": \"Used\", \"mileage\": \"9800\", \"frontimage\": \"uploads/vwfront.webp\", \"sideLeftimage\": \"uploads/vwleft.webp\", \"sideRightimage\": \"uploads/vwright.webp\", \"backimage\": \"uploads/vwback.webp\", \"interiorimage\": \"uploads/VW INTERIOR.webp\", \"dashboardimage\": \"uploads/vw dash.jpg\", \"price\": 2587650, \"registrationDate\": \"2024-05-13 12:12:54\", \"carStatus\": null}', 'Any@localhost', '2024-05-13 16:48:13', NULL),
(6, 'carreg', 'UPDATE', 0, '{\"UserID\": 1, \"carName\": \"Mercedes G-wagon Mansory\", \"brand\": \"Mercedes\", \"VehicleType\": \"SUV\", \"transmission\": \"Automatic\", \"carCondition\": \"New\", \"mileage\": \"0.3\", \"frontimage\": \"uploads/mans front.jpg\", \"sideLeftimage\": \"uploads/mans left.jpeg\", \"sideRightimage\": \"uploads/mans right.jpg\", \"backimage\": \"uploads/mans back.jpg\", \"interiorimage\": \"uploads/mans interior.jpeg\", \"dashboardimage\": \"uploads/mans dash.jpeg\", \"price\": 45788656, \"registrationDate\": \"2024-05-05 16:50:43\", \"carStatus\": null}', '{\"UserID\": 1, \"carName\": \"Mercedes G-wagon Mansory\", \"brand\": \"Mercedes\", \"VehicleType\": \"SUV\", \"transmission\": \"Automatic\", \"carCondition\": \"New\", \"mileage\": \"0.3\", \"frontimage\": \"uploads/mans front.jpg\", \"sideLeftimage\": \"uploads/mans left.jpeg\", \"sideRightimage\": \"uploads/mans right.jpg\", \"backimage\": \"uploads/mans back.jpg\", \"interiorimage\": \"uploads/mans interior.jpeg\", \"dashboardimage\": \"uploads/mans dash.jpeg\", \"price\": 48788656, \"registrationDate\": \"2024-05-05 16:50:43\", \"carStatus\": null}', 'Any@localhost', '2024-05-13 16:49:19', NULL),
(7, 'carreg', 'UPDATE', 0, '{\"UserID\": 1, \"carName\": \"Volkswagen golf R mk7\", \"brand\": \"Volkswagen\", \"VehicleType\": \"Hatchback\", \"transmission\": \"Automatic\", \"carCondition\": \"Used\", \"mileage\": \"9800\", \"frontimage\": \"uploads/vwfront.webp\", \"sideLeftimage\": \"uploads/vwleft.webp\", \"sideRightimage\": \"uploads/vwright.webp\", \"backimage\": \"uploads/vwback.webp\", \"interiorimage\": \"uploads/VW INTERIOR.webp\", \"dashboardimage\": \"uploads/vw dash.jpg\", \"price\": 2587650, \"registrationDate\": \"2024-05-13 12:12:54\", \"carStatus\": null}', '{\"UserID\": 1, \"carName\": \"Volkswagen golf R mk7\", \"brand\": \"Volkswagen\", \"VehicleType\": \"Hatchback\", \"transmission\": \"Automatic\", \"carCondition\": \"Used\", \"mileage\": \"9800\", \"frontimage\": \"uploads/vwfront.webp\", \"sideLeftimage\": \"uploads/vwleft.webp\", \"sideRightimage\": \"uploads/vwright.webp\", \"backimage\": \"uploads/vwback.webp\", \"interiorimage\": \"uploads/VW INTERIOR.webp\", \"dashboardimage\": \"uploads/vw dash.jpg\", \"price\": 2687650, \"registrationDate\": \"2024-05-13 12:12:54\", \"carStatus\": null}', 'Any@localhost', '2024-05-13 16:52:33', NULL);

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
  `frontimage` varchar(200) NOT NULL,
  `sideLeftimage` varchar(200) NOT NULL,
  `sideRightimage` varchar(200) NOT NULL,
  `backimage` varchar(200) NOT NULL,
  `interiorimage` varchar(200) NOT NULL,
  `dashboardimage` varchar(200) NOT NULL,
  `price` int(200) NOT NULL,
  `registrationDate` datetime DEFAULT NULL,
  `carStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carreg`
--

INSERT INTO `carreg` (`UserID`, `vinNo`, `carName`, `brand`, `VehicleType`, `transmission`, `carCondition`, `mileage`, `frontimage`, `sideLeftimage`, `sideRightimage`, `backimage`, `interiorimage`, `dashboardimage`, `price`, `registrationDate`, `carStatus`) VALUES
(1, 'KG657536', 'Mercedes G-wagon Mansory', 'Mercedes', 'SUV', 'Automatic', 'New', '0.3', 'uploads/mans front.jpg', 'uploads/mans left.jpeg', 'uploads/mans right.jpg', 'uploads/mans back.jpg', 'uploads/mans interior.jpeg', 'uploads/mans dash.jpeg', 48788656, '2024-05-05 16:50:43', NULL),
(2, 'KG76384', 'Jeep Trackhawk', 'Jeep', 'SUV', 'Manual', 'Used', '2833', 'uploads/jfront.jpg', 'uploads/jleft.jpg', 'uploads/jright.jpg', 'uploads/jback.jpg', 'uploads/jint.jpg', 'uploads/jdash.jpg', 6890563, '2024-05-06 15:41:30', NULL),
(1, 'KG7474836', 'Volkswagen golf R mk7', 'Volkswagen', 'Hatchback', 'Automatic', 'Used', '9800', 'uploads/vwfront.webp', 'uploads/vwleft.webp', 'uploads/vwright.webp', 'uploads/vwback.webp', 'uploads/VW INTERIOR.webp', 'uploads/vw dash.jpg', 2687650, '2024-05-13 12:12:54', NULL);

--
-- Triggers `carreg`
--
DELIMITER $$
CREATE TRIGGER `carreg_audit_trigger_delete` AFTER DELETE ON `carreg` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('carreg', 'DELETE', OLD.vinNo, 
            JSON_OBJECT('UserID', OLD.UserID, 'carName', OLD.carName, 'brand', OLD.brand, 'VehicleType', OLD.VehicleType, 'transmission', OLD.transmission, 'carCondition', OLD.carCondition, 'mileage', OLD.mileage, 'frontimage', OLD.frontimage, 'sideLeftimage', OLD.sideLeftimage, 'sideRightimage', OLD.sideRightimage, 'backimage', OLD.backimage, 'interiorimage', OLD.interiorimage, 'dashboardimage', OLD.dashboardimage, 'price', OLD.price, 'registrationDate', OLD.registrationDate, 'carStatus', OLD.carStatus), 
            NULL, 
            USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `carreg_audit_trigger_insert` AFTER INSERT ON `carreg` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('carreg', 'INSERT', NEW.vinNo, NULL, 
            JSON_OBJECT('UserID', NEW.UserID, 'carName', NEW.carName, 'brand', NEW.brand, 'VehicleType', NEW.VehicleType, 'transmission', NEW.transmission, 'carCondition', NEW.carCondition, 'mileage', NEW.mileage, 'frontimage', NEW.frontimage, 'sideLeftimage', NEW.sideLeftimage, 'sideRightimage', NEW.sideRightimage, 'backimage', NEW.backimage, 'interiorimage', NEW.interiorimage, 'dashboardimage', NEW.dashboardimage, 'price', NEW.price, 'registrationDate', NEW.registrationDate, 'carStatus', NEW.carStatus), 
            USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `carreg_audit_trigger_update` AFTER UPDATE ON `carreg` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('carreg', 'UPDATE', OLD.vinNo, 
            JSON_OBJECT('UserID', OLD.UserID, 'carName', OLD.carName, 'brand', OLD.brand, 'VehicleType', OLD.VehicleType, 'transmission', OLD.transmission, 'carCondition', OLD.carCondition, 'mileage', OLD.mileage, 'frontimage', OLD.frontimage, 'sideLeftimage', OLD.sideLeftimage, 'sideRightimage', OLD.sideRightimage, 'backimage', OLD.backimage, 'interiorimage', OLD.interiorimage, 'dashboardimage', OLD.dashboardimage, 'price', OLD.price, 'registrationDate', OLD.registrationDate, 'carStatus', OLD.carStatus), 
            JSON_OBJECT('UserID', NEW.UserID, 'carName', NEW.carName, 'brand', NEW.brand, 'VehicleType', NEW.VehicleType, 'transmission', NEW.transmission, 'carCondition', NEW.carCondition, 'mileage', NEW.mileage, 'frontimage', NEW.frontimage, 'sideLeftimage', NEW.sideLeftimage, 'sideRightimage', NEW.sideRightimage, 'backimage', NEW.backimage, 'interiorimage', NEW.interiorimage, 'dashboardimage', NEW.dashboardimage, 'price', NEW.price, 'registrationDate', NEW.registrationDate, 'carStatus', NEW.carStatus), 
            USER());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(11) DEFAULT NULL,
  `outgoing_msg_id` int(11) DEFAULT NULL,
  `msg` varchar(255) DEFAULT NULL
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
  `IDproof` varchar(200) NOT NULL,
  `pFname` varchar(30) NOT NULL,
  `pLname` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personallog`
--

INSERT INTO `personallog` (`UserID`, `username`, `email`, `wnumber`, `IDNo`, `IDproof`, `pFname`, `pLname`, `password`) VALUES
(1, 'Karmard', 'tomkarma13@gmail.com', 2147483647, '7758464', 'uploads/IMG_0017.JPG', 'Tom', 'Karma', '$2y$10$oP7OA.maidmluoigNRRjqu6KDudQ0FmITG9RRxshQqK'),
(2, 'Steph', 'tomkarma14@gmail.com', 2147483647, '6537364', 'uploads/image1.JPG', 'Steph', 'Achieng', '$2y$10$zRmlpEl2Ulkmi/k1YmPdzuLopy1JeM.UJ6hgi4ALxrl'),
(4, 'Angela', 'angela@gmail.com', 2147483647, '64763687', 'uploads/1.png', 'Angela', 'Lumati', '$2y$10$WR3GARdUbrOs/f48kKzQGO90pEYAOY.3QRTsesx6gko'),
(5, 'Mutinda', 'tomkarma12@gmail.com', 2147483647, '87575753', 'uploads/2.png', 'Emmanuel ', 'Mutinda', '$2y$10$fpe2Zvby.kv4BX8B5h9UHeDWfpKYGUOQ3YbwxPT8Xbp'),
(6, 'Harmonize', 'harmonize@gmail.com', 2147483647, '64763687', 'uploads/vw dash.jpg', 'Harmo', 'Nize', '$2y$10$prSZYqHXBPloTLulLy7VQOvwXlPPY/m6ARt4TI5p2tw');

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
  `licence` varchar(200) NOT NULL,
  `certificate` varchar(200) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `showroomlog`
--

INSERT INTO `showroomlog` (`UserID`, `username`, `email`, `wnumber`, `showname`, `location`, `licence`, `certificate`, `password`) VALUES
(3, 'Lanchester', 'lanchester@gmail.com', '+254740847300', 'Lanchester Cars', 'Kilimani', 'uploads/logo512.png', 'uploads/Untitled design.png', '$2y$10$eE.NV8aDMUAYdYNbUJeObuzEkNGUxg//IdHfsw9ISwm');

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `subscriptionID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`subscriptionID`, `UserID`, `plan`, `start_date`, `end_date`, `price`, `created_at`) VALUES
(2, 2, 'Pro Plan', '2024-05-06', '2024-06-05', 1800.00, '2024-05-06 13:39:00'),
(3, 3, 'Plus Plan', '2024-05-06', '2024-06-05', 1000.00, '2024-05-06 18:42:18'),
(6, 1, 'plus', '2024-05-13', '2024-06-12', 1000.00, '2024-05-13 12:25:30'),
(7, 1, 'plus', '2024-05-13', '2024-06-12', 1000.00, '2024-05-13 12:26:07'),
(8, 6, 'pro', '2024-05-13', '2024-06-12', 1800.00, '2024-05-13 15:16:57');

--
-- Triggers `subscription`
--
DELIMITER $$
CREATE TRIGGER `subscription_audit_trigger_delete` AFTER DELETE ON `subscription` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('subscription', 'DELETE', OLD.subscriptionID, 
            JSON_OBJECT('UserID', OLD.UserID, 'plan', OLD.plan, 'start_date', OLD.start_date, 'end_date', OLD.end_date, 'price', OLD.price, 'created_at', OLD.created_at), 
            NULL, 
            USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `subscription_audit_trigger_insert` AFTER INSERT ON `subscription` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('subscription', 'INSERT', NEW.subscriptionID, NULL, 
            JSON_OBJECT('UserID', NEW.UserID, 'plan', NEW.plan, 'start_date', NEW.start_date, 'end_date', NEW.end_date, 'price', NEW.price, 'created_at', NEW.created_at), 
            USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `subscription_audit_trigger_update` AFTER UPDATE ON `subscription` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('subscription', 'UPDATE', OLD.subscriptionID, 
            JSON_OBJECT('UserID', OLD.UserID, 'plan', OLD.plan, 'start_date', OLD.start_date, 'end_date', OLD.end_date, 'price', OLD.price, 'created_at', OLD.created_at), 
            JSON_OBJECT('UserID', NEW.UserID, 'plan', NEW.plan, 'start_date', NEW.start_date, 'end_date', NEW.end_date, 'price', NEW.price, 'created_at', NEW.created_at), 
            USER());
END
$$
DELIMITER ;

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
  `usertype` enum('personal','showroom','') NOT NULL,
  `suspended` tinyint(1) DEFAULT 0,
  `regdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `suspended_by_admin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `username`, `email`, `wnumber`, `password`, `usertype`, `suspended`, `regdate`, `suspended_by_admin`) VALUES
(1, 'Karmard', 'tomkarma13@gmail.com', '+254768608064', '$2y$10$WJZik7WkiEInc5OU.VksSO5MKwQDXzpo72E.Df/AyZjowM7x0e.rK', 'personal', 0, '2024-05-05 14:34:49', NULL),
(2, 'Steph', 'tomkarma14@gmail.com', '+254796954001', '$2y$10$XtpjUKg8mFBCb.kaaL6AhOKZDDnHxTCp0QVPxkDqcVfxx0O4Rr8Tq', 'personal', 0, '2024-05-06 13:38:30', NULL),
(3, 'Lanchester', 'lanchester@gmail.com', '+254740847300', '$2y$10$uI9dsew6.D0WSRMHEzdl1eXJ8/TNih4QTyDrY6Z7MkOv/kCSU8E1O', 'showroom', 0, '2024-05-06 18:39:46', NULL),
(4, 'Angela', 'angela@gmail.com', '+254741818812', '$2y$10$trYQSGP9Q8V8EkmqljkXdetO9DACh7UJ//5bnLPRcIv1TVTuFwALK', 'personal', 0, '2024-05-11 10:16:23', 0),
(6, 'Harmonize', 'harmonize@gmail.com', '+254768608064', '$2y$10$EEjXvsDLb2Q6Hrhc5cq1iO/07XfegYuckNcwiFzyf8OVMjexfP99a', 'personal', 0, '2024-05-13 15:04:57', 0);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `users_audit_trigger_delete` AFTER DELETE ON `users` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('users', 'DELETE', OLD.UserID, JSON_OBJECT('username', OLD.username, 'email', OLD.email, 'wnumber', OLD.wnumber, 'password', OLD.password, 'usertype', OLD.usertype), NULL, USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_audit_trigger_insert_new` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('users', 'INSERT', NEW.UserID, NULL, 
            JSON_OBJECT('username', NEW.username, 'email', NEW.email, 'wnumber', NEW.wnumber, 'password', NEW.password, 'usertype', NEW.usertype), 
            USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `users_audit_trigger_update` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_data, new_data, changed_by)
    VALUES ('users', 'UPDATE', OLD.UserID, JSON_OBJECT('username', OLD.username, 'email', OLD.email, 'wnumber', OLD.wnumber, 'password', OLD.password, 'usertype', OLD.usertype), JSON_OBJECT('username', NEW.username, 'email', NEW.email, 'wnumber', NEW.wnumber, 'password', NEW.password, 'usertype', NEW.usertype), USER());
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlog`
--
ALTER TABLE `adminlog`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`audit_id`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `incoming_msg_id` (`incoming_msg_id`),
  ADD KEY `outgoing_msg_id` (`outgoing_msg_id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscriptionID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlog`
--
ALTER TABLE `adminlog`
  MODIFY `unique_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1576232172;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `subscriptionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`incoming_msg_id`) REFERENCES `adminlog` (`unique_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`outgoing_msg_id`) REFERENCES `adminlog` (`unique_id`);

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
