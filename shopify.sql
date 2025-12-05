-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2025 at 04:40 AM
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
-- Database: `shopify`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `categoryType` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryType`) VALUES
(1, 'FOOD'),
(2, 'Snacks'),
(3, 'Drinks'),
(4, 'Shampoo'),
(5, 'Soap');

-- --------------------------------------------------------

--
-- Table structure for table `costumer`
--

CREATE TABLE `costumer` (
  `costumerID` int(11) NOT NULL,
  `costumerName` varchar(100) DEFAULT NULL,
  `costumerAddress` varchar(100) DEFAULT NULL,
  `costumerEmail` varchar(100) DEFAULT NULL,
  `costumerPhonenumber` varchar(20) DEFAULT NULL,
  `costumerPhoto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `costumer`
--

INSERT INTO `costumer` (`costumerID`, `costumerName`, `costumerAddress`, `costumerEmail`, `costumerPhonenumber`, `costumerPhoto`) VALUES
(1, NULL, NULL, NULL, NULL, 'uploads/Store.jpg'),
(2, NULL, NULL, NULL, NULL, ''),
(3, NULL, NULL, NULL, NULL, ''),
(4, NULL, NULL, NULL, NULL, ''),
(5, NULL, NULL, NULL, NULL, ''),
(6, '', NULL, '', '0', ''),
(7, '', NULL, '', '0', ''),
(8, '', NULL, '', '0', ''),
(9, 'ian', 'prk 11 saray', 'godfredinadublin@gmail.com', '2147483647', ''),
(10, 'ian', 'prk 11 saray', 'godfredinadublin@gmail.com', '2147483647', ''),
(11, 'ian', 'prk 11 saray', 'godfredinadublin@gmail.com', '2147483647', 'uploads/Store.jpg'),
(12, 'Keth Alva L Bahian', 'prk 10-A Rosevelt Iligan City', 'kethalvabahian1101@gmail.com', '2147483647', ''),
(13, 'Keth Alva L Bahian', 'prk 10-A Rosevelt Iligan City', 'kethalvabahian1101@gmail.com', '2147483647', ''),
(14, 'Keth Alva L Bahian', 'prk 10-A Rosevelt Iligan City', 'kethalvabahian1101@gmail.com', '2147483647', ''),
(15, 'Keth Alva L Bahian', 'prk 10-A Rosevelt Iligan City', 'kethalvabahian1101@gmail.com', '09451405482', 'uploads/image_2025-12-04_153102078.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `totalAmount` double DEFAULT NULL,
  `orderDate` timestamp NOT NULL DEFAULT curdate(),
  `costumerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `totalAmount`, `orderDate`, `costumerID`) VALUES
(4, 60, '2025-12-04 00:07:30', NULL),
(5, 1440, '2025-12-04 00:10:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `orderItemID` int(11) NOT NULL,
  `OrderQuantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `ordersID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `productName` varchar(100) DEFAULT NULL,
  `productPrice` decimal(10,2) DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `productPhoto` varchar(250) DEFAULT NULL,
  `categoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `productPrice`, `productQuantity`, `productPhoto`, `categoryID`) VALUES
(7, 'Oishi Prawn Crackers', 123.00, 2232, 'uploads/image_2025-12-05_113726558.png', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `costumer`
--
ALTER TABLE `costumer`
  ADD PRIMARY KEY (`costumerID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `costumerID` (`costumerID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `ordersID` (`ordersID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `costumer`
--
ALTER TABLE `costumer`
  MODIFY `costumerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`costumerID`) REFERENCES `costumer` (`costumerID`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`ordersID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
