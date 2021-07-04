-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2021 at 01:54 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(13, 'Home Made', 'this is Good Gaming', 1, 1, 0, 0),
(14, 'Computers', 'this is Tools from Computers', 2, 0, 0, 0),
(15, 'Software', 'software About PC', 3, 0, 0, 0),
(16, 'Lessons', 'Lessons About programing', 4, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` datetime NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(13, 'Good Job', 1, '2021-06-29 16:07:55', 68, 123),
(14, 'this is comment from `PhpMyAdmin`', 1, '2021-06-29 16:07:55', 73, 123),
(15, 'this is comment now \r\n', 1, '2021-07-02 12:12:54', 70, 123),
(23, 'this is Fif\r\n', 1, '2021-07-02 12:44:24', 73, 123),
(26, 'this is Fif\r\n', 1, '2021-07-02 12:45:54', 73, 123),
(27, 'this is Omar By obeyda', 1, '2021-07-02 12:47:02', 74, 1),
(28, 'this is Obeyda By obeyda', 1, '2021-07-02 12:47:18', 73, 1),
(29, 'this is Obeyda\r\n By obeyda', 1, '2021-07-02 12:47:33', 68, 1),
(30, 'obeyda obeyda obeyda obeyda ', 0, '2021-07-02 12:55:35', 73, 123),
(31, 'this is by refresh ..?!?!?!', 0, '2021-07-02 12:56:18', 73, 123);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` datetime NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(68, 'iphone 12', 'from company  Apple', '$400', '2021-06-28 07:55:45', 'newYork', '', '2', 0, 1, 15, 1),
(69, 'windows 10', 'microsoft', '$200', '2021-06-28 07:58:22', 'Silicon Valley', '', '1', 0, 1, 15, 1),
(70, 'Kitchen & Dining', 'that priceless ', '$20', '2021-06-28 08:01:18', 'middle east', '', '2', 0, 0, 13, 123),
(71, 'lorem ipsum', 'Lorem ipsum, or lipsum as', '$00', '2021-06-28 15:11:19', 'lorem', '', '1', 0, 1, 13, 122),
(72, 'lorem ', 'Lorem ipsum, or lipsum', '$00', '2021-06-28 15:13:03', 'lorem ', '', '2', 0, 0, 13, 122),
(73, 'Lorem i', 'Lorem ipsum, or lipsum ', '$00', '2021-06-28 15:13:41', 'Lorem', '', '4', 0, 1, 14, 1),
(74, 'Lorem ip', 'Lorem ipsum, or lipsum ', '$00', '2021-06-28 15:14:36', 'lorem', '', '3', 0, 0, 15, 122),
(75, 'Lorem ipsu', 'Lorem ipsum, or lipsum a', '$00', '2021-06-28 15:15:04', 'lorem', '', '1', 0, 1, 14, 1),
(76, 'loremm', ' Lorem ipsum, or lipsum', '$00', '2021-06-28 15:16:27', 'lorem key', '', '2', 0, 1, 15, 123);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To identify User',
  `Username` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `FullName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identify User Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User Approval',
  `Date` datetime DEFAULT NULL,
  `Avatar` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `Avatar`) VALUES
(1, 'Obeyda', '64876ab0f960e7034b307618d59e186fa1f9ad02', 'aldersonzero@gmail.com', 'alderson', 1, 0, 1, NULL, ''),
(122, 'omar', '204c3309e0bc3f8bb0277fbaf7a530469723f0c7', 'Obeyda12@gmail.com', 'ObeydaSy', 0, 0, 0, '2021-06-27 16:57:08', ''),
(123, 'Osama', 'ddba63568c24101580331b8e85892421a59bed31', 'Osama@gmail.com', 'Osama12', 0, 0, 1, '2021-06-27 16:57:28', ''),
(124, 'osama12', 'c30c42c8064bae4d5c4004fae7cfd0858a1b9d91', 'osama@gmail.co', '', 0, 0, 0, '2021-06-30 19:00:29', ''),
(125, 'osama122121', '601f1889667efaebb33b8c12572835da3f027f78', 'osama@gmail.com', '', 0, 0, 1, '2021-06-30 19:01:47', ''),
(126, 'obeyda_Elliot', '2160041caea39bce103345d23d0dec3a8a5e9e22', 'obeyda@gmail.com', 'AldersonZero', 0, 0, 1, '2021-07-02 20:38:18', '88523134_90527835_1852543361546821_8988824942267072512_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `comment_user` (`user_id`),
  ADD KEY `comment_item` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `cat_1` (`Cat_ID`),
  ADD KEY `member_1` (`Member_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10042;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To identify User', AUTO_INCREMENT=127;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
