-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2022 at 07:40 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booksy`
--

-- --------------------------------------------------------

--
-- Table structure for table `Author`
--

CREATE TABLE `Author` (
  `AuthorID` varchar(36) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Birthday` date NOT NULL,
  `Deathday` date DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Image` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Basket`
--

CREATE TABLE `Basket` (
  `UserEmail` varchar(500) NOT NULL,
  `BookISBN` varchar(20) NOT NULL,
  `Quantity` int(10) UNSIGNED NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Is_gift` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Book`
--

CREATE TABLE `Book` (
  `ISBN` varchar(20) NOT NULL,
  `Title` varchar(500) NOT NULL,
  `AuthorID` varchar(36) NOT NULL,
  `Edition` int(11) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Summary` text DEFAULT NULL,
  `Price` int(11) NOT NULL,
  `Image` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Book_order`
--

CREATE TABLE `Book_order` (
  `OrderID` varchar(36) NOT NULL,
  `UserEmail` varchar(500) NOT NULL,
  `Discount` int(10) UNSIGNED NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Deleted_at` timestamp NULL DEFAULT NULL,
  `Updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Order_item`
--

CREATE TABLE `Order_item` (
  `Order_itemID` varchar(36) NOT NULL,
  `Quantity` int(10) UNSIGNED NOT NULL,
  `OrderID` varchar(36) NOT NULL,
  `BookISBN` varchar(20) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `Email` varchar(500) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `FirstName` varchar(500) NOT NULL,
  `LastName` varchar(500) NOT NULL,
  `Address` varchar(700) DEFAULT NULL,
  `Type` tinyint(3) UNSIGNED NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Author`
--
ALTER TABLE `Author`
  ADD PRIMARY KEY (`AuthorID`);

--
-- Indexes for table `Basket`
--
ALTER TABLE `Basket`
  ADD PRIMARY KEY (`UserEmail`,`BookISBN`),
  ADD KEY `Basket_book_relation` (`BookISBN`);

--
-- Indexes for table `Book`
--
ALTER TABLE `Book`
  ADD PRIMARY KEY (`ISBN`),
  ADD UNIQUE KEY `ISBN_UNIQUE` (`ISBN`),
  ADD KEY `AuthorID` (`AuthorID`);

--
-- Indexes for table `Book_order`
--
ALTER TABLE `Book_order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserEmail` (`UserEmail`);

--
-- Indexes for table `Order_item`
--
ALTER TABLE `Order_item`
  ADD PRIMARY KEY (`Order_itemID`),
  ADD KEY `order_relation` (`OrderID`),
  ADD KEY `Book_relation` (`BookISBN`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`Email`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Basket`
--
ALTER TABLE `Basket`
  ADD CONSTRAINT `Basket_User_relation` FOREIGN KEY (`UserEmail`) REFERENCES `User` (`Email`),
  ADD CONSTRAINT `Basket_book_relation` FOREIGN KEY (`BookISBN`) REFERENCES `Book` (`ISBN`);

--
-- Constraints for table `Book`
--
ALTER TABLE `Book`
  ADD CONSTRAINT `AuthorID` FOREIGN KEY (`AuthorID`) REFERENCES `Author` (`AuthorID`);

--
-- Constraints for table `Book_order`
--
ALTER TABLE `Book_order`
  ADD CONSTRAINT `UserEmail` FOREIGN KEY (`UserEmail`) REFERENCES `User` (`Email`);

--
-- Constraints for table `Order_item`
--
ALTER TABLE `Order_item`
  ADD CONSTRAINT `Book_relation` FOREIGN KEY (`BookISBN`) REFERENCES `Book` (`ISBN`),
  ADD CONSTRAINT `order_relation` FOREIGN KEY (`OrderID`) REFERENCES `Book_order` (`OrderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
