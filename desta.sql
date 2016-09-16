-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2016 at 11:57 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `desta`
--

-- --------------------------------------------------------

--
-- Table structure for table `photodetails`
--

CREATE TABLE IF NOT EXISTS `photodetails` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
  `mobileNo` varchar(12) NOT NULL,
  `photoPath` varchar(100) NOT NULL,
  `photoCategory` varchar(100) NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `photodetails`
--

INSERT INTO `photodetails` (`photoId`, `mobileNo`, `photoPath`, `photoCategory`, `post_date`) VALUES
(2, '2', '../images/dysp.jpg', 'Dog', '2016-09-02 23:36:43'),
(3, '2', '../images/img043.jpg', 'Dog', '2016-09-02 23:36:43'),
(4, '2', '../images/P_20160305_190416_1.jpg', 'Dog', '2016-09-02 23:36:43'),
(5, '2', '../images/P_20160305_193623_1.jpg', 'Dog', '2016-09-02 23:36:43'),
(6, '4', '../images/1day.jpg', 'Bird', '2016-09-03 11:59:18'),
(7, '4', '../images/276.jpg', 'Bird', '2016-09-03 11:59:18'),
(8, '4', '../images/277.gif', 'Bird', '2016-09-03 11:59:18'),
(9, '4', '../images/284.jpg', 'Bird', '2016-09-03 11:59:18'),
(10, '4', '../images/10072_413646898730948_353569269_n.jpg', 'Bird', '2016-09-03 11:59:18'),
(11, '5', '../images/8encourage.jpg', 'Cat', '2016-09-03 14:23:41'),
(12, '5', '../images/7446.JPG', 'Cat', '2016-09-03 14:23:41'),
(13, '5', '../images/14173_244477765707258_1019775632_n.jpeg', 'Cat', '2016-09-03 14:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE IF NOT EXISTS `userdetails` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `mobileNo` varchar(12) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `mobileNo` (`mobileNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`userId`, `name`, `state`, `mobileNo`) VALUES
(2, 'Pratik Sonawane', 'Maharashtra', '2'),
(4, 'Sanket Dhotre', 'Goa', '4'),
(5, 'Hrishi', '', '5'),
(6, 'roshan', '', '6');

-- --------------------------------------------------------

--
-- Table structure for table `votedetails`
--

CREATE TABLE IF NOT EXISTS `votedetails` (
  `voteId` int(11) NOT NULL AUTO_INCREMENT,
  `photoId` int(11) NOT NULL,
  `photoCategory` varchar(100) NOT NULL,
  `mobileNo` varchar(12) NOT NULL,
  PRIMARY KEY (`voteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `votedetails`
--

INSERT INTO `votedetails` (`voteId`, `photoId`, `photoCategory`, `mobileNo`) VALUES
(3, 5, 'Dog', '2'),
(4, 11, 'Cat', '2'),
(5, 11, 'Cat', '4'),
(6, 7, 'Bird', '4'),
(7, 1, 'Dog', '4');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
