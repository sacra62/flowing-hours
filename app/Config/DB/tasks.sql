-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2013 at 11:09 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `flowing_hours`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` varchar(36) NOT NULL,
  `title` varchar(256) NOT NULL,
  `desc` text,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '(1- done/0 - unfinished)',
  `estimated_hours` int(3) NOT NULL DEFAULT '0',
  `reported_hours` int(3) NOT NULL DEFAULT '0',
  `attribs` text NOT NULL COMMENT 'misc attributes like color scheme etc',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `users_id`, `title`, `desc`, `start_date`, `end_date`, `status`, `estimated_hours`, `reported_hours`, `attribs`) VALUES
(1, '525abf41-447c-4ede-a7ee-1074788903e6', 'Meeting with the team', 'Simply meet up with the team and decide on the future tasks.', '2013-11-06 00:00:00', '2013-11-07 00:00:00', 0, 0, 0, ''),
(2, '525abf41-447c-4ede-a7ee-1074788903e6', 'Completing the tasks before the meeting', 'Complete all the pending tasks as quickly as possible.', '2013-11-05 11:00:00', '2013-11-05 12:00:00', 0, 0, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
