-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2025 at 06:58 PM
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
-- Database: `t3Final`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartItem`
--

CREATE TABLE `cartItem` (
  `cartId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `storeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemId` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemId`, `name`, `description`, `price`, `image`) VALUES
(1, 'Alpinestars Atom Race Suit', 'This feature packed entry level 2-layer suit is constructed using a 100% Aramidic twill outer shell with an Aramidic lining offering superb comfort and breathability with exceptional heat / flame protection. Fully floating arms combined with stretch panels on the lower back and crotch areas allow for increased flexibility while pre-curved arms and legs provide optimum comfort in the driving position. The ergonomic collar features a soft stretchable insert for extended protection and maximum driver comfort and an adjustable waist belt provides a precise fit.', 560.91, 'alpinestarsAtom.webp'),
(2, 'Bell HP77 Evo IV', 'Bell HP77 Evo IV Carbon Helmet takes helmet safety to the next level. This helmet meets the ultimate standard FIA 8860-2018 ABP (Advanced Ballistic Protection) which has been in Formula One since 2019. This standard has been created as a result of a decade of research to further increase safety making this Bell\'s safest helmet.', 5632.17, 'bellHP77.webp'),
(3, 'Alpinestars Tech 1 Race V4', 'The Alpinestars Tech 1 Race V4 gloves are constructed using a flame resistant aramidic fibre with an extended cuff design to provide the highest levels of protection to the wearer. This protection coupled with the superb levels of comfort and grip provide the ideal balance of performance and affordability for the savvy racers who want the best \'bang for their buck\'.\r\n\r\nTake the next step in upgrading your racing attire. The Alpinestars tech 1 Race V4 gloves are perfect for progressing your race experience. Secure your pair today and feel the difference in your next race.', 148.16, 'alpinestarsTech1.webp'),
(4, 'Alpinestars Supermoto V2', 'The boot retains its patented one-piece, supple leather upper but now has a more contoured, sculpted shape which adapts better to the lines of the foot for improved feel. The quick lace system with hook and loop strap closure, not only reduces weight but also ensures a personalised fit like no other. Perforation zones provide optimal ventilation, and a new elastic collar delivers unsurpassed levels of comfort. Micro-porous padding around the heel and insole absorb shocks and vibrations to reduce fatigue and the exclusive, F1 derived thin rubber sole provides the perfect balance of grip and pedal sensitivity.', 359.83, 'alpinestarsSupermotoV2.webp'),
(5, 'Hans IV', 'The ergonomic design of the hans IV, with its re-engineered shape and taller wings, delivers essential comfort and secure harness retention during races where precise focus is paramount. Its 10% lighter construction reduces strain in longer stints, keeping you agile and minimising fatigue in intense driving scenarios. Foam compound pads ensure a supportive fit that blends comfort and durability, making it ideal for high-pressure moments in rallying or circuit racing. Sliding tethers provide critical freedom of movement, ensuring you stay responsive and adaptable to dynamic racing conditions.\r\n\r\nExperience the perfect balance of comfort, safety, and affordability with the hans IV. With its FIA-approved design and innovative features, this FHR device offers the reliability and performance you need without breaking the bank.', 364.43, 'hansIV.webp');

-- --------------------------------------------------------

--
-- Table structure for table `itemStore`
--

CREATE TABLE `itemStore` (
  `storeId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itemStore`
--

INSERT INTO `itemStore` (`storeId`, `itemId`, `quantity`) VALUES
(1, 1, 91),
(2, 1, 54),
(1, 2, 99),
(2, 2, 86),
(1, 3, 93),
(2, 3, 49),
(1, 4, 5),
(2, 4, 56),
(1, 5, 5),
(2, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `storeId` int(11) NOT NULL,
  `address` text NOT NULL,
  `manager` text NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`storeId`, `address`, `manager`, `phone`) VALUES
(1, '32112 Montgomery Dr. Magna, UT', 'Gregith Bartford', '(385) 883-4519'),
(2, '844732 Windale Ave. Newport News, VA', 'Edith Vespharn', '(757) 898-7087');

-- --------------------------------------------------------

--
-- Table structure for table `userCart`
--

CREATE TABLE `userCart` (
  `userId` int(11) NOT NULL,
  `cartId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`storeId`);

--
-- Indexes for table `userCart`
--
ALTER TABLE `userCart`
  ADD PRIMARY KEY (`cartId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `storeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userCart`
--
ALTER TABLE `userCart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
