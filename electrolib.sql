-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 11, 2023 at 05:45 PM
-- Server version: 8.1.0
-- PHP Version: 8.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electrolib`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `idBook` int NOT NULL AUTO_INCREMENT,
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` int NOT NULL,
  `publishDate` datetime NOT NULL,
  `originalLanguage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idBook`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`idBook`, `title`, `description`, `isbn`, `cover`, `publishDate`, `originalLanguage`) VALUES
(1, 'Seigneur des anneaux', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id gravida lectus. Fusce at iaculis leo, et volutpat arcu. Duis vehicula placerat tortor, ac blandit magna lacinia vitae. Quisque vulputate et metus eget faucibus. Suspendisse eleifend dui en', '9780140328721', 8739161, '2023-09-09 17:56:57', 'EN'),
(2, 'Harry Potter', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id gravida lectus. Fusce at iaculis leo, et volutpat arcu. Duis vehicula placerat tortor, ac blandit magna lacinia vitae. Quisque vulputate et metus eget faucibus. Suspendisse eleifend dui en', '9780140328722', 8739162, '2023-09-09 17:56:57', 'EN'),
(3, 'Hunger Games', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id gravida lectus. Fusce at iaculis leo, et volutpat arcu. Duis vehicula placerat tortor, ac blandit magna lacinia vitae. Quisque vulputate et metus eget faucibus. Suspendisse eleifend dui en', '9780140328723', 8739163, '2023-09-09 17:56:57', 'EN');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalCode` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` json DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrationDate` datetime NOT NULL,
  `profilePicture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `email`, `firstName`, `lastName`, `address`, `phoneNumber`, `postalCode`, `roles`, `password`, `registrationDate`, `profilePicture`) VALUES
(1, 'user@electrolib.com', 'Olivier', 'Bourgault', '123 rue Allo', '1234567890', 'K2W0A9', '[\"ROLES_USER\"]', '1234', '2023-09-09 12:46:35', 'assets\\images\\contact-book.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
