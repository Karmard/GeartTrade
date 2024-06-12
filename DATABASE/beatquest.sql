-- Create the database
CREATE DATABASE IF NOT EXISTS `beatquestdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

-- Use the database
USE `beatquestdb`;

-- Create the 'djs' table
CREATE TABLE IF NOT EXISTS `djs` (
  `dj_id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(60) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `national_id` varchar(100) NOT NULL,
  `proof_of_id` varchar(100) NOT NULL,
  `profile_pic` varchar(80) NOT NULL,
  `password` varchar(100) NOT NULL,
  `qr_code_url` varchar(200) NOT NULL,
  PRIMARY KEY (`dj_id`,`national_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into the 'djs' table
INSERT INTO `djs` VALUES (1,'DJ Lyta','Ben','Ngaira','bem@gmail.com','377654','opload/pic1.jpg','upload/tyty.jpg','123321@@','qr/001');

-- Create the 'songs' table
CREATE TABLE IF NOT EXISTS `songs` (
  `song_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `added_by_dj_id` int DEFAULT NULL,
  PRIMARY KEY (`song_id`),
  KEY `added_by_dj_id` (`added_by_dj_id`),
  CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`added_by_dj_id`) REFERENCES `djs` (`dj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into the 'songs' table
INSERT INTO `songs` VALUES (1,'Mukuchu','Spoiler','Arbanton',1);

-- Create the 'songrequest' table
CREATE TABLE IF NOT EXISTS `songrequest` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `song_id` int DEFAULT NULL,
  `fan_name` varchar(255) NOT NULL,
  `request_message` varchar(255) DEFAULT NULL,
  `request_status` enum('pending','accepted','denied') DEFAULT 'pending',
  `request_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by_dj_id` int DEFAULT NULL,
  PRIMARY KEY (`request_id`),
  KEY `song_id` (`song_id`),
  KEY `added_by_dj_id` (`added_by_dj_id`),
  CONSTRAINT `songrequest_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`),
  CONSTRAINT `songrequest_ibfk_2` FOREIGN KEY (`added_by_dj_id`) REFERENCES `djs` (`dj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into the 'songrequest' table
INSERT INTO `songrequest` VALUES (1,1,'Stacy','It is my birthday','accepted','2024-02-28 21:00:00',1;
