-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 05, 2013 at 11:46 AM
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
-- Table structure for table `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'Admin', 1, 14),
(2, 1, NULL, NULL, 'Admin.ActionLog', 2, 3),
(3, 1, NULL, NULL, 'Admin.ControlObject', 4, 5),
(4, 1, NULL, NULL, 'Admin.FileUpload', 6, 7),
(5, 1, NULL, NULL, 'Admin.ItemReport', 8, 9),
(6, 1, NULL, NULL, 'Admin.ObjectPermission', 10, 11),
(7, 1, NULL, NULL, 'Admin.RequestObject', 12, 13),
(8, NULL, NULL, NULL, 'Core', 15, 20),
(9, 8, NULL, NULL, 'Core.UsersAppModel', 16, 17),
(10, 8, NULL, NULL, 'Core.User', 18, 19);

-- --------------------------------------------------------

--
-- Table structure for table `action_logs`
--

CREATE TABLE IF NOT EXISTS `action_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` smallint(6) NOT NULL DEFAULT '0',
  `model` varchar(100) DEFAULT NULL,
  `foreign_key` varchar(36) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'Administrator', 1, 6),
(2, 1, 'User', 525, '525ac11a-1ce4-4fcf-a462-1074788903e6', 2, 3),
(3, 1, 'User', 525, NULL, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 2, '1', '1', '1', '1'),
(2, 1, 3, '1', '1', '1', '1'),
(3, 1, 4, '1', '1', '1', '1'),
(4, 1, 5, '1', '1', '1', '1'),
(5, 1, 6, '1', '1', '1', '1'),
(6, 1, 7, '1', '1', '1', '1'),
(7, 1, 9, '1', '1', '1', '1'),
(8, 1, 10, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE IF NOT EXISTS `file_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `caption` text NOT NULL,
  `path` varchar(255) NOT NULL,
  `path_thumb` varchar(255) NOT NULL,
  `path_large` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `ext` varchar(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  `width` smallint(6) DEFAULT NULL,
  `height` smallint(6) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `item_reports`
--

CREATE TABLE IF NOT EXISTS `item_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reporter_id` int(11) DEFAULT NULL,
  `resolver_id` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL DEFAULT '0',
  `model` varchar(100) DEFAULT NULL,
  `foreign_key` varchar(36) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `reason` text,
  `comment` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reporter_id` (`reporter_id`),
  KEY `resolver_id` (`resolver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schema_migrations`
--

CREATE TABLE IF NOT EXISTS `schema_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `schema_migrations`
--

INSERT INTO `schema_migrations` (`id`, `class`, `type`, `created`) VALUES
(1, 'InitMigrations', 'Migrations', '2013-10-13 14:57:57'),
(2, 'ConvertVersionToClassNames', 'Migrations', '2013-10-13 14:57:57'),
(3, 'IncreaseClassNameLength', 'Migrations', '2013-10-13 14:57:57'),
(4, 'Emptydb', 'app', '2013-10-13 14:58:23'),
(5, 'M49c3417a54874a9d276811502cedc421', 'Users', '2013-10-13 14:59:40'),
(6, 'M4ef8ba03ff504ab2b415980575f6eb26', 'Users', '2013-10-13 14:59:40');

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
  `attribs` text NOT NULL COMMENT 'misc attributes like color scheme etc',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `users_id`, `title`, `desc`, `start_date`, `end_date`, `attribs`) VALUES
(1, '525abf41-447c-4ede-a7ee-1074788903e6', 'TEST', 'TEST ITEM', '2013-11-06 00:00:00', '2013-11-07 00:00:00', ''),
(2, '525abf41-447c-4ede-a7ee-1074788903e6', 'TEST 2', 'TEST ITEM 2', '2013-11-05 11:00:00', '2013-11-05 12:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(36) NOT NULL,
  `username` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `password_token` varchar(128) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT '0',
  `email_token` varchar(255) DEFAULT NULL,
  `email_token_expires` datetime DEFAULT NULL,
  `tos` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_action` datetime DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `role` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `BY_USERNAME` (`username`),
  KEY `BY_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `slug`, `password`, `password_token`, `email`, `email_verified`, `email_token`, `email_token_expires`, `tos`, `active`, `last_login`, `last_action`, `is_admin`, `role`, `created`, `modified`) VALUES
('525abf41-447c-4ede-a7ee-1074788903e6', 'abrar', 'abrar', '1306d87df0130193d7a4d0581af8cce1ed38aa74', NULL, 'abrar.aamer@uta.fi', 1, 'jkwxgmld9o', '2013-10-14 15:41:53', 1, 1, '2013-11-05 11:24:37', NULL, 0, 'registered', '2013-10-13 15:41:53', '2013-11-05 11:24:37'),
('525ac11a-1ce4-4fcf-a462-1074788903e6', 'admin', 'admin', '1306d87df0130193d7a4d0581af8cce1ed38aa74', NULL, 'admin@localhost.com', 1, '7fdwcrz9mn', '2013-10-14 15:49:46', 1, 1, '2013-11-03 15:31:23', NULL, 1, 'admin', '2013-10-13 15:49:46', '2013-11-03 15:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `position` float NOT NULL DEFAULT '1',
  `field` varchar(60) NOT NULL,
  `value` text,
  `input` varchar(16) NOT NULL,
  `data_type` varchar(16) NOT NULL,
  `label` varchar(128) NOT NULL DEFAULT '',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_PROFILE_PROPERTY` (`field`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
