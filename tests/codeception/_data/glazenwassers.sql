-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2015 at 03:44 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `glazenwassers`
--

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE IF NOT EXISTS `district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `name`, `score`) VALUES
(2, 'scholen', 15),
(3, 'kerken', 20),
(4, 'centrum', 10),
(5, 'bushaltes', 50),
(6, 'componistenbuurt', 12),
(7, 'vinex', 82);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `members` varchar(255) NOT NULL,
  `start_score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `members`, `start_score`) VALUES
(3, 'team a', 'abcd', 300),
(4, 'team b', 'bcde', 300),
(5, 'team c', 'cdef', 300),
(6, 'team d', 'defg', 300);

-- --------------------------------------------------------

--
-- Table structure for table `grouptransaction`
--

CREATE TABLE IF NOT EXISTS `grouptransaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street_transaction_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trans_group_id` (`group_id`),
  KEY `trans_group_street_trans_id` (`street_transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1134 ;

--
-- Dumping data for table `grouptransaction`
--

INSERT INTO `grouptransaction` (`id`, `street_transaction_id`, `group_id`, `status`, `score`, `datetime`) VALUES
(1123, 8, 4, 6, 8, '2015-03-26 20:52:30'),
(1124, 9, 3, 2, -8, '2015-03-26 20:55:30'),
(1125, 9, 4, 0, 8, '2015-03-26 20:55:30'),
(1126, 10, 3, 6, 8, '2015-03-26 21:42:10'),
(1127, 11, 3, 6, 4, '2015-03-26 21:42:25'),
(1128, 12, 3, 6, 13, '2015-03-26 22:08:25'),
(1129, 13, 3, 6, 8, '2015-03-29 15:35:40'),
(1130, 14, 4, 2, -8, '2015-03-29 15:36:10'),
(1131, 14, 3, 0, 8, '2015-03-29 15:36:10'),
(1132, 15, 5, 6, 7, '2015-03-29 15:36:20'),
(1133, 16, 5, 6, 4, '2015-03-29 15:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m150224_193333_create_new_tables', 1426173772);

-- --------------------------------------------------------

--
-- Table structure for table `street`
--

CREATE TABLE IF NOT EXISTS `street` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `district_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `street_district_id` (`district_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `street`
--

INSERT INTO `street` (`id`, `name`, `district_id`, `score`) VALUES
(2, 'basisschool', 2, 8),
(3, 'middelbareschool', 2, 9),
(4, 'martinuskerk', 3, 11),
(5, 'franciscuskerk', 3, 11),
(6, 'plein', 4, 7),
(7, 'markt', 4, 7),
(8, 'bushalte a', 5, 4),
(9, 'bushalte b', 5, 4),
(10, 'bushalte c', 5, 4),
(11, 'bushalte d', 5, 4),
(12, 'bachlaan', 6, 13),
(13, 'ravelstraat', 6, 13);

-- --------------------------------------------------------

--
-- Table structure for table `streettransaction`
--

CREATE TABLE IF NOT EXISTS `streettransaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trans_street_group_id` (`group_id`),
  KEY `trans_street_street_id` (`street_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `streettransaction`
--

INSERT INTO `streettransaction` (`id`, `street_id`, `group_id`, `status`, `start_datetime`, `end_datetime`) VALUES
(8, 2, 4, 0, '2015-03-26 20:52:30', '2015-03-26 21:07:30'),
(9, 2, 3, 4, '2015-03-26 20:55:30', '0000-00-00 00:00:00'),
(10, 2, 3, 0, '2015-03-26 21:42:10', '2015-03-26 21:57:10'),
(11, 11, 3, 0, '2015-03-26 21:42:25', '2015-03-26 21:57:25'),
(12, 13, 3, 0, '2015-03-26 22:08:25', '2015-03-26 22:23:25'),
(13, 2, 3, 1, '2015-03-29 15:35:40', '2015-03-29 15:50:40'),
(14, 2, 4, 4, '2015-03-29 15:36:10', '0000-00-00 00:00:00'),
(15, 7, 5, 0, '2015-03-29 15:36:20', '2015-03-29 15:51:20'),
(16, 8, 5, 0, '2015-03-29 15:36:30', '2015-03-29 15:51:30');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grouptransaction`
--
ALTER TABLE `grouptransaction`
  ADD CONSTRAINT `trans_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `trans_group_street_trans_id` FOREIGN KEY (`street_transaction_id`) REFERENCES `streettransaction` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `street`
--
ALTER TABLE `street`
  ADD CONSTRAINT `street_district_id` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `streettransaction`
--
ALTER TABLE `streettransaction`
  ADD CONSTRAINT `trans_street_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `trans_street_street_id` FOREIGN KEY (`street_id`) REFERENCES `street` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
