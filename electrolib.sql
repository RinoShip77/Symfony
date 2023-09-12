-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 12, 2023 at 03:35 PM
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
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `idAuthor` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idAuthor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `idBook` int NOT NULL AUTO_INCREMENT,
  `idGenre` int NOT NULL,
  `idAuthor` int NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isBorrowed` tinyint(1) NOT NULL,
  `cover` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publishedDate` datetime NOT NULL,
  `originalLanguage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idBook`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`idBook`, `idGenre`, `idAuthor`, `title`, `description`, `isbn`, `isBorrowed`, `cover`, `publishedDate`, `originalLanguage`) VALUES
(1, 0, 0, 'Seigneur des anneaux', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id gravida lectus. Fusce at iaculis leo, et volutpat arcu. Duis vehicula placerat tortor, ac blandit magna lacinia vitae. Quisque vulputate et metus eget faucibus. Suspendisse eleifend dui en', '9780140328721', 0, '8739161', '2023-09-09 17:56:57', 'EN'),
(2, 0, 0, 'Harry Potter', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id gravida lectus. Fusce at iaculis leo, et volutpat arcu. Duis vehicula placerat tortor, ac blandit magna lacinia vitae. Quisque vulputate et metus eget faucibus. Suspendisse eleifend dui en', '9780140328722', 0, '8739162', '2023-09-09 17:56:57', 'EN'),
(3, 0, 0, 'Hunger Games', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id gravida lectus. Fusce at iaculis leo, et volutpat arcu. Duis vehicula placerat tortor, ac blandit magna lacinia vitae. Quisque vulputate et metus eget faucibus. Suspendisse eleifend dui en', '9780140328723', 0, '8739163', '2023-09-09 17:56:57', 'EN');

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

DROP TABLE IF EXISTS `borrows`;
CREATE TABLE IF NOT EXISTS `borrows` (
  `idBorrow` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `idBook` int NOT NULL,
  `borrowedDate` datetime NOT NULL,
  `dueDate` datetime NOT NULL,
  `returnedDate` datetime NOT NULL,
  PRIMARY KEY (`idBorrow`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

DROP TABLE IF EXISTS `evaluations`;
CREATE TABLE IF NOT EXISTS `evaluations` (
  `idEvaluation` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `idBook` int NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`idEvaluation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `idFavorite` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `idBook` int NOT NULL,
  `favoriteDate` datetime NOT NULL,
  PRIMARY KEY (`idFavorite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `idGenre` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idGenre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `idReservation` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `idBook` int NOT NULL,
  `reservationDate` datetime NOT NULL,
  PRIMARY KEY (`idReservation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrationDate` datetime NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profilePicture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalCode` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` json DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `email`, `password`, `registrationDate`, `firstName`, `lastName`, `profilePicture`, `address`, `phoneNumber`, `postalCode`, `roles`) VALUES
(1, 'user@electrolib.com', '1234', '2023-09-09 12:46:35', 'Olivier', 'Bourgault', 'assets\\images\\contact-book.png', '123 rue Allo', '1234567890', 'K2W0A9', '[\"ROLES_USER\"]');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
